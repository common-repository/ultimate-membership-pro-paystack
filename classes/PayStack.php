<?php
namespace UmpPayStack;

class PayStack extends \Indeed\Ihc\Gateways\PaymentAbstract
{

    protected $paymentType                    = 'ump_paystack'; // slug. cannot be empty.

    protected $paymentRules                   = [
                'canDoRecurring'						                  => false, // does current payment gateway supports recurring payments.
                'canDoTrial'							                    => false, // does current payment gateway supports trial subscription
                'canDoTrialFree'						                  => false, // does current payment gateway supports free trial subscription
                'canApplyCouponOnRecurringForFirstPayment'		=> false, // if current payment gateway support coupons on recurring payments only for the first transaction
                'canApplyCouponOnRecurringForFirstFreePayment'=> false, // if current payment gateway support coupons with 100% discount on recurring payments only for the first transaction.
                'canApplyCouponOnRecurringForEveryPayment'	  => true, // if current payment gateway support coupons on recurring payments for every transaction
                'paymentMetaSlug'                             => 'ump_paystack', // payment gateway slug. exenple: paypal, stripe, etc.
                'returnUrlAfterPaymentOptionName'             => 'ump_paystack-return_page', // option name ( in wp_option table ) where it's stored the return URL after a payment is done.
                'returnUrlOnCancelPaymentOptionName'          => '', // option name ( in wp_option table ) where it's stored the return URL after a payment is canceled.
                'paymentGatewayLanguageCodeOptionName'        => '', // option name ( in wp_option table ) where it's stored the language code.
    ]; // some payment does not support all our features
    protected $intervalSubscriptionRules      = [
                'daysSymbol'               => 'daily',
                'weeksSymbol'              => 'weekly',
                'monthsSymbol'             => 'monthly',
                'yearsSymbol'              => 'quarterly',
                'daysSupport'              => true,
                'daysMinLimit'             => 1,
                'daysMaxLimit'             => 1,
                'weeksSupport'             => true,
                'weeksMinLimit'            => 1,
                'weeksMaxLimit'            => 1,
                'monthsSupport'            => true,
                'monthsMinLimit'           => 1,
                'monthsMaxLimit'           => 1,
                'yearsSupport'             => true,
                'yearsMinLimit'            => 1,
                'yearsMaxLimit'            => 1,
                'maximumRecurrenceLimit'   => 52, // leave this empty for unlimited
                'minimumRecurrenceLimit'   => 2,
                'forceMaximumRecurrenceLimit'   => false,
    ];
    protected $intervalTrialRules             = [
                              'daysSymbol'               => '',
                              'weeksSymbol'              => '',
                              'monthsSymbol'             => '',
                              'yearsSymbol'              => '',
                              'supportCertainPeriod'     => false,
                              'supportCycles'            => false,
                              'cyclesMinLimit'           => 1,
                              'cyclesMaxLimit'           => '',
                              'daysSupport'              => false,
                              'daysMinLimit'             => 1,
                              'daysMaxLimit'             => 90,
                              'weeksSupport'             => false,
                              'weeksMinLimit'            => 1,
                              'weeksMaxLimit'            => 52,
                              'monthsSupport'            => true,
                              'monthsMinLimit'           => 1,
                              'monthsMaxLimit'           => 24,
                              'yearsSupport'             => false,
                              'yearsMinLimit'            => 1,
                              'yearsMaxLimit'            => 5,
    ];

    protected $stopProcess                    = false;
    protected $inputData                      = []; // input data from user
    protected $paymentOutputData              = [];
    protected $paymentSettings                = []; // api key, some credentials used in different payment types

    protected $paymentTypeLabel               = 'PayStack'; // label of payment
    protected $redirectUrl                    = ''; // redirect to payment gateway or next page
    protected $defaultRedirect                = ''; // redirect home
    protected $multiply                       = 100;
    protected $errors                         = [];

    /**
     * @param none
     * @return object
     */
    public function charge()
    {
        include_once UMP_PAYSTACK_PATH . 'classes/libs/autoload.php';
        $paystack = new \Yabacon\Paystack( $this->paymentSettings['ump_paystack-secret_key'] );
        if ( !$this->paymentOutputData['is_recurring'] ){
          $amount = $this->paymentOutputData['amount'] * $this->multiply;
          try {
            // single payment
            $transaction = $paystack->transaction->initialize([
              'amount'        => $amount,    // in kobo
              'email'         => $this->paymentOutputData['customer_email'],     // unique to customers
              'reference'     => $this->paymentOutputData['order_identificator'], // unique to transactions
              'callback_url'  => $this->returnUrlAfterPayment,
            ]);
          } catch ( \Yabacon\Paystack\Exception\ApiException $e ){
              return $this;
          }

          // redirect to page so User can pay
          $this->redirectUrl = isset( $transaction->data->authorization_url ) ? $transaction->data->authorization_url : '';

        }
        return $this;

    }

    /**
     * @param none
     * @return none
     */
    public function webhook()
    {
        $input = @file_get_contents("php://input");
        if ( !isset( $this->paymentSettings['ump_paystack-secret_key'] ) ){
            $this->paymentSettings['ump_paystack-secret_key'] = get_option( 'ump_paystack-secret_key', '' );
        }

        $response = json_decode($input);
        //file_put_contents( UMP_PAYSTACK_PATH . 'webhook-logs.log', serialize( $response ) . '####', FILE_APPEND );

        if ( empty( $response ) ){
              _e( '<p>============= Ultimate Membership Pro - PAYSTACK Webhook =============</p> ', 'ultimate-membership-pro-payfast');
              _e( '<p>No Payments details sent. Come later</p>', 'ultimate-membership-pro-payfast');
            exit;
        }

        $bank = isset( $response->authorization->receiver_bank ) ? sanitize_text_field( $response->authorization->receiver_bank ) : '';
        $orderIdentificator = isset( $response->data->reference ) ? sanitize_text_field( $response->data->reference ) : '';
        $email = isset( $response->data->customer->email ) ? sanitize_text_field( $response->data->customer->email ) : '';
        $amount = isset( $response->data->amount ) ? sanitize_text_field( $response->data->amount ): 0;
        $currency = isset( $response->data->currency ) ? sanitize_text_field( $response->data->currency ) : '';
        $transactionId = isset( $response->data->id ) ? sanitize_text_field( $response->data->id ) : '';

        if ( $amount > 0 ){
          $amount = $amount / $this->multiply;
        }

        $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
        $orderId = $orderMeta->getIdFromMetaNameMetaValue( 'order_identificator', $orderIdentificator );
        if ( !isset($orderId) || $orderId == false ){
            // out
            $this->webhookData['payment_status'] = 'other';
            return;
        }

        $orderObject = new \Indeed\Ihc\Db\Orders();
        $orderData = $orderObject->setId( $orderId )
                                 ->fetch()
                                 ->get();


        http_response_code(200); // PHP 5.4 or greater
        flush();
        $this->webhookData = [
                                'transaction_id'              => '',
                                'uid'                         => '',
                                'lid'                         => '',
                                'order_identificator'         => '',
                                'amount'                      => '',
                                'currency'                    => '',
                                'payment_details'             => '',
                                'payment_status'              => '',
        ];
        switch ( $response->event ){
            case 'subscription.create':

              break;
            case 'charge.success':
            $this->webhookData = [
                                    'transaction_id'              => $transactionId,
                                    'uid'                         => isset( $orderData->uid ) ? $orderData->uid : 0,
                                    'lid'                         => isset( $orderData->lid ) ? $orderData->lid : 0,
                                    'order_identificator'         => $orderIdentificator,
                                    'amount'                      => $amount,
                                    'currency'                    => $currency,
                                    'payment_details'             => $response,
                                    'payment_status'              => 'completed',
            ];

             break;
            case 'subscription.disable':

              break;
        }



    }

    /**
     * @param int
     * @param int
     * @param string
     * @return none
     */
    public function canDoCancel( $uid=0, $lid=0, $subscriptionId='' )
    {
        if ( isset( $subscriptionId ) && $subscriptionId !== '' ){
            //

        }
        return false;
    }


    /**
     * @param int
     * @param int
     * @param string
     * @return none
     */
    public function cancel( $uid=0, $lid=0, $transactionId='' )
    {
        if ( !$transactionId ){
            return false;
        }
        $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
        $orderId = $orderMeta->getIdFromMetaNameMetaValue( 'transaction_id', $transactionId );
        if ( $orderId ){
            $subscriptionId = $orderMeta->get( $orderId, 'subscription_id' );
        }
        if ( isset( $subscriptionId ) && $subscriptionId !== '' ){

        }
        return false;
    }


}

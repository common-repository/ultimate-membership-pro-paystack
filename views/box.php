<?php $pay_stat = ihc_check_payment_status( $data['slug'] ); ?>
<div class="iump-payment-box-wrap">
   <a href="<?php esc_html_e( admin_url( 'admin.php?page=ihc_manage&tab=ump_paystack' ));?>">
      <div class="iump-payment-box <?php esc_html_e( $data['pay_stat']['active']); ?>">
          <div class="iump-payment-box-title">Paystack</div>
          <div class="iump-payment-box-type"><?php _e( 'Paystack - OffSite payment solution', 'ultimate-membership-pro-paystack' );?></div>
          <div class="iump-payment-box-bottom"><?php _e( 'Settings:', 'ultimate-membership-pro-paystack' );?> <span><?php esc_html_e( $data['pay_stat']['settings']); ?></span></div>
      </div>
   </a>
</div>

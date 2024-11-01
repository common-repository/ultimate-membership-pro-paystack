<?php
namespace UmpPayStack;

class Settings
{
    /**
     * Modify this array with your custom values
     * @var array
     */
    private $data = [

    										'lang_domain'				=> 'ultimate-membership-pro-paystack',
    										'slug'							=> 'ump_paystack',
    										'name'						  => 'Paystack',
    										'description'				=> 'Extend Ultimate Membership Pro systems with extra features and functionality',
                        'ump_min_version'		=> '10.10',
    ];
    /**
     * Initialized automaticly. don't edit this array
     * @var array
     */
    private $paths = [
                      'dir_path'					=> '',
                      'dir_url'						=> '',
                      'plugin_base_name'	=> '',
    ];

    /**
     * @param none
     * @return none
     */
    public function __construct()
    {
        $this->setPaths();
        add_filter( 'ihc_default_options_group_filter', [ $this, 'options' ], 1, 2 );
    }



  /**
    * @param array
    * @param string
    * @return array
    */
    public function options( $options=[], $type='' )
    {
        if ( $this->data['slug']== $type ){
            return [
                'ump_paystack-enabled'         		     => 0,
                'ump_paystack-secret_key'        	     => '',
                'ump_paystack-return_page'             => 0,
                'ump_paystack-cancel_page'             => 0,
                'ihc_ump_paystack_label'               => 'PayStack',
                'ihc_ump_paystack_select_order'        => 10,
                'ihc_ump_paystack_short_description'   => '',
            ];
        }
        return $options;
    }

    /**
     * @param none
     * @return none
     */
    public function setPaths()
    {
        $this->paths['dir_path'] = plugin_dir_path( __FILE__ );
        $this->paths['dir_path'] = str_replace( 'classes/', '', $this->paths['dir_path'] );

        $this->paths['dir_url'] = plugin_dir_url( __FILE__ );
        $this->paths['dir_url'] = str_replace( 'classes/', '', $this->paths['dir_url'] );

        $this->paths['plugin_base_name'] = dirname(plugin_basename( __FILE__ ));
        $this->paths['plugin_base_name'] = str_replace( 'classes', '', $this->paths['plugin_base_name'] );
    }

    /**
     * @param string
     * @return object
     */
    public function get()
    {
        return $this->data + $this->paths;
    }

    /**
     * @param none
     * @return string
     */
    public function getPluginSlug()
    {
        return $this->data['slug'];
    }
}

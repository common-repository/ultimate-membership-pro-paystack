<?php
do_action( 'ump_admin_after_top_menu_add_ons' );
$pluginSlug = $data['plugin_slug'];
?>
<form action="" method="post">

	<div class="ihc-stuffbox">
		<?php if( defined( 'UMP_PAYSTACK_PRO' ) && UMP_PAYSTACK_PRO ): ?>
		<h3 class="ihc-h3"><?php esc_html_e('Paystack Pro Payment Service', 'ultimate-membership-pro-paystack');?></h3>
	<?php else : ?>
		<h3 class="ihc-h3"><?php esc_html_e('Paystack Payment Service', 'ultimate-membership-pro-paystack');?></h3>
	<?php endif;?>
		<div class="inside">
				<div class="iump-form-line" >
					<h2><?php  esc_html_e('Activate ', 'ultimate-membership-pro-paystack' );?> Paystack <?php esc_html_e(' Payment Service ', 'ultimate-membership-pro-paystack' );?></h2>

					<label class="iump_label_shiwtch iump_checkbox">
							<?php $checked = ($data[ 'ump_paystack-enabled' ]) ? 'checked' : '';?>
							<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ump_paystack-enabled');" <?php esc_html_e($checked);?> />
							<div class="switch"></div>
					</label>
					<p><?php esc_html_e('Once all Settings are properly done, activate the Payment Service for further use.', 'ultimate-membership-pro-paystack');?> </p>

					<input type="hidden" name="ump_paystack-enabled" value="<?php esc_html_e($data['ump_paystack-enabled']);?>" id="ump_paystack-enabled" />
				</div>

				<?php if ( defined('UMP_PAYSTACK_PRO') && UMP_PAYSTACK_PRO ): ?>
					<div class="iump-form-line">
					<!-- pro version description -->
					<h4>Paystack Pro <?php  esc_html_e(' Capabilities', 'ultimate-membership-pro-paystack');?></h4>
					<ul class="ihc-payment-capabilities-list">
						<li><?php _e('To receive payments using Paystack for the goods or services that you sell, you require a bank account located on the territory of one of the following countries: <b>Ghana</b>, <b>Nigeria</b> or <b>South Africa</b>.', 'ultimate-membership-pro-paystack');?></li>
						<li><?php _e('Paystack support <b>recurring</b> and <b>one-time</b> payments.', 'ultimate-membership-pro-paystack');?></li>
						<li><?php _e('Paystack is made for businesses based in one of the countries <b>South Africa</b>, <b>Ghana</b>, <b>Nigeria</b>.', 'ultimate-membership-pro-paystack');?></li>
						<li><?php _e('The bank account of the merchant must be in one of the currencies <code>ZAR(R)</code>, <code>GHS</code>, <code>NGN</code>.', 'ultimate-membership-pro-paystack');?></li>
						<li><?php _e('Paystack support coupons for one-time payments.', 'ultimate-membership-pro-paystack');?></li>
						<li><?php _e('Paystack support coupons for recurring payments.', 'ultimate-membership-pro-paystack');?></li>
					</ul>
					</div>
					<!-- end of pro version description -->
				<?php else : ?>
					<!-- free version description -->
					<div class="iump-form-line">
					<h4>Paystack <?php  esc_html_e(' Capabilities', 'ultimate-membership-pro-paystack');?></h4>
					<ul class="ihc-payment-capabilities-list">
						<li><?php _e('To receive payments using Paystack for the goods or services that you sell, you require a bank account located on the territory of one of the following countries: <b>Ghana</b>, <b>Nigeria</b> or <b>South Africa</b>.', 'ultimate-membership-pro-paystack');?></li>
						<li><?php _e('Paystack support only <b>one-time</b> or <b>limited payments</b>.', 'ultimate-membership-pro-paystack');?></li>
						<li><?php _e('Paystack is made for businesses based in one of the countries <b>South Africa</b>, <b>Ghana</b>, <b>Nigeria</b>.', 'ultimate-membership-pro-paystack');?></li>
						<li><?php _e('The bank account of the merchant must be in one of the currencies <code>ZAR(R)</code>, <code>GHS</code>, <code>NGN</code>.', 'ultimate-membership-pro-paystack');?></li>
						<li><?php _e('Paystack support coupons for one-time payments.', 'ultimate-membership-pro-paystack');?></li>
					</ul>

					<div class="ihc-alert-warning"><?php _e('To handle recurring Subscriptions management and charge recurring Payments, you must install the <b>Paystack Pro</b> version, which is available ', 'ultimate-membership-pro-paystack');?><a href="https://store.wpindeed.com/addon/paystack-pro-payment-gateway/" target="_blank"><?php esc_html_e(' here', 'ultimate-membership-pro-paystack');?>.</a></div>
					</div>
					<!-- end of free version description -->
				<?php endif;?>

				<div class="ihc-wrapp-submit-bttn iump-submit-form">
						<input id="ihc_submit_bttn" type="submit" value="<?php _e('Save Changes', 'ultimate-membership-pro-paystack' );?>" name="ihc_save" class="button button-primary button-large" />
				</div>

			</div>
		</div>

		<div class="ihc-stuffbox">
				<h3 class="ihc-h3"><?php esc_html_e('Paystack Settings', 'ultimate-membership-pro-paystack');?></h3>
				<div class="inside">
						<div class="iump-form-line">
							<div class="row ihc-row-no-margin">
							<div class="col-xs-5 ihc-col-no-padding">
								<div class="input-group iump-no-border"><span class="input-group-addon"><?php  esc_html_e( 'Secret Key', 'ultimate-membership-pro-paystack' );?></span>
								<input class="form-control" type="text" name="ump_paystack-secret_key" value="<?php esc_html_e($data['ump_paystack-secret_key']);?>" />
						</div>
						<div class="iump-ump_paystack-info-box"><?php _e('Note that when your business is in <b>Live Mode</b>, you may use <b>Live Secret Key</b>', 'ultimate-membership-pro-paystack');?></div>
					</div>
						</div>


						<div class="ihc-admin-register-margin-bottom-space"></div>
						<div class="row ihc-row-no-margin">
						 <div class="col-xs-5 ihc-col-no-padding">
								 <b><?php esc_html_e('Redirect Page after Payment:', 'ultimate-membership-pro-paystack');?></b>
								<div class="input-group">
								<select name="ump_paystack-return_page" class="form-control">
									<option value="-1" <?php if ( $data['ump_paystack-return_page'] == -1 ) esc_html_e('selected');?> >...</option>
									<?php
										if($data['pages']){
											foreach ( $data['pages'] as $k => $v ){
												?>
													<option value="<?php esc_html_e($k);?>" <?php if ( $data['ump_paystack-return_page'] == $k ){ esc_html_e('selected'); }?> ><?php esc_html_e($v);?></option>
												<?php
											}
										}
									?>
								</select>
							</div>
							</div>
							</div>

							 <?php
									 $siteUrl = site_url();
									 $siteUrl = trailingslashit( $siteUrl );
									 $notifyUrl = add_query_arg( 'ihc_action', 'ump_paystack', $siteUrl );
							 ?>
							 <ul class="ihc-payment-capabilities-list">
								 	<li><?php esc_html_e('Log in to ', 'ultimate-membership-pro-paystack');?> <a target="_blank" href="https://paystack.com">paystack.com</a></li>
									<li><?php _e("Go to <b>Settings</b>-><b>API Keys & Webhooks</b> and you will find <code>Secret Key</code>.", "ultimate-membership-pro-paystack");?></li>
									<li><?php _e("If your business is in <b>test mode</b> you may use <code>Test Secret Key</code> in order to perform some test payments.", "ultimate-membership-pro-paystack");?></li>
									<li><?php _e("In <code>Webhook URL</code> you may set your webhook:", "ultimate-membership-pro-paystack");?> <b><?php esc_html_e($notifyUrl);?></b></li>
							 </ul>

						</div>
						<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input id="ihc_submit_bttn" type="submit" value="<?php _e('Save Changes', 'ultimate-membership-pro-paystack' );?>" name="ihc_save" class="button button-primary button-large" />
						</div>
						</div>
					</div>
						<div class="ihc-clear"></div>




			<div class="ihc-stuffbox">
					<h3 class="ihc-h3"><?php esc_html_e('Extra Settings:', 'ultimate-membership-pro-paystack');?></h3>
					<div class="inside">
						<div class="row ihc-row-no-margin">
								<div class="col-xs-4">
										<div class="iump-form-line iump-no-border input-group">
											<span class="input-group-addon"><?php esc_html_e('Label:', 'ultimate-membership-pro-paystack');?></span>
											<input type="text" name="ihc_ump_paystack_label" value="<?php esc_html_e( $data['ihc_ump_paystack_label'] );?>"  class="form-control" />
										</div>

										<div class="iump-form-line iump-no-border input-group">
											<span class="input-group-addon"><?php esc_html_e('Order:', 'ultimate-membership-pro-paystack');?></span>
											<input type="number" min="1" name="ihc_ump_paystack_select_order" value="<?php esc_html_e($data['ihc_ump_paystack_select_order']);?>" class="form-control" />
										</div>
								</div>
						</div>

						<div class="row ihc-row-no-margin">
								<div class="col-xs-4">
									 <div class="input-group">
									 		<h4><?php esc_html_e('Short Description', 'ultimate-membership-pro-paystack');?></h4>
										 	<textarea name="ihc_ump_paystack_short_description" class="form-control" rows="2" cols="125" placeholder="<?php esc_html_e('write a short description', 'ultimate-membership-pro-paystack');?>"><?php esc_html_e( isset( $data['ihc_ump_paystack_short_description'] ) ? stripslashes($data['ihc_ump_paystack_short_description']) : '');?></textarea>
								 	 </div>
								</div>
						</div>

						<div class="ihc-wrapp-submit-bttn iump-submit-form">
						 	<input id="ihc_submit_bttn" type="submit" value="<?php esc_html_e('Save Changes', 'ultimate-membership-pro-paystack');?>" name="ihc_save" class="button button-primary button-large" />
					 </div>
					</div>
			</div>

</form>
<?php

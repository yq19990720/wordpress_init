<?php 

if( !(defined('DIZA_WOOCOMMERCE_ACTIVED') && DIZA_WOOCOMMERCE_ACTIVED) || is_user_logged_in() ) return;

do_action( 'diza_woocommerce_before_customer_login_form' ); 
?>

<div id="custom-login-wrapper" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="btn-close" data-dismiss="modal"><i class="tb-icon tb-icon-cross2"></i></button>
            <div class="modal-body">

                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" class="active" href="#tab-customlogin"><i class="tb-icon tb-icon-user d-xl-none"></i><span class="diza-login"></span></a></li>

                    <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
                    <li><a data-toggle="tab" href="#tab-customregister"><i class="tb-icon tb-icon-pencil4 d-xl-none"></i><span class="diza-register"></span></a></li>
                    <?php endif; ?>

                </ul>

                <div class="tab-content clearfix">
                    <div id="tab-customlogin" class="tab-pane fade show active">
                        <form id="custom-login" class="ajax-auth" action="login" method="post">
                            <?php do_action( 'woocommerce_login_form_start' ); ?>
                            <h3 class="diza-login-text"></h3>
                            <p class="status"></p>  
                            <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>  
                            <input id="cus-username" type="text"  class="required form-control" name="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>">
                            <input id="cus-password" type="password"  class="required form-control" name="password" autocomplete="current-password">
                            
                            <div class="rememberme-wrapper">
                                <input name="rememberme" type="checkbox" id="cus-rememberme" value="forever">
                                <label for="cus-rememberme" class="diza-remember-me"></label>
                            </div>
                            <a id="pop_forgot" class="text-link diza-lost-pwd" href="/lost-password"></a>
                            <input class="submit_button" id="diza-submit-login" type="submit" >

                            <div class="clear"></div>
                            <?php do_action( 'woocommerce_login_form_end' ); ?>
                        </form>
                    </div>

                    <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
                    <div id="tab-customregister" class="tab-pane fade">
                        <form id="custom-register" class="ajax-auth"  action="register" method="post">
                            <?php do_action( 'woocommerce_register_form_start' ); ?>

                            <h3 class="register-text"></h3>
                            <p class="status"></p>
                            <?php wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>         
                            <input id="signonname" type="text"  name="signonname" class="required form-control" value="<?php echo ( ! empty( $_POST['signonname'] ) ) ? esc_attr( wp_unslash( $_POST['signonname'] ) ) : ''; ?>">
                            <input id="signonemail" type="text"  class="required email form-control" name="email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>">
                            <input id="signonpassword" type="password"  class="required form-control" name="signonpassword" autocomplete="new-password">
                            
                            <?php if( diza_tbay_get_config('show_confirm_password', true) ) : ?>
                                <input type="password" id="password2"  class="required form-control" name="password2" autocomplete="new-password">
                            <?php endif; ?>

                            <input class="submit_button" id="diza-submit-register" type="submit" >

                            <div class="clear"></div>
                            <?php do_action( 'diza_custom_woocommerce_register_form_end' ); ?>
                            <?php do_action( 'woocommerce_register_form_end' ); ?>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
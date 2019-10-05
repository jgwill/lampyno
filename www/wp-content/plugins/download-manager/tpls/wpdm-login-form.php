<?php if(!defined('ABSPATH')) die();
global $current_user;
if(!isset($params) || !is_array($params)) $params = array();
$regurl = get_option('__wpdm_register_url');
if($regurl > 0)
    $regurl = get_permalink($regurl);
$log_redirect =  $_SERVER['REQUEST_URI'];
if(isset($params['redirect'])) $log_redirect = esc_url($params['redirect']);
if(isset($_GET['redirect_to'])) $log_redirect = esc_url($_GET['redirect_to']);

$up = parse_url($log_redirect);
if(isset($up['host']) && $up['host'] != $_SERVER['SERVER_NAME']) $log_redirect = $_SERVER['REQUEST_URI'];

$log_redirect = strip_tags($log_redirect);

if(!isset($params['logo']) || $params['logo'] == '') $params['logo'] = get_site_icon_url();

?>
<div class="w3eden">
    <div id="wpdmlogin" <?php if(wpdm_query_var('action') == 'lostpassword') echo 'class="lostpass"'; ?>>
        <?php if(isset($params['logo']) && $params['logo'] != '' && !is_user_logged_in()){ ?>
            <div class="text-center wpdmlogin-logo">
                <a href="<?php echo home_url('/'); ?>"><img alt="Logo" src="<?php echo $params['logo'];?>" /></a>
            </div>
        <?php } ?>

        <?php if(\WPDM\Session::get('reg_warning')): ?>  <br>

            <div class="alert alert-warning" data-title="WARNING!" align="center" style="font-size:10pt;">
                <?php echo \WPDM\Session::get('reg_warning'); \WPDM\Session::clear('reg_warning'); ?>
            </div>

        <?php endif; ?>

        <?php if(\WPDM\Session::get( 'sccs_msg' )): ?><br>

            <div class="alert alert-success" data-title="DONE!" align="center" style="font-size:10pt;">
                <?php echo \WPDM\Session::get( 'sccs_msg' );  \WPDM\Session::clear( 'sccs_msg' ); ?>
            </div>

        <?php endif; ?>
        <?php if(is_user_logged_in()){
            ob_start();

            include wpdm_tpl_path("already-logged-in.php", WPDM_TPL_DIR, WPDM_TPL_FALLBACK);

            $message = ob_get_clean();
            do_action("wpdm_user_logged_in", $message);

        } else {


            if(wpdm_query_var('action') != 'lostpassword' && wpdm_query_var('action') != 'rp'){
                ?>

                <?php do_action("wpdm_before_login_form"); ?>


                <form name="loginform" id="loginform" action="" method="post" class="login-form" >

                    <input type="hidden" name="permalink" value="<?php the_permalink(); ?>" />

                    <?php global $wp_query; if(\WPDM\Session::get('login_error')) {  ?>
                        <div class="error alert alert-danger" >
                            <b><?php _e( "Login Failed!" , "download-manager" ); ?></b><br/>
                            <?php echo preg_replace("/<a.*?<\/a>\?/i","",\WPDM\Session::get('login_error')); \WPDM\Session::clear('login_error'); ?>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-user"></i></span>
                            <input placeholder="<?php _e( "Username or Email" , "download-manager" ); ?>" type="text" name="wpdm_login[log]" id="user_login" class="form-control input-lg required text" value="" size="20" tabindex="38" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-key"></i></span>
                            <input type="password" placeholder="<?php _e( "Password" , "download-manager" ); ?>" name="wpdm_login[pwd]" id="user_pass" class="form-control input-lg required password" value="" size="20" tabindex="39" />
                        </div>
                    </div>

                    <?php do_action("wpdm_login_form"); ?>
                    <?php do_action("login_form"); ?>

                    <div class="row login-form-meta-text text-muted" style="margin-bottom: 10px">
                        <div class="col-md-5"><label><input class="wpdm-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><?php _e( "Remember Me" , "download-manager" ); ?></label></div>
                        <div class="col-md-7 text-right"><label><a class="color-blue" href="<?php echo wpdm_lostpassword_url(); ?>"><?php _e( "Forgot Password?" , "download-manager" ); ?></a>&nbsp;</label></div>
                    </div>
                    <?php
                    $__wpdm_social_login = get_option('__wpdm_social_login');
                    $__wpdm_social_login = is_array($__wpdm_social_login)?$__wpdm_social_login:array();
                    ?>
                    <div class="row">
                        <div class="col-md-12"><button type="submit" name="wp-submit" id="loginform-submit" class="btn btn-block btn-primary btn-lg"><i class="fas fa-user-shield"></i> &nbsp;<?php _e( "Login" , "download-manager" ); ?></button></div>

                        <?php if($regurl != ''){ ?>
                            <div class="col-md-12"><br/><a href="<?php echo $regurl; ?>" name="wp-submit" id="loginform-submit" class="btn btn-block btn-link btn-xs wpdm-reg-link  color-primary"><?php _e( "Don't have an account yet?" , "download-manager" ); ?> <i class="fas fa-user-plus"></i> <?php _e( "Register Now" , "download-manager" ); ?></a></div>
                        <?php } ?>
                    </div>


                    <input type="hidden" name="redirect_to" value="<?php echo $log_redirect; ?>" />



                </form>



            <?php do_action("wpdm_after_login_form"); ?>


                <script>
                    jQuery(function ($) {
                        var llbl = $('#loginform-submit').html();
                        $('#loginform').submit(function () {
                            $('#loginform-submit').html("<i class='fa fa-spin fa-sync'></i> <?php _e( "Logging In..." , "download-manager" ); ?>");
                            $(this).ajaxSubmit({
                                success: function (res) {
                                    if (!res.match(/success/)) {
                                        $('form .alert-danger').hide();
                                        $('#loginform').prepend("<div class='alert alert-danger' data-title='<?php _e( "LOGIN FAILED!" , "download-manager" ); ?>'><?php _e( "Please re-check login info." , "download-manager" ); ?></div>");
                                        $('#loginform-submit').html(llbl);
                                    } else {
                                        location.href = "<?php echo $log_redirect; ?>";
                                    }
                                }
                            });
                            return false;
                        });

                        $('body').on('click', 'form .alert-danger', function(){
                            $(this).slideUp();
                        });

                    });
                </script>

            <?php } else {


            if(wpdm_query_var('action') == 'lostpassword'){
            ?>
                <form name="loginform" id="resetPassword" action="<?php echo admin_url('/admin-ajax.php?action=resetPassword'); ?>" method="post" class="login-form" >
                    <?php wp_nonce_field(NONCE_KEY,'__reset_pass' ); ?>
                    <h3 style="margin: 0"><?php _e( "Lost Password?" , "download-manager" ); ?></h3>
                    <p>
                        <?php _e('Please enter your username or email address. You will receive a link to create a new password via email.', 'download-manager'); ?>
                    </p>
                    <div class="form-group">
                        <input placeholder="<?php _e( "Username or Email" , "download-manager" ); ?>" type="text" name="user_login" id="user_login" class="form-control input-lg required text" value="" size="20" tabindex="38" />
                    </div>

                    <div class="form-group">
                        <button type="submit" name="wp-submit" id="resetPassword-submit" class="btn btn-block btn-info btn-lg"><i class="fa fa-key"></i> &nbsp; <?php _e( "Reset Password" , "download-manager" ); ?></button>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center small">
                            <a href="<?php echo home_url('/') ?>" class="color-info btn btn-link btn-xs"><i class="fab fa-fort-awesome-alt"></i> <?php _e("Home", "download-manager"); ?></a> <span class="text-muted">&nbsp; </span>
                            <a href="<?php echo wpdm_login_url(); ?>" class="color-info btn btn-link btn-xs"><i class="fa fa-lock"></i> <?php _e("Login", "download-manager");  ?></a> <span class="text-muted">&nbsp; </span>
                            <a href="<?php echo wpdm_registration_url(); ?>" class="color-info btn btn-link btn-xs"><i class="fa fa-user-plus"></i> <?php _e("Register", "download-manager");  ?></a>
                        </div>
                    </div>

                </form>
                <script>
                    jQuery(function ($) {
                        var llbl = $('#resetPassword-submit').html();
                        $('#resetPassword').submit(function () {
                            $('#resetPassword-submit').html("<i class='fa fa-spin fa-sync'></i> <?php _e( "Please Wait..." , "download-manager" ); ?>");
                            $(this).ajaxSubmit({
                                success: function (res) {

                                    if (res.match(/error/)) {
                                        $('form .alert').hide();
                                        $('#resetPassword').prepend("<div class='alert alert-danger' data-title='<?php _e( "ERROR!" , "download-manager" ); ?>'><?php _e( "Account not found." , "download-manager" ); ?></div>");
                                        $('#resetPassword-submit').html(llbl);
                                    } else {
                                        $('form .alert').hide();
                                        $('#resetPassword').prepend("<div class='alert alert-success' data-title='<?php _e( "MAIL SENT!" , "download-manager" ); ?>'><?php _e( "Please check your inbox." , "download-manager" ); ?></div>");
                                        $('#resetPassword-submit').html(llbl);
                                    }
                                }
                            });
                            return false;
                        });

                        $('body').on('click', 'form .alert-danger', function(){
                            $(this).slideUp();
                        });

                    });
                </script>
            <?php }

            if(wpdm_query_var('action') == 'rp'){

            $user = check_password_reset_key(wpdm_query_var('key'), wpdm_query_var('login'));
            if(!is_wp_error($user)){
            \WPDM\Session::set('__up_user', $user);

            ?>

                <form name="loginform" id="updatePassword" action="<?php echo admin_url('/admin-ajax.php?action=updatePassword'); ?>" method="post" class="login-form" >
                    <?php wp_nonce_field(NONCE_KEY,'__update_pass' ); ?>
                    <h3><?php _e( "New Password" , "download-manager" ); ?></h3>
                    <p>
                        <?php _e('Please enter a new password', 'download-manager'); ?>
                    </p>
                    <div class="form-group">
                        <input placeholder="<?php _e( "New Password" , "download-manager" ); ?>" type="password" name="password" id="password" class="form-control input-lg required text" value="" size="20" />
                    </div>

                    <div class="form-group">
                        <input placeholder="<?php _e( "Confirm Password" , "download-manager" ); ?>" type="password" name="cpassword" id="cpassword" class="form-control input-lg required text" value="" size="20" />
                    </div>

                    <div class="row">
                        <div class="col-md-12"><button type="submit" name="wp-submit" id="updatePassword-submit" class="btn btn-block no-radius btn-success btn-lg"><i class="fa fa-key"></i> &nbsp; <?php _e( "Update Password" , "download-manager" ); ?></button></div>
                    </div>

                </form>

                <script>
                    jQuery(function ($) {
                        var llbl = $('#updatePassword-submit').html();
                        $('#updatePassword').submit(function () {
                            if($('#password').val() != $('#cpassword').val()) {
                                alert('<?php _e( "Confirm password value must be same as the new password" , "download-manager" ); ?>')
                                return false;
                            }
                            $('#updatePassword-submit').html("<i class='fa fa-spin fa-refresh'></i> <?php _e( "Please Wait..." , "download-manager" ); ?>");
                            $(this).ajaxSubmit({
                                success: function (res) {
                                    if(res.success) {
                                        $('#updatePassword').html("<div class='alert alert-success' data-title='<?php _e( "DONE!" , "download-manager" ); ?>'><b><?php _e( "Password Updated" , "download-manager" ); ?></b><br/><a style='margin-top:5px;text-decoration:underline !important;' href='<?php echo wpdm_user_dashboard_url(); ?>'><?php _e( "Go to your account dashboard" , "download-manager" ); ?></a></div>");
                                    } else
                                        $('#updatePassword').html("<div class='alert alert-danger' data-title='<?php _e( "ERROR!" , "download-manager" ); ?>'><b><?php _e( "Password Updated" , "download-manager" ); ?></b><br/><a style='margin-top:5px;text-decoration:underline !important;' href='<?php echo wpdm_lostpassword_url(); ?>'>"+res.message+"</a></div>");
                                    $('#updatePassword-submit').html(llbl);
                                }
                            });
                            return false;
                        });

                        $('body').on('click', 'form .alert-danger', function(){
                            $(this).slideUp();
                        });

                    });
                </script>



            <?php } else { ?>

                <div class="alert alert-danger" data-title="<?php _e( "ERROR!" , "download-manager" ); ?>">
                    <?php echo $user->get_error_message(); ?>
                </div>

            <?php } }

            }} ?>
    </div>


</div>

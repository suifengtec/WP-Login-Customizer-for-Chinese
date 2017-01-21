<?php
/**
 * Class for login form controls
 */

namespace cwp_login\front;

class Form extends Front
{

    function __construct($selector = '')
    {
        parent::__construct();

        $this->animation();

        if( get_option('cwp_login_form_heading') )
            add_filter('login_message', array( $this, 'form_heading' ) );
        if(get_option('cwp_login_form_no_shake'))
            add_action('login_head', array( $this, 'remove_shake' ) );

        $this->redirects();
        add_action( 'login_enqueue_scripts' , array( $this , 'custom_code' ) , 11);
    }


    function redirects(){
        if(get_option('cwp_login_redirect_register'))
            add_filter( 'registration_redirect' , array( $this , 'registrationRedirect' ) );
        if(get_option('cwp_login_redirect_login'))
            add_filter( 'login_redirect' , array( $this , 'loginRedirect' ) );
    }

    function registrationRedirect(){
        return get_option('cwp_login_redirect_register');
    }

    function loginRedirect(){
        return get_option('cwp_login_redirect_login');
    }

    function custom_code(){
        self::$css .= get_option('cwp_login_custom_css');
        self::$js .= get_option('cwp_login_custom_js');
    }

    function animation(){
        if( get_option('cwp_login_form_animation_in') || get_option('cwp_login_form_animation_out') ) {
            $this->add_style(array('clt-animate', $this->get_plugin_uri() . '/css/animate.css'));
            if (get_option('cwp_login_form_animation_in')) {
                self::$body_classes[] = 'clt-form-animated-in';
                self::$js .= "var ttAnimationIn = '" . get_option('cwp_login_form_animation_in') . "';" ;
            }
            if (get_option('cwp_login_form_animation_out')) {
                self::$body_classes[] = 'clt-form-animated-out';
                self::$js .= "var ttAnimationOut = '" . get_option('cwp_login_form_animation_out') . "';" ;
            }
            if (get_option('cwp_login_form_animation_error')) {
                self::$body_classes[] = 'clt-form-animated-error';
                self::$js .= "var ttAnimationError = '" . get_option('cwp_login_form_animation_error') . "';" ;
            }
        }
    }

    function remove_shake(){
        remove_action('login_head', 'wp_shake_js', 12);
    }

    function form_heading(){
        $title = trim(get_option('cwp_login_form_heading'));
        $title = is_array($title)?'':$title;
        $title = !empty( $title)?'<h2 class="clt-form-title">' . esc_html($title) . '</h2>':'';
        return $title;

    }
}

<?php
defined( 'ABSPATH' ) or die( 'access denied.' );

/**
 * Plugin Name: WP Login Customizer for Chinese
 * Plugin URI: http://coolwp.com/wp-login-customizer-for-chinese/
 * Description: 更方便的定制登录/注册页面.
 * Version: 1.0.0
 * Author: suifengtec
 * Author URI: http://coolwp.com/
 * License: GPL2
 * Domain Path: /languages
 * Text Domain: cwp_login
 */

use cwp_login\CWP_L_Plugin;

/*init plugin on plugins_loaded action*/
if( is_admin( ) || cl_is_login_page( ) )
    add_action( 'plugins_loaded', 'cwp_login_init' );

if(!function_exists('cwp_login_init'));
function cwp_login_init(){

    require_once 'autoloader.php';
    $P = new CWP_L_Plugin('登录设置', 'cwp_login');
    $main_page = $P->add_page(array('登录-设置', '登录设置'), null, 'dashicons-lock');
    $main_page->add_style(array('main-admin-css', $P->get_plugin_uri() . '/css/admin/admin-style.css'));
    $main_page->add_script(array('main-admin-js', $P->get_plugin_uri() . '/js/admin/admin-script.js'));
    $main_page->set_page_view('main');

    $general_tab = $main_page->add_tab('综合', null, 'dashicons-admin-generic','general');
    $logo_tab = $main_page->add_tab('Logo', null, 'dashicons-admin-appearance','logo');
    $templates_tab = $main_page->add_tab('模板', null, 'dashicons-images-alt2','templates');
    $form_tab = $main_page->add_tab('表单', null, 'dashicons-feedback','form');
    $advanced_tab = $main_page->add_tab('自定义', null, 'dashicons-editor-code','advanced');
    $social_tab     = $main_page->add_tab( '社交登录(付费可用)' , null,'dashicons-networking','socials' );

    //==========================General Tab============================================//
    $general_tab->add_option(array('primary_color', '主色调', 'color', false, '与选定的模板有关'));
    $general_tab->add_option(array('bg_image','背景图片', 'image', null,
       '选择一张背景图片' .
        ' <span class="dashicons dashicons-info"></span>' . '可使用外部链接'));
    $general_tab->add_option(array('bg_image_repeat', '背景图的重复模式', 'select', 'no-repeat', '',
        array(
            'no-repeat' =>'不重复',
            'repeat' => '重复',
            'repeat-x' => '横向重复',
            'repeat-y' =>'纵向重复',
            'round' => '圆形',
            'space' => '矩形'
        )
    ), array(), array('show' => array('bg_image' => 1)));
    $general_tab->add_option(array('bg_image_size_type','背景图的尺寸','select','cover','',array('contain' => 'Contain', 'cover' => 'Cover', 'initial' => '原始值') ), array(), array('show' => array('bg_image' => 1)));

    $general_tab->add_option(array('bg_color', '背景色', 'color'));


    $general_tab->add_option(array('font_family','字体', 'text', false,'留空则使用插件默认提供的字体选项'));

    $general_tab->add_option(array('font_size','字体大小', 'number'), array('min' => 10, 'max' => '100', 'label' => 'px'));


    $general_tab->add_option(array('font_color', '字体颜色', 'color'));
    $general_tab->add_option(array('redirect_login', '登录后跳转到', 'url', false, false, false, 'http://yourdomain.com/custom-page/'));
    $general_tab->add_option(array('redirect_register', '注册后跳转到', 'url', false, false, false, 'http://yourdomain.com/custom-page/'));
    $general_tab->add_option(array('custom_login_url', '自定义登录链接', 'url', false, '如果您自定义了WP的登录链接,但是这个插件没有识别到,请在此输入。', false, 'http://yourdomain.com/?your-custom-login-url'));
    //==========================Logo Tab============================================//
    $logo_tab->add_option(array('logo_hide', '隐藏Logo', 'checkbox', false, '<span class="dashicons dashicons-info"></span>也会隐藏默认的WP的Logo'),
        array('label' => '不再显示任何Logo'));
    $logo_tab->add_option(array('logo_image', 'Logo', 'image'), array(), array('hide' => array('logo_hide' => 1)));
    $logo_tab->add_option(array(
        'logo_bg_size_type',
       'Logo的尺寸类型',
        'select',
        'cover',
        'Logo图片如何填充Logo区域',
        array('contain' => 'Contain', 'cover' =>'Cover', 'initial' =>'原始值')
    ), array(), array('show' => array('logo_image' => 1), 'hide' => array('logo_hide' => 1)));
    $logo_tab->add_option(array('logo_width', 'Logo的宽度', 'number'), array('min' => 20, 'max' => 2000, 'label' => 'px'), array('hide' => array('logo_hide' => 1)));
    $logo_tab->add_option(array('logo_height', 'Logo的高度', 'number'), array('min' => 20, 'max' => 2000, 'label' => 'px'), array('hide' => array('logo_hide' => 1)));
    $logo_tab->add_option(array('logo_link', 'Logo的链接', 'url', false, false, false, 'http://coolwp.com/'), array(), array('hide' => array('logo_hide' => 1)));
    $logo_tab->add_option(array('logo_title', 'Logo的标题', 'text', null,'在鼠标放在Logo上时显示', false, '我们的Logo'), array(), array('hide' => array('logo_hide' => 1)));
    //==========================Templates Tab============================================//
    $templates_tab->hide_submit = true;
    $templates_tab->add_option(array('template', null, 'template', 'default', '登录页面的模板'
        . ' <span class="dashicons dashicons-warning"></span><b>' .
       '点选并确认后就会生效,但您可以撤销' . '</b>.',
        array(
            'default' => array('默认', null, 'WP默认'),
            'terra' => array('Terra', null, '推荐使用'),
            'venus' => array('Venus', null, '推荐使用'),
            'mercury' => array('Mercury'),
            'mars' => array('Mars', null),
            'jupiter' => array('Jupiter', null),
            'glintfairy' => array('Glint Fairy', null),
        )
    ), array('alert_message' => '确定要使用该模板?')
    );


    //==========================Form Tab============================================//
    $form_tab->add_option(array('form_placement', '表单的位置', 'select', null, '请选择登陆表单出现在屏幕上的位置',
        array(
            '' =>'请选择位置', 'center' => '居中', 'left' =>'偏左', 'right' => '偏右', 'top' => '居上', 'bottom' => '居下', 'top-left' => '左上',
            'top-right' => '右上', 'bottom-left' => '左下', 'bottom-right' =>'右下'
        ),
    ));
    $form_tab->add_option(array('form_heading', '表单的标题', 'text', false, '留空将不显示。'));
    $form_tab->add_option(array('form_bg_image', '表单的背景图片', 'image'));
    $form_tab->add_option(array(
        'form_bg_size_type',
        '表单的背景图片尺寸类型',
        'select',
        'cover',
        '背景图片如何填充表单区域',
        array('contain' => 'Contain', 'cover' => 'Cover', 'inherit' => '继承', 'initial' => '原始值')
    ), array(), array('show' => array('form_bg_image' => 1)));
    $form_tab->add_option(array('form_bg_image_repeat', '表单的背景图片重复模式', 'select', 'no-repeat', null,
        array(
            'inherit' =>  '继承',
            'initial' => '原始值',
            'no-repeat' => '不重复',
            'repeat' => '重复',
            'repeat-x' =>  '横向重复',
            'repeat-y' =>  '纵向重复',
            'round' =>  '圆形',
            'space' =>  '方形',
        )
    ), array(), array('show' => array('form_bg_image' => 1)));
    $form_tab->add_option(array('form_bg_color','表单的背景色', 'color'));
    $form_tab->add_option(array('form_padding', '表单的内补丁', 'number_group', null,  ' 单位为 px', null, '10', array('clt-number-group-4')),array('min' => '0', 'max' => 500, 'label' => 'px','group' => array('top','right','bottom','left')));
    $form_tab->add_option(array('form_no_shake', '表单摇动', 'checkbox', null, '只在出错时才会摇动'), array('label' => '禁用'));
    $form_tab->add_option(array('form_animation_in', '表单动画模式:入场', 'select', null, null,
        array(
            '' =>  '无',
            'bounce' => __('bounce', 'cwp_login'),
            'flash' => __('flash', 'cwp_login'),
            'pulse' => __('pulse', 'cwp_login'),
            'rubberBand' => __('rubberBand', 'cwp_login'),
            'shake' => __('shake', 'cwp_login'),
            'swing' => __('swing', 'cwp_login'),
            'tada' => __('tada', 'cwp_login'),
            'wobble' => __('wobble', 'cwp_login'),
            'jello' => __('jello', 'cwp_login'),
            'bounceIn' => __('bounceIn', 'cwp_login'),
            'bounceInDown' => __('bounceInDown', 'cwp_login'),
            'bounceInLeft' => __('bounceInLeft', 'cwp_login'),
            'bounceInRight' => __('bounceInRight', 'cwp_login'),
            'bounceInUp' => __('bounceInUp', 'cwp_login'),
            'fadeIn' => __('fadeIn', 'cwp_login'),
            'fadeInDown' => __('fadeInDown', 'cwp_login'),
            'fadeInDownBig' => __('fadeInDownBig', 'cwp_login'),
            'fadeInLeft' => __('fadeInLeft', 'cwp_login'),
            'fadeInLeftBig' => __('fadeInLeftBig', 'cwp_login'),
            'fadeInRight' => __('fadeInRight', 'cwp_login'),
            'fadeInRightBig' => __('fadeInRightBig', 'cwp_login'),
            'fadeInUp' => __('fadeInUp', 'cwp_login'),
            'fadeInUpBig' => __('fadeInUpBig', 'cwp_login'),
            'flipInX' => __('flipInX', 'cwp_login'),
            'flipInY' => __('flipInY', 'cwp_login'),
            'lightSpeedIn' => __('lightSpeedIn', 'cwp_login'),
            'rotateIn' => __('rotateIn', 'cwp_login'),
            'rotateInDownLeft' => __('rotateInDownLeft', 'cwp_login'),
            'rotateInDownRight' => __('rotateInDownRight', 'cwp_login'),
            'rotateInUpLeft' => __('rotateInUpLeft', 'cwp_login'),
            'rotateInUpRight' => __('rotateInUpRight', 'cwp_login'),
            'hinge' => __('hinge', 'cwp_login'),
            'rollIn' => __('rollIn', 'cwp_login'),
            'zoomIn' => __('zoomIn', 'cwp_login'),
            'zoomInDown' => __('zoomInDown', 'cwp_login'),
            'zoomInLeft' => __('zoomInLeft', 'cwp_login'),
            'zoomInRight' => __('zoomInRight', 'cwp_login'),
            'zoomInUp' => __('zoomInUp', 'cwp_login'),
            'slideInDown' => __('slideInDown', 'cwp_login'),
            'slideInLeft' => __('slideInLeft', 'cwp_login'),
            'slideInRight' => __('slideInRight', 'cwp_login'),
            'slideInUp' => __('slideInUp', 'cwp_login'),
        )
    ));
    $form_tab->add_option(array('form_animation_out', '表单动画模式:出场', 'select', null, '提交事件触发时的动画效果',
        array(
            '' => '无',
            'bounceOut' => __('bounceOut', 'cwp_login'),
            'bounceOutDown' => __('bounceOutDown', 'cwp_login'),
            'bounceOutLeft' => __('bounceOutLeft', 'cwp_login'),
            'bounceOutRight' => __('bounceOutRight', 'cwp_login'),
            'bounceOutUp' => __('bounceOutUp', 'cwp_login'),
            'fadeOut' => __('fadeOut', 'cwp_login'),
            'fadeOutDown' => __('fadeOutDown', 'cwp_login'),
            'fadeOutDownBig' => __('fadeOutDownBig', 'cwp_login'),
            'fadeOutLeft' => __('fadeOutLeft', 'cwp_login'),
            'fadeOutLeftBig' => __('fadeOutLeftBig', 'cwp_login'),
            'fadeOutRight' => __('fadeOutRight', 'cwp_login'),
            'fadeOutRightBig' => __('fadeOutRightBig', 'cwp_login'),
            'fadeOutUp' => __('fadeOutUp', 'cwp_login'),
            'fadeOutUpBig' => __('fadeOutUpBig', 'cwp_login'),
            'flipOutX' => __('flipOutX', 'cwp_login'),
            'flipOutY' => __('flipOutY', 'cwp_login'),
            'lightSpeedOut' => __('lightSpeedOut', 'cwp_login'),
            'rotateOut' => __('rotateOut', 'cwp_login'),
            'rotateOutDownLeft' => __('rotateOutDownLeft', 'cwp_login'),
            'rotateOutDownRight' => __('rotateOutDownRight', 'cwp_login'),
            'rotateOutUpLeft' => __('rotateOutUpLeft', 'cwp_login'),
            'rotateOutUpRight' => __('rotateOutUpRight', 'cwp_login'),
            'rollOut' => __('rollOut', 'cwp_login'),
            'zoomOut' => __('zoomOut', 'cwp_login'),
            'zoomOutDown' => __('zoomOutDown', 'cwp_login'),
            'zoomOutLeft' => __('zoomOutLeft', 'cwp_login'),
            'zoomOutRight' => __('zoomOutRight', 'cwp_login'),
            'zoomOutUp' => __('zoomOutUp', 'cwp_login'),
            'slideOutDown' => __('slideOutDown', 'cwp_login'),
            'slideOutLeft' => __('slideOutLeft', 'cwp_login'),
            'slideOutRight' => __('slideOutRight', 'cwp_login'),
            'slideOutUp' => __('slideOutUp', 'cwp_login'),
        )
    ));
    $form_tab->add_option(array('form_animation_error', '表单动画模式:错误', 'select', null, '表单错误事件触发时的动画效果',
        array(
            '' => '无',
            'bounce' => __('bounce', 'cwp_login'),
            'flash' => __('flash', 'cwp_login'),
            'pulse' => __('pulse', 'cwp_login'),
            'rubberBand' => __('rubberBand', 'cwp_login'),
            'shake' => __('shake', 'cwp_login'),
            'swing' => __('swing', 'cwp_login'),
            'tada' => __('tada', 'cwp_login'),
            'wobble' => __('wobble', 'cwp_login'),
            'jello' => __('jello', 'cwp_login'),
        )
    ));
    $form_tab->add_option(array('form_button_color', '按钮文本色', 'color'));
    $form_tab->add_option(array('form_button_bg_color', '按钮背景色', 'color'));


    //==========================Social Tab============================================//


    $social_tab->add_option(array('socials','启用','checkbox',null,'<span class="dashicons dashicons-cart"></span>社交登录功能需付费,请联系 suifengtec@qq.com <br> <img src="'.plugins_url('static/img/chinese-social-login-pro.png',__FILE__).'" alt="预览">'));

    $social_tab->add_option(array('social_wc','微信扫码','checkbox'),array(),array('show' => array( 'socials' => 1 ) ));
    $social_tab->add_option(array('social_wb','微博登录','checkbox'),array(),array('show' => array( 'socials' => 1 ) ));  
    $social_tab->add_option(array('social_qq','QQ登录','checkbox'),array(),array('show' => array( 'socials' => 1 ) ));

    $social_tab->add_option(array('social_gh','GitHub登录','checkbox'),array(),array('show' => array( 'socials' => 1 ) ));


    //==========================Custom Tab============================================//
    $advanced_tab->add_option(array('custom_css', '自定义CSS', 'editor'), array('mode' => 'css'));
    $advanced_tab->add_option(array('custom_js', '自定义JS', 'editor'), array('mode' => 'javascript'));
}


/**
 * Checks if on wp-login.php page
 * @return bool
 */
function cl_is_login_page() {
    $login_url = parse_url( get_option('cwp_login_custom_login_url') ? get_option('cwp_login_custom_login_url') : wp_login_url() );
    $current_url = parse_url($_SERVER['REQUEST_URI']);
    if(!empty($login_url['query']) && !empty($current_url['query'])) {
        return $login_url['path'] == $current_url['path'] && strpos($current_url['query'], $login_url['query']) !== false;
    }else{
        return $login_url['path'] == $current_url['path'];
    }
}

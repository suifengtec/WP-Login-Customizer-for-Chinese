<?php
/*
 * One Class to rule them all
 */
namespace cwp_login;

use cwp_login\admin\Page;
use cwp_login\front\Background;
use cwp_login\front\Front;
use cwp_login\front\Logo;
use cwp_login\front\Form;
use cwp_login\front\Templates;
use cwp_login\front\Typography;

class CWP_L_Plugin extends CWP_P_FW {

    /**
     * @param string $name Name of the plugin
     * @param string $slug Slug of the plugin
     */
    function __construct($name,$slug){
        $this->set_plugin_name($name);
        $this->set_plugin_slug($slug);
        $this->set_plugin_dir(plugin_dir_path( __DIR__ ) );
        $this->set_plugin_uri(plugins_url('static',__DIR__));
        add_action( 'cwp_login_admin_notices', array( $this , 'admin_notices' ) );
        add_action( 'init' , array( $this , 'frontend' ) );
      /*  $this->cl_load_textdomain();*/
        add_filter( 'plugin_action_links_tesla-login-customizer/cwp_login.php', array( $this, 'plugin_settings_link' ) );
    }

	/**
	 * @param array $args
	 *
	 * @param array $data
	 * @param string $icon
	 * @return Page
	 */
    function add_page(array $args, $data = array(), $icon = 'dashicons-admin-generic'){
        return new Page($args, null, $data, $icon);
    }


	/**
	 * @param array $args
	 * @param Page|null $parent_page_obj
	 * @param array $data
	 * @return Page
	 */
    function add_subpage(array $args, Page $parent_page_obj = null, $data = array()){
        try {
            if (is_null($parent_page_obj))
                throw new \Exception('Parent Page object not passed to add_subpage method.');
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        return new Page($args, $parent_page_obj, $data);
    }

    function admin_notices(){
        if(!empty($_GET['settings-updated']) && $_GET['settings-updated'] == true)
            echo "<div class='updated fade'><p>已保存设置</p></div>";
    }


    function plugin_settings_link($links){
        $settings_link = '<a href="' . admin_url( 'admin.php?page=cwp_login_options' ) . '">设置/a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    function frontend(){
        if( cl_is_login_page() ) {
            Front::init();
            new Logo('.clt-login #login > h1 a');
            /*new Typography('.clt-login #login');*/
            new Form('.clt-login #login');
        }

        new Templates('body');
    }


    /**
     * Load plugin textdomain.
     *
     * @since 1.0.0
     */
    function cl_load_textdomain() {
        load_plugin_textdomain( 'cwp_login', false, plugin_basename( $this->get_plugin_dir() ) . '/languages' );
    }

}
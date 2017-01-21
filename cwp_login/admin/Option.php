<?php
/**
 * Class to handle single admin option
 */

namespace cwp_login\admin;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use cwp_login\CWP_P_FW;
use cwp_login\View;

class Option extends CWP_P_FW{

    private $args;
    private $parent_tab;
    private $forChinese = true;

    /**
     * @param array $args | array of arguments for option
     * @param Tab $parent_tab | parent Tab object
     * @param array $custom_vars Custom variables to be sent to view
     * @param array $dependencies Options on which the appearance of this option depends
     */
    function __construct(array $args, Tab $parent_tab, array $custom_vars, array $dependencies){
        $this->parent_tab = $parent_tab;
        $this->args = array(
            'id'                => $this->prefix( $args[0] ),
            'title'             => $args[1],
            'type'              => $args[2],
            'std'               => isset($args[3]) ? $args[3] : NULL,
            'descr'             => isset($args[4]) ? $args[4] : NULL,
            'value'             => isset($args[5]) ? $args[5] : NULL,
            'placeholder'       => isset($args[6]) ? $args[6] : NULL,
            'classes'           => isset($args[7]) ? $args[7] : array(),
            'options_group_id'  => $this->parent_tab->slug
        );

        $this->args = array_merge( $this->args, $custom_vars );
        $this->add_plugin_option($this->args['id']);
        add_action( 'admin_init', array( $this, 'option_init' ) );
        if( $this->args['type'] == 'color' ) {
            $this->add_color_picker_scripts();
        }elseif( $this->args['type'] == 'image' ) {
            $this->add_image_picker_scripts();
        }
        elseif( $this->args['type'] == 'font' ) {
            if(!$this->forChinese){
                $this->add_font_picker_scripts();
                $this->get_fonts();      
            }


        }elseif( $this->args['type'] == 'editor' ) {
            $this->add_editor_scripts();
        }

        if(!empty($dependencies)) {
            foreach($dependencies as $action => $deps)
                foreach( $deps as $id => $val )
                    $dep_obj[$action][] = array('id'=>$this->prefix( $id ),'val'=>$val);
            $this->parent_tab->parent_page->dependencies[] = array('id'=>$this->args['id'] , 'actions' => $dep_obj);
            $this->parent_tab->parent_page->add_script(array(
                'clt-admin-deps', $this->get_plugin_uri() . '/js/admin/dependencies.js', array('jquery') , false, false
            ));
        }
    }

    public function option_init(){
        register_setting($this->args['options_group_id'], $this->args['id']);
        add_settings_field(
            $this->args['id'],
            $this->args['title'],
            array($this, 'option_render'),
            $this->parent_tab->slug,
            $this->parent_tab->slug,
            array('label_for'=>$this->args['id'])
        );
    }

    function add_color_picker_scripts(){
        $this->parent_tab->parent_page->add_style(array('wp-color-picker'));
        $this->parent_tab->parent_page->add_script(array('wp-color-picker-alpha',$this->get_plugin_uri() . '/js/admin/wp-color-picker-alpha.min.js',array( 'wp-color-picker' ), '1.1',true));
        $this->parent_tab->parent_page->add_script(array('clt-admin-color-picker', $this->get_plugin_uri() . '/js/admin/colorpicker.js', array( 'wp-color-picker' ), false, true));
    }

    function add_image_picker_scripts(){
        $this->parent_tab->parent_page->add_script(array('wp_enqueue_media'));
        $this->parent_tab->parent_page->add_script(array('clt-admin-image-picker', $this->get_plugin_uri() . '/js/admin/imagepicker.js', array( 'jquery' ), false, true));
    }

    function add_font_picker_scripts(){
        $this->parent_tab->parent_page->add_script(array('clt-admin-select2-js', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js',false, false , true));
        $this->parent_tab->parent_page->add_script(array('clt-admin-font-picker', $this->get_plugin_uri() . '/js/admin/fontpicker.js', array( 'jquery' , 'clt-admin-select2-js' ), false, true));
        $this->parent_tab->parent_page->add_style(array('clt-admin-select2-css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css'));
    }

    function add_editor_scripts(){
        $this->parent_tab->parent_page->add_script(array(
            'clt-admin-codemirror-js', $this->get_plugin_uri() . '/extensions/codemirror/codemirror.js', false, false, true
        ));
        $this->parent_tab->parent_page->add_script(array(
            'clt-admin-codemirror-addon-closebrackets', $this->get_plugin_uri() . '/extensions/codemirror/addon/edit/closebrackets.js', array(
                'clt-admin-codemirror-js'
            ) , false , true
        ));
        $this->parent_tab->parent_page->add_script(array(
            'clt-admin-codemirror-addon-closetag', $this->get_plugin_uri() . '/extensions/codemirror/addon/edit/closetag.js', array(
                'clt-admin-codemirror-js'
            ) , false , true
        ));
        $this->parent_tab->parent_page->add_script(array(
            'clt-admin-codemirror-addon-matchbrackets', $this->get_plugin_uri() . '/extensions/codemirror/addon/edit/matchbrackets.js', array(
                'clt-admin-codemirror-js'
            ) , false , true
        ));
        $this->parent_tab->parent_page->add_script(array(
            'clt-admin-codemirror-addon-matchtags', $this->get_plugin_uri() . '/extensions/codemirror/addon/edit/matchtags.js', array(
                'clt-admin-codemirror-js'
            ) , false , true
        ));
        $this->parent_tab->parent_page->add_script(array(
            'clt-admin-codemirror-addon-trailingspace', $this->get_plugin_uri() . '/extensions/codemirror/addon/edit/trailingspace.js', array(
                'clt-admin-codemirror-js'
            ) , false , true
        ));
        $this->parent_tab->parent_page->add_script(array(
            'clt-admin-codemirror-addon-continuelist', $this->get_plugin_uri() . '/extensions/codemirror/addon/edit/continuelist.js', array(
                'clt-admin-codemirror-js'
            ) , false , true
        ));
        $this->parent_tab->parent_page->add_script(array(
            'clt-admin-codemirror-mode-javascript', $this->get_plugin_uri() . '/extensions/codemirror/mode/javascript/javascript.js', array(
                'clt-admin-codemirror-js'
            ) , false , true
        ));
        $this->parent_tab->parent_page->add_script(array(
            'clt-admin-codemirror-mode-css', $this->get_plugin_uri() . '/extensions/codemirror/mode/css/css.js', array(
                'clt-admin-codemirror-js'
            ) , false , true
        ));
        $this->parent_tab->parent_page->add_script(array(
            'clt-admin-editor', $this->get_plugin_uri() . '/js/admin/editor.js', array( 'jquery' , 'clt-admin-codemirror-js' ), false, true
        ));
        $this->parent_tab->parent_page->add_style(array(
            'clt-admin-codemirror-css', $this->get_plugin_uri() . '/extensions/codemirror/codemirror.css'
        ));
        $this->parent_tab->parent_page->add_style(array(
            'clt-admin-codemirror-theme', $this->get_plugin_uri() . '/extensions/codemirror/theme/mdn-like.css'
        ));
    }

    public function option_render(array $args){
        $classes = implode(' ',$this->args['classes']);
        echo "<div id='{$this->args['id']}-container' class='clt-plugin-option {$classes}' data-type='{$this->args['type']}'>";
        $option_view = new View('options/' . $this->args['type'], $this->args, true, true);
        echo "</div>";
    }

    /*
    not for chinese users.
     */
    function get_fonts(){



        $fonts = get_transient('clt-logo-fonts');
        if(!$fonts || empty($fonts['fonts'])) {
            $response = wp_remote_get('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDzO1C2o_J_59aCghVlJ531wjpTI6Hg8Ow');
            $json = wp_remote_retrieve_body($response);
            $decoded = json_decode($json);
            $fonts = array('fonts' => $decoded->items);
            set_transient('clt-logo-fonts',$fonts, WEEK_IN_SECONDS );


        }

/*var_dump($fonts);*/

        $this->args = array_merge($this->args, $fonts);


    }

}
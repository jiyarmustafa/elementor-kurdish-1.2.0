<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Elementor_Kurdish_Translations {
    
    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'init', [ $this, 'load_translations' ] );
        add_action( 'admin_menu', [ $this, 'customize_admin_menu' ], 999 );
    }

    public function load_translations() {
        // بارگذاری ترجمه المنتور
        $elementor_mo = ELEMENTOR_KURDISH_PLUGIN_DIR . 'languages/elementor.mo';
        if ( file_exists( $elementor_mo ) ) {
            unload_textdomain( 'elementor' );
            load_textdomain( 'elementor', $elementor_mo );
        }

        // بارگذاری ترجمه المنتور پرو اگر فعال باشد
        if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
            $elementor_pro_mo = ELEMENTOR_KURDISH_PLUGIN_DIR . 'languages/elementor-pro.mo';
            if ( file_exists( $elementor_pro_mo ) ) {
                unload_textdomain( 'elementor-pro' );
                load_textdomain( 'elementor-pro', $elementor_pro_mo );
            }
        }
    }

    public function customize_admin_menu() {
        global $menu;
        foreach ( $menu as $key => $item ) {
            if ( isset( $item[2] ) && $item[2] === 'edit.php?post_type=elementor_library' ) {
                $menu[ $key ][0] = 'ڕووکارەکانی ئێلێمنتۆر';
                break;
            }
        }
    }
}
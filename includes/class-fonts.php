<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Elementor_Kurdish_Fonts {
    
    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_kurdish_fonts' ] );
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_kurdish_fonts' ] );
        add_filter( 'elementor/fonts/groups', [ $this, 'add_kurdish_font_group' ] );
        add_filter( 'elementor/fonts/additional_fonts', [ $this, 'add_kurdish_fonts' ] );
    }

    public function enqueue_kurdish_fonts() {
        wp_enqueue_style(
            'elementor-kurdish-fonts',
            ELEMENTOR_KURDISH_ASSETS_URL . 'css/kurdish-fonts.css',
            [],
            ELEMENTOR_KURDISH_VERSION
        );
    }

    public function add_kurdish_font_group( $font_groups ) {
        $font_groups['kurdish'] = __( 'فۆنتی کوردی', 'elementor-kurdish' );
        return $font_groups;
    }

    public function add_kurdish_fonts( $additional_fonts ) {
        $kurdish_fonts = [
            'Kurdistan24' => 'kurdish',
            'Unikurd Goran' => 'kurdish',
            'Rudaw' => 'kurdish',
            'Shasenem' => 'kurdish',
        ];

        return array_merge( $kurdish_fonts, $additional_fonts );
    }
}
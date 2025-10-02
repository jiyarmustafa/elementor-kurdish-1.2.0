<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Elementor_Kurdish_Calendar {
    
    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // فقط اگر المنتور پرو فعال باشد
        if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
            return;
        }

        add_action( 'elementor_pro/forms/fields/register', [ $this, 'register_calendar_field' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_calendar_assets' ] );
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_calendar_assets' ] );
    }

    public function register_calendar_field( $form_fields_registrar ) {
        require_once ELEMENTOR_KURDISH_PLUGIN_DIR . 'includes/class-calendar-field.php';
        $form_fields_registrar->register( new Elementor_Kurdish_Calendar_Field() );
    }

    public function enqueue_calendar_assets() {
        // کتابخانه تقویم
        wp_enqueue_script(
            'jalali-datepicker',
            ELEMENTOR_KURDISH_ASSETS_URL . 'js/jalalidatepicker.min.js',
            [ 'jquery' ],
            '1.0.0',
            true
        );

        // اسکریپت تقویم کردی
        wp_enqueue_script(
            'elementor-kurdish-calendar',
            ELEMENTOR_KURDISH_ASSETS_URL . 'js/kurdish-datepicker.js',
            [ 'jquery', 'jalali-datepicker' ],
            ELEMENTOR_KURDISH_VERSION,
            true
        );

        // استایل تقویم
        wp_enqueue_style(
            'elementor-kurdish-datepicker',
            ELEMENTOR_KURDISH_ASSETS_URL . 'css/datepicker-custom.css',
            [],
            ELEMENTOR_KURDISH_VERSION
        );

        // لوکالایزیشن برای اسکریپت
        wp_localize_script( 'elementor-kurdish-calendar', 'kurdish_datepicker', [
            'months' => [
                'نەورۆز', 'گوڵان', 'جۆزەردان', 'پووشپەڕ',
                'گەلاوێژ', 'خەرمانان', 'ڕەزبەر', 'خەزەن',
                'سەرماوە', 'بەفرانبار', 'ڕێبەندان', 'ڕەشەمە'
            ],
            'days' => [
                'یەکشەممە', 'دووشەممە', 'سێشەممە', 'چوارشەممە',
                'پێنجشەممە', 'هەینی', 'شەممە'
            ],
            'daysShort' => ['ی', 'د', 'س', 'چ', 'پ', 'ه', 'ش']
        ]);
    }
}
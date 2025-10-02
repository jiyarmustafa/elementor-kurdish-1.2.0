<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Elementor_Kurdish_Global_Calendar {
    
    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function enqueue_global_calendar_assets() {
        // فایل پیکربندی (قبل از سایر اسکریپت‌ها)
        wp_enqueue_script(
            'elementor-kurdish-calendar-config',
            ELEMENTOR_KURDISH_ASSETS_URL . 'js/kurdish-calendar-config.js',
            [],
            ELEMENTOR_KURDISH_VERSION,
            true
        );
    
        // کتابخانه تقویم
        wp_enqueue_script(
            'jalali-datepicker',
            ELEMENTOR_KURDISH_ASSETS_URL . 'js/jalalidatepicker.min.js',
            [ 'jquery' ],
            '1.0.0',
            true
        );
    
        // اسکریپت اصلی تقویم کردی
        wp_enqueue_script(
            'elementor-kurdish-global-calendar',
            ELEMENTOR_KURDISH_ASSETS_URL . 'js/global-kurdish-calendar.js',
            [ 'jquery', 'jalali-datepicker', 'elementor-kurdish-calendar-config' ], // وابستگی اضافه شد
            ELEMENTOR_KURDISH_VERSION,
            true
        );
    
    }
    private function __construct() {
        // بارگذاری منابع برای تمام صفحات
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_global_calendar_assets' ] );
        add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_global_calendar_assets' ] );
        
        // اضافه کردن فیلد تاریخ کردی به فرم‌ها
        if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
            add_action( 'elementor_pro/forms/fields/register', [ $this, 'register_kurdish_date_field' ] );
        }
    }

    public function enqueue_global_calendar_assets() {
        // کتابخانه تقویم
        wp_enqueue_script(
            'jalali-datepicker',
            ELEMENTOR_KURDISH_ASSETS_URL . 'js/jalalidatepicker.min.js',
            [ 'jquery' ],
            '1.0.0',
            true
        );

        // اسکریپت اصلی تقویم کردی
        wp_enqueue_script(
            'elementor-kurdish-global-calendar',
            ELEMENTOR_KURDISH_ASSETS_URL . 'js/global-kurdish-calendar.js',
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

        // استایل جامع
        wp_enqueue_style(
            'elementor-kurdish-global-datepicker',
            ELEMENTOR_KURDISH_ASSETS_URL . 'css/global-datepicker.css',
            [],
            ELEMENTOR_KURDISH_VERSION
        );

        // انتقال داده به JavaScript
        wp_localize_script( 'elementor-kurdish-global-calendar', 'kurdishCalendarConfig', [
            'months' => [
                'نەورۆز', 'گوڵان', 'جۆزەردان', 'پووشپەڕ',
                'گەلاوێژ', 'خەرمانان', 'ڕەزبەر', 'خەزەن',
                'سەرماوە', 'بەفرانبار', 'ڕێبەندان', 'ڕەشەمە'
            ],
            'days' => [
                'یەکشەممە', 'دووشەممە', 'سێشەممە', 'چوارشەممە',
                'پێنجشەممە', 'هەینی', 'شەممە'
            ],
            'daysShort' => ['ی', 'د', 'س', 'چ', 'پ', 'ه', 'ش'],
            'convertToKurdish' => true
        ]);
    }

    public function register_kurdish_date_field( $form_fields_registrar ) {
        require_once ELEMENTOR_KURDISH_PLUGIN_DIR . 'includes/class-calendar-field.php';
        $form_fields_registrar->register( new Elementor_Kurdish_Calendar_Field() );
    }
}
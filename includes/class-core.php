<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Elementor_Kurdish_Core {
    
    private static $instance = null;
    private $options = [];

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'plugins_loaded', [ $this, 'init' ] );
        add_action( 'admin_init', [ $this, 'check_images_directory' ] );
    }

    public function init() {
        // بررسی وجود المنتور
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'elementor_missing_notice' ] );
            return;
        }
        
        $this->load_options();
        $this->load_modules();
        $this->register_hooks();
        
        do_action( 'elementor_kurdish/loaded' );
    }

    private function load_options() {
        $this->options = get_option( 'elementor_kurdish', [
            'kurdish_fonts' => '1',
            'kurdish_rtl_styles' => '1',
            'kurdish_translation' => '1',
            'kurdish_calendar' => '1'
        ] );
    }

    private function load_modules() {
        // بارگذاری ماژول‌های اصلی
        $modules = [
            'translations' => ! empty( $this->options['kurdish_translation'] ),
            'fonts' => ! empty( $this->options['kurdish_fonts'] ),
            'global_calendar' => ! empty( $this->options['kurdish_calendar'] ),
            'settings' => true,
            'about' => true
        ];

        foreach ( $modules as $module => $enabled ) {
            if ( $enabled ) {
                $file_path = ELEMENTOR_KURDISH_PLUGIN_DIR . "includes/class-{$module}.php";
                if ( file_exists( $file_path ) ) {
                    require_once $file_path;
                    
                    // راه‌اندازی ماژول با نام کلاس پویا
                    $class_name = 'Elementor_Kurdish_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $module ) ) );
                    if ( class_exists( $class_name ) ) {
                        call_user_func( [ $class_name, 'instance' ] );
                    }
                }
            }
        }
    }

    private function register_hooks() {
        // استایل‌های RTL
        if ( ! empty( $this->options['kurdish_rtl_styles'] ) ) {
            add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_editor_styles' ] );
            add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_preview_styles' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_styles' ] );
        }

        // نمایش نسخه در داشبورد
        add_action( 'elementor/admin/dashboard_overview_widget/after_version', [ $this, 'add_version_to_dashboard' ] );
    }

    public function enqueue_editor_styles() {
        wp_enqueue_style(
            'elementor-kurdish-editor',
            ELEMENTOR_KURDISH_ASSETS_URL . 'css/editor-rtl.min.css',
            [ 'elementor-editor' ],
            ELEMENTOR_KURDISH_VERSION
        );
        
        wp_enqueue_style(
            'elementor-kurdish-common',
            ELEMENTOR_KURDISH_ASSETS_URL . 'css/common-rtl.css',
            [ 'elementor-editor' ],
            ELEMENTOR_KURDISH_VERSION
        );
    }

    public function enqueue_preview_styles() {
        wp_enqueue_style(
            'elementor-kurdish-preview',
            ELEMENTOR_KURDISH_ASSETS_URL . 'css/preview-rtl.css',
            [],
            ELEMENTOR_KURDISH_VERSION
        );
    }

    public function enqueue_frontend_styles() {
        wp_enqueue_style(
            'elementor-kurdish-frontend',
            ELEMENTOR_KURDISH_ASSETS_URL . 'css/frontend-rtl.css',
            [],
            ELEMENTOR_KURDISH_VERSION
        );
    }

    public function add_version_to_dashboard() {
        echo '<span class="e-overview__version">ئێلێمنتۆری کوردی v' . esc_html( ELEMENTOR_KURDISH_VERSION ) . '</span>';
    }

    public function check_images_directory() {
        if ( is_admin() && current_user_can( 'manage_options' ) ) {
            $images_path = ELEMENTOR_KURDISH_PLUGIN_DIR . 'assets/images/';
            if ( ! is_dir( $images_path ) ) {
                add_action( 'admin_notices', [ $this, 'images_directory_missing_notice' ] );
            }
        }
    }

    public function images_directory_missing_notice() {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p>❌ <strong>ئێلێمنتۆری کوردی:</strong> پوشەی وێنەکان دۆزرایەوە نیە! تکایە پوشەی <code>assets/images/</code> دروست بکە و وێنەکان باربکە.</p>
        </div>
        <?php
    }

    public function get_option( $key = '', $default = false ) {
        return isset( $this->options[ $key ] ) ? $this->options[ $key ] : $default;
    }

    public function elementor_missing_notice() {
        if ( ! current_user_can( 'activate_plugins' ) ) return;
        
        $message = sprintf(
            esc_html__( 'ئێلێمنتۆری کوردی پێویستی بە پێکهاتەی ئێلێمنتۆر هەیە. تکایە %1$sئێلێمنتۆر%2$s چالاک بکە.', 'elementor-kurdish' ),
            '<a href="' . admin_url( 'plugin-install.php?tab=search&s=elementor' ) . '">',
            '</a>'
        );
        
        printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', $message );
    }
}
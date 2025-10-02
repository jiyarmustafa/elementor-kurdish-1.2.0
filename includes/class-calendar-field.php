<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Elementor_Kurdish_Calendar_Field extends \ElementorPro\Modules\Forms\Fields\Field_Base {

    public function get_type() {
        return 'kurdish_date';
    }

    public function get_name() {
        return esc_html__( 'ڕۆژمێری کوردی', 'elementor-kurdish' );
    }

    public function render( $item, $item_index, $form ) {
        $placeholder = isset( $item['kurdish_date_placeholder'] ) ? 
            sanitize_text_field( $item['kurdish_date_placeholder'] ) : 
            esc_attr__( 'بڕۆژ دیاری بکە', 'elementor-kurdish' );

        $form->add_render_attribute( 'input' . $item_index, [
            'type'        => 'text',
            'class'       => 'elementor-field-textual kurdish-date-input',
            'name'        => $form->get_attribute_name( $item ),
            'id'          => $form->get_attribute_id( $item ),
            'placeholder' => $placeholder,
            'data-jdp'    => '',
            'readonly'    => 'readonly',
            'data-format' => 'kurdish'
        ] );

        echo '<input ' . $form->get_render_attribute_string( 'input' . $item_index ) . '>';
    }

    public function update_controls( $widget ) {
        $elementor = \ElementorPro\Plugin::elementor();
        $control_data = $elementor->controls_manager->get_control_from_stack( 
            $widget->get_unique_name(), 
            'form_fields' 
        );

        if ( is_wp_error( $control_data ) ) {
            return;
        }

        $field_controls = [
            'kurdish_date_placeholder' => [
                'name'         => 'kurdish_date_placeholder',
                'label'        => esc_html__( 'Placeholder', 'elementor-kurdish' ),
                'type'         => \Elementor\Controls_Manager::TEXT,
                'default'      => esc_html__( 'بڕۆژ دیاری بکە', 'elementor-kurdish' ),
                'dynamic'      => [ 'active' => true ],
                'condition'    => [ 'field_type' => $this->get_type() ],
                'tab'          => 'content',
                'inner_tab'    => 'form_fields_content_tab',
                'tabs_wrapper' => 'form_fields_tabs',
            ],
        ];

        $control_data['fields'] = array_merge( $control_data['fields'], $field_controls );
        $widget->update_control( 'form_fields', $control_data );
    }

    public function validation( $field, $record, $ajax_handler ) {
        if ( empty( $field['value'] ) && $field['required'] ) {
            $ajax_handler->add_error( 
                $field['id'], 
                esc_html__( 'تکایە بڕۆژ دیاری بکە.', 'elementor-kurdish' ) 
            );
            return;
        }

        // اعتبارسنجی فرمت تاریخ کردی: روز/ماه/سال (سال = میلادی + 700)
        if ( ! empty( $field['value'] ) ) {
            $date_value = sanitize_text_field( $field['value'] );
            
            // فرمت باید: DD/MM/YYYY باشد (مثال: 10/7/2725)
            if ( ! preg_match( '/^\d{1,2}\/\d{1,2}\/\d{4}$/', $date_value ) ) {
                $ajax_handler->add_error(
                    $field['id'],
                    esc_html__( 'فۆرمەتی ڕۆژمێر هەڵەیە. تکایە لە ڕۆژمێر هەڵبژێرە.', 'elementor-kurdish' )
                );
                return;
            }

            // بررسی معتبر بودن تاریخ
            $parts = explode( '/', $date_value );
            if ( count( $parts ) === 3 ) {
                $day = (int) $parts[0];
                $month = (int) $parts[1];
                $year = (int) $parts[2];

                // سال کردی باید بین 2700 تا 3700 باشد
                if ( $month < 1 || $month > 12 || $day < 1 || $day > 31 || $year < 2700 || $year > 3700 ) {
                    $ajax_handler->add_error(
                        $field['id'],
                        esc_html__( 'ڕۆژمێر هەڵەیە. تکایە ڕۆژمێرێکی دروست هەڵبژێرە.', 'elementor-kurdish' )
                    );
                }
            }
        }
    }
}
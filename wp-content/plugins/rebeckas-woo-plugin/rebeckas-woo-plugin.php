<?php
/**
 * Plugin Name:       Rebeckas Woo Plugin
 * Description:       Lägger till Custom Fields i Products
 * Version:           1.0.0
 * Author:            Rebecka
 * Developer:         Rebecka
 * Text Domain:       rebeckas-woo-plugin
 * 
 * WC requires at least: 5.9
 * WC tested up to: 5.9
 * 
 * License: GNU General Public Licence v3.0
 * License URI: http://www.gnu.org/licences/gpl-3.0.html
 */
 
$plugin_path = trailingslashit( WP_PLUGIN_DIR ) . 'woocommerce/woocommerce.php';


if 
    (in_array( $plugin_path, wp_get_active_and_valid_plugins())) {
        // Display Fields
        add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields');

        // Save Fields
        add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');

        //Print Fields
        add_action( 'woocommerce_after_shop_loop_item_title', 'print_author_and_year', 1 );

            function woocommerce_product_custom_fields()
            {
                global $woocommerce, $post;
                    echo '<div class="product_custom_field">';

                        // Author Field
                        woocommerce_wp_text_input(
                            array(
                                'id' => '_custom_product_text_field',
                                'placeholder' => 'Author Field',
                                'label' => __('Author Field', 'woocommerce'),
                                'desc_tip' => 'true'
                            )
                        );

                        //Publishing Year Field
                        woocommerce_wp_text_input(
                            array(
                                'id' => '_custom_product_number_field',
                                'placeholder' => 'Publishing Year Field',
                                'label' => __('Publishing Year Field', 'woocommerce'),
                                'type' => 'number',
                                'custom_attributes' => array(
                                    'step' => 'any',
                                    'min' => '0'
                                )
                            )
                        );
  
                    echo '</div>';

            }

            function woocommerce_product_custom_fields_save($post_id)
            {
                // Author Field
                    $woocommerce_custom_product_text_field = $_POST['_custom_product_text_field'];
                    if (!empty($woocommerce_custom_product_text_field))
                        update_post_meta($post_id, '_custom_product_text_field', esc_attr($woocommerce_custom_product_text_field));
                // Publishing Year Field
                    $woocommerce_custom_product_number_field = $_POST['_custom_product_number_field'];
                    if (!empty($woocommerce_custom_product_number_field))
                        update_post_meta($post_id, '_custom_product_number_field', esc_attr($woocommerce_custom_product_number_field));

            }

            function print_author_and_year() {

                // Display the value of Author Field
                    echo get_post_meta(get_the_ID(), '_custom_product_text_field', true);
                // Display the value of Publishing Year Field
                    echo ' (' . get_post_meta(get_the_ID(), '_custom_product_number_field', true) . ')<br>';
    
            }


    }

?>
<?php
/*
Plugin Name: wp helios system
Plugin URI:  https://heliossystem.hu to your plugin homepage
Description: A Brown Media által fejlesztett, E-commerce kereskedelmi rendszer.
Version:     4.0
Author:      Aeron Brown
Author URI:  https://brownmedia.eu
License:     GPL2 etc
License URI: https://link to your plugin license

Copyright 2021 Brown Media (email : hello@brownmedia.eu)
Helios System WP is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Helios System WP is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with (Plugin Name). If not, see (http://link to your plugin license).
*/

// Hook for adding admin menus
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
add_action('admin_menu', 'mt_add_pages');
add_action('create_database','wp_helios_create_database');
add_action('template_redirect','wp_helios_free_product_frontend');
global $wpdb;
 $settings = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");

if (!empty($settings[0]) && $settings[0]->product_view_count_enabled == 1) {
    add_action( 'woocommerce_after_single_product', 'wphs_product_view_count_frontend');
    add_action( 'woocommerce_add_to_cart', 'wphs_product_add_to_cart_count_frontend');
}

 if (!empty($settings[0]) && $settings[0]->abandoned_cart_enabled == 1) {
        add_action( 'wp_enqueue_scripts', 'my_custom_script_load',20 );
        function my_custom_script_load(){
            wp_enqueue_script( 'my-custom-script', plugins_url( '../helioswp/js/helios.js', __FILE__ ), array( 'jquery' ) );
            wp_localize_script('my-custom-script', 'pw_script_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),));
        }
     add_filter( 'woocommerce_checkout_redirect_empty_cart', '__return_false' );
     add_filter( 'woocommerce_checkout_update_order_review_expired', '__return_false' );
     add_action( 'woocommerce_before_checkout_form', 'check_helios_abandoned_cart' );
     function check_helios_abandoned_cart() {
         if(isset($_REQUEST["hsabc"]) && $_REQUEST["hsabc"] == 1){
             global $woocommerce;
             $woocommerce->cart->empty_cart();
             foreach($_REQUEST as $item){
                 if(is_array($item)){
                     if($item["variation_id"] == 0){
                         $woocommerce->cart->add_to_cart($item["product_id"],$item["quantity"]);
                     }else{
                         $woocommerce->cart->add_to_cart($item["variation_id"],$item["quantity"]);
                     }
                 }
             }
         }
     }
 }

if (!empty($settings[0]) && $settings[0]->helios_stock_enable == 1) {

    function my_activation() {
        if (! wp_next_scheduled ( 'my_hourly_event' )) {
            wp_schedule_event(time(), 'hourly', 'my_hourly_event');
        }
    }

    add_action('my_hourly_event', 'do_this_hourly');

    function do_this_hourly() {
        global $wpdb;
        global $product;
        $dbData = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");

        $data = array( 'company_id' => $dbData[0]->company_id);
        $response = Requests::post( 'https://admin.heliossystem.hu/api/update_woocommerce_stock.php', array(), $data );
        $stockData = json_decode($response->body);
        if(!empty($stockData)){
            foreach($stockData as $stockItem){
                if($stockItem->variation_id == 0){
                    $productObject = wc_get_product( $stockItem->product_id );
                }else{
                    $productObject = wc_get_product( $stockItem->variation_id );
                }

                if($stockItem->stock == 0 && $stockItem->out_stock_status == 0){
                    $productObject->set_manage_stock('no');
                    $productObject->set_stock_status("outofstock");
                    $productObject->save();
                }elseif($stockItem->stock != 0){
                    $productObject->set_manage_stock('yes');
                    $productObject->set_stock_status("instock");
                    $productObject->set_stock_quantity($stockItem->stock);
                    $productObject->save();
                }elseif($stockItem->stock == 0 && $stockItem->out_stock_status == 1){
                    //idejön majd a pre orderes cucc
                }
            }
        }
    }
}

add_action('wp_ajax_send_abandoned_cart_details','send_abandoned_cart_details');
add_action( 'wp_ajax_nopriv_send_abandoned_cart_details','send_abandoned_cart_details' );
add_action('woocommerce_thankyou', 'send_order_to_helios', 10, 1);

function mt_add_pages() {

    add_menu_page(
        __('Helios System', 'wp-helios-system'),
        __('Helios System', 'wp-helios-system'),
        'manage_options',
        'wp-helios-system',
        'wphs_main_dashboard',
        plugins_url('../helioswp/helios_icon.png', __FILE__ ));
    add_submenu_page('wp-helios-system', __('Ajándék termék', 'wp-helios-system'), __('Ajándék termék', 'wp-helios-system'), 'manage_options', 'wp_helios_system_free_product', 'wp_helios_system_free_product');
    add_submenu_page('wp-helios-system', __('Beállítások', 'wp-helios-system'), __('Beállítások', 'wp-helios-system'), 'manage_options', 'wp-helios-system_settings', 'wp_helios_system_settings');

}

//Bejelentkezés
function wphs_main_dashboard(){
    if (is_admin()):
        include 'inc/login.php';
    endif;
}

//Álltalános beállítások.
function wp_helios_system_settings(){
    if (is_admin()):
        include 'inc/settings.php';
    endif;
}

//Kosár alapú termék funckió
function wp_helios_system_free_product(){
    if (is_admin()):
        include 'inc/free_product.php';
    endif;
}        

//adatbázis létrehozás
function wp_helios_create_database(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'wphs';
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $charset_collate = $wpdb->get_charset_collate();        
            $sql = "CREATE TABLE ".$table_name." (
                id int(11) NOT NULL AUTO_INCREMENT,
                company_id int(11) NULL,
                cart_discount_enabled int(11) NULL,
                cart_discount_product_id int(11) NULL,
                cart_discount_cart_value int(11) NULL,
                product_view_count_enabled int(11) NULL,
                abandoned_cart_enabled int(11) NULL,
                helios_checkout_enabled int(11) NULL,
                helios_stock_enable int(11) NULL,
                PRIMARY KEY(id)) $charset_collate;";                   
            dbDelta( $sql );
    }
}        
register_activation_hook( __FILE__, 'wp_helios_create_database' );
register_activation_hook(__FILE__, 'my_activation');

//Rendelés beküldése a heliosba
function send_order_to_helios($order_id){
    global $wpdb;
    if ( ! $order_id ){
        return;
    }
    $settings = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");
    $data = array( 'company_id' => $settings[0]->company_id, 'order_id' => $order_id);
    $response = Requests::post( 'https://admin.heliossystem.hu/api/new_order_wp.php', array(), $data );
}

//kosár alapú termék funckió frontend
 function wp_helios_free_product_frontend(){
   if ( ! is_admin() ) {
        global $woocommerce;
        global $wpdb;

        $settings = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");
        if (!empty($settings[0]) && $settings[0]->cart_discount_enabled == 1) {
            $product_id = $settings[0]->cart_discount_product_id;
            $found = false;
            $cart_total = $settings[0]->cart_discount_cart_value;

            if( $woocommerce->cart->total >= $cart_total ) {
                //check if product already in cart
                if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) {
                    foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
                        $_product = $values['data'];
                        if ( $_product->get_id() == $product_id )
                            $found = true;
                    }
                    // if product not found, add it
                    if ( ! $found )
                        $woocommerce->cart->add_to_cart( $product_id );
                } else {
                    // if no products in cart, add it
                    $woocommerce->cart->add_to_cart( $product_id );
                }
            }else{
                $woocommerce->cart->remove_cart_item($product_id);
                $product_cart_id = $woocommerce->cart->generate_cart_id( $product_id );
                $cart_item_key = $woocommerce->cart->find_product_in_cart( $product_cart_id );
                if ( $cart_item_key ){
                    $woocommerce->cart->remove_cart_item( $cart_item_key );
                } 
            }
        }
    }
 }

//termék nézettség követése
function wphs_product_view_count_frontend(){
    global $product;
    global $wpdb;
    $product_id = $product->get_id();
    $settings = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");

    $data = array( 'company_id' => $settings[0]->company_id, 'product_id' => $product_id, 'type' => 1 );
    $response = Requests::post( 'https://admin.heliossystem.hu/api/product_view_count.php', array(), $data );

 }

//termék nézettség követése frontend
 function wphs_product_add_to_cart_count_frontend(){
    global $woocommerce;
    global $wpdb;
    $items = $woocommerce->cart->get_cart();
    $settings = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");
    $ids = array();

    foreach($items as $item => $values) {
        $_product = $values['data']->post; 
        $ids[] = $_product->ID; 
    }
    $product_id = end($ids);
    $data = array( 'company_id' => $settings[0]->company_id, 'product_id' => $product_id, 'type' => 2 );
    $response = Requests::post( 'https://admin.heliossystem.hu/api/product_view_count.php', array(), $data );
 }

 function send_abandoned_cart_details(){
    global $woocommerce;
    global $wpdb;
    $cart = $woocommerce->cart->get_cart();
    $settings = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");
    $products = array();
    $mail = $_REQUEST["mail"];
    $i = 0;
     foreach($cart as $item => $values) {
         $_product =  wc_get_product( $values['data']->get_id());
         $type = $_product->get_type();
         if($type == "variation"){
             $product_id = wp_get_post_parent_id($values['variation_id']);
             $products[$i]["product_id"] = $product_id;
             $products[$i]["variation_id"] = $values['variation_id'];
         }else{
             $products[$i]["product_id"] = $_product->get_id();
         }
         $products[$i]["quantity"] = $values['quantity'];
         $i++;
     }
     $totalCart = $woocommerce->cart->get_cart_contents_total();
     $data = array( 'company_id' => $settings[0]->company_id, 'cart' => $products, 'cart_total' => $totalCart, 'mail' => $mail);
     $response = Requests::post( 'https://admin.heliossystem.hu/api/abandoned_cart_data.php', array(), $data );
 }
if (!empty($settings[0]) && $settings[0]->helios_checkout_enabled == 1) {
    function bb_load_wc_template_file( $template_name ) {
        // Check theme folder first - e.g. wp-content/themes/bb-theme/woocommerce.
        $file = get_stylesheet_directory() . '/woocommerce/' . $template_name;
        if ( @file_exists( $file ) ) {
            return $file;
        }

        // Now check plugin folder - e.g. wp-content/plugins/myplugin/woocommerce.
        $file = 'wp-content/plugins/helioswp' . '/assets/woocommerce/' . $template_name;
        //var_dump($template_name);
        if ( @file_exists( $file ) ) {
            return $file;
        }
    }

    add_filter( 'woocommerce_template_loader_files', function( $templates, $template_name ){
        // Capture/cache the $template_name which is a file name like single-product.php
        wp_cache_set( 'bb_wc_main_template', $template_name ); // cache the template name
        return $templates;
    }, 10, 2 );

    add_filter( 'template_include', function( $template ){
        if ( $template_name = wp_cache_get( 'bb_wc_main_template' ) ) {
            wp_cache_delete( 'bb_wc_main_template' ); // delete the cache
            if ( $file = bb_load_wc_template_file( $template_name ) ) {
                return $file;
            }
        }
        return $template;
    }, 11 );
    add_filter( 'wc_get_template_part', function( $template, $slug, $name ){
        $file = bb_load_wc_template_file( "{$slug}-{$name}.php" );
        return $file ? $file : $template;
    }, 10, 3 );

    add_filter( 'woocommerce_locate_template', function( $template, $template_name ){
        $file = bb_load_wc_template_file( $template_name );
        return $file ? $file : $template;
    }, 10, 2 );

    add_filter( 'wc_get_template', function( $template, $template_name ){
        $file = bb_load_wc_template_file( $template_name );
        return $file ? $file : $template;
    }, 10, 2 );
}

?>
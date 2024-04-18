<?php

/**
 * Plugin Name: My Plugin
 * Description: This is a test plugin.
 * Version: 2.0
 * Author: Abdullah
 * Author URI: https://techosolution.com
 */

if (!defined('ABSPATH')) {
    exit("Direct script access denied.");
}

                    // my_plugin_activation hook:

function my_plugin_activation()
{
    global $wpdb;

    $wp_emp = $wpdb->prefix . 'emp';

    $q = "CREATE TABLE IF NOT EXISTS $wp_emp (
                ID INT NOT NULL AUTO_INCREMENT,
                name VARCHAR(50) NOT NULL,
                email VARCHAR(100) NOT NULL,
                status BOOLEAN NOT NULL,
                PRIMARY KEY (ID)
    )           ENGINE = InnoDB;";

    $wpdb->query($q);

                    // Inserting sample data:

    $data = array(
        'name' => 'khan',
        'email' => 'khan.167@gmail.com',
        'status' => 1
    );
    $wpdb->insert($wp_emp, $data);
}
register_activation_hook(__FILE__, 'my_plugin_activation');

                // my_plugin_Deactivation hook:

function my_plugin_deactivation()
{
    global $wpdb;
    $wp_emp = $wpdb->prefix . 'emp';

    $q = "DROP TABLE IF EXISTS $wp_emp";
    $wpdb->query($q);
}
register_deactivation_hook(__FILE__, 'my_plugin_deactivation');

                    //my_plugin_page_funnction 1;

function my_plugin_page_fun(){

    include 'Admin/main_page.php';
}

                //my_plugin_page_funnction 2;

function add_new_plugin_fun(){

    echo "Techo Solution";
}

                //add menu page;

function my_plugin_menu(){
    add_menu_page('My Plugin Page', 'My Plugin Page', 'manage_options',
    'my-plugin-page', 'my_plugin_page_fun', '', 6);

                //add submenu page;
    
    add_submenu_page('my-plugin-page', 'Add New Plugin', 'Add New
                    Plugin', 'manage_options', 'add-new-plugin', '
                    add_new_plugin_fun');
}

add_action('admin_menu', 'my_plugin_menu');

                //custom post type;

        //function register_my_cpt;

function register_my_cpt(){
    $labels = array(
            'name' => 'Cars',
            'singular_name' => 'car'
    );

       $supports = array(
                'title', 
                'editor', 
                'thumbnail', 
                'comments', 
                'excerpts'
       );

       $options = array(
                'labels' => $labels,
                'public'  => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'cars'),
                'show_in_rest' => true,
                'supports' => $supports,
                'taxonomies' => array('car_types'),
                'taxonomies' => array('category'),
                'publicly_queryqble' => true,
       );
register_post_type('cars', $options);
}

add_action('init' , 'register_my_cpt');

                //function register_care_type;

function register_car_types(){

        $labels = array(
                'name' => 'Car Type',
                'singular_name' => 'car'
        );
        $options = array(
                'labels' => $labels,
                'hierarchical' => true,
                'rewrite' => array('slug' => 'Car-type'),
                'show_in_rest' => true,

        );
    register_taxonomy('car-type', array('cars' ), $options);   
}

add_action('init' , 'register_car_types');

?>
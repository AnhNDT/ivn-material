<?php
/*
Plugin Name: IVN-Material
Plugin URI: https://github.com/AnhNDT/ivn-material
Description: Manage download materials
Author: AnhNDT <anhndt@vn.innovation.co.jp>
Author URI: https://github.com/AnhNDT/
Version: 0.1

[INSTALATION GUIDE]
	1. create table ivn_materials
	2. active plugin
	3. register new records to inv_materials
	4. create new pages on PUBLIC
		materials-list-page reference to form-download-materials.php
	5. update other files as needed
	.
*/

if (! defined('ABSPATH')) exit;

/** Absolute path to the IVN_Material dirctory */
define( 'IVN_MATERIAL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'IVN_MATERIAL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'IVN_MATERIAL_DOCUMENTS_URI', '/documents/download/' );
define( 'IVN_MATERIAL_DOCUMENTS_PATH', ABSPATH . IVN_MATERIAL_DOCUMENTS_URI );
define( 'IVN_MATERIAL_URL', '/wp-admin/admin.php?page=ivn-material' );
define( 'IVN_MATERIAL_IMAGES_URL', IVN_MATERIAL_PLUGIN_URL . 'images/' );

load_plugin_textdomain( 'ivn-material', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

if ( ! function_exists( 'add_action' ) ) {
	echo 'do call a plugin in directly.';
	exit;
}

add_action( 'admin_enqueue_scripts', 'ivn_materials_load_js_and_css' );
function ivn_materials_load_js_and_css() {
	if ( preg_match( '(ivn-material)', $_SERVER['REQUEST_URI'] ) ) {
		if ( (strpos( $_SERVER['REQUEST_URI'], "w=cre" ) !== false) || (strpos( $_SERVER['REQUEST_URI'], "w=upd" ) !== false) ) {
			// select2
			wp_register_style( 'ivn_materials_select2.css', IVN_MATERIAL_PLUGIN_URL . 'vendors/select2-3.5.1/select2.css' );
			wp_enqueue_style( 'ivn_materials_select2.css' );
			wp_register_script( 'ivn_materials_select2.js', IVN_MATERIAL_PLUGIN_URL . 'vendors/select2-3.5.1/select2.js' );
			wp_enqueue_script( 'ivn_materials_select2.js' );
			wp_register_script( 'ivn_materials_select2_locale_ja.js', IVN_MATERIAL_PLUGIN_URL . 'vendors/select2-3.5.1/select2_locale_ja.js' );
			wp_enqueue_script( 'ivn_materials_select2_locale_ja.js' );
			
			// jqueryvalidation
			wp_register_script( 'ivn_materials_jqueryvalidation.js', IVN_MATERIAL_PLUGIN_URL . 'vendors/jquery-validation-1.13.0/jquery.validate.min.js' );
			wp_enqueue_script( 'ivn_materials_jqueryvalidation.js' );
			wp_register_script( 'ivn_materials_jqueryvalidation_locale_ja.js', IVN_MATERIAL_PLUGIN_URL . 'vendors/jquery-validation-1.13.0/localization/messages_ja.min.js' );
			wp_enqueue_script( 'ivn_materials_jqueryvalidation_locale_ja.js' );
		}
	}

}

/**
create tables & directory
*/
function ivn_material_activation_options() {
	// check variable
	if ( ! defined( 'IVN_MATERIAL_DOCUMENTS_PATH' ) ) {
		trigger_error( 'Documents-path does not exist.', 
			headers_sent() || WP_DEBUG ? E_USER_WARNING : E_USER_NOTICE );
		return false;
	}
	// check directory
	if ( ! is_dir( IVN_MATERIAL_DOCUMENTS_PATH ) ) {
			mkdir( IVN_MATERIAL_DOCUMENTS_PATH, 0777, TRUE );
	}
	
	/* CREATE TABLE ⇒ .git/_database/ivn_materials_create_2543.sql */
 
}

// run the install scripts upon plugin activation
register_activation_hook( __FILE__, 'ivn_material_activation_options' );

function ivn_material_manage() {
	require_once IVN_MATERIAL_PLUGIN_PATH . "modules/manage.php";
	return true;
}

function ivn_material_actions() {
	add_menu_page( __( 'お役立ち資料管理', 'ivn-material' ),
					__( 'お役立ち資料', 'ivn-material' ),
					'edit_pages',
					'ivn-material', "ivn_material_manage",
					IVN_MATERIAL_IMAGES_URL . 'img_download_16x16.png',
					9 );

}

add_action( 'admin_menu', 'ivn_material_actions' );

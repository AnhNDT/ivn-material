<?php
/*
Plugin Name: IVN-Kinds-Material
Plugin URI: https://github.com/AnhNDT/ivn-every-kind-material
Description: Manage download all-kinds-materials and generate static page
Author: AnhNDT <anhndt@vn.innovation.co.jp>
Author URI: https://github.com/AnhNDT/
Version: 0.1

[INSTALATION GUIDE]
	1. create table ivn_all_kinds_materials
	2. active plugin
	3. register new records to inv_all_kinds_materials
	4. generate static page
	.
*/

if ( ! defined('ABSPATH')) exit;

/** Absolute path to the IVN_Material dirctory */
define('IVN_ALLKINDSMATERIAL_PLUGIN_PATH', plugin_dir_path(__FILE__ ));
define('IVN_ALLKINDSMATERIAL_PLUGIN_URL', plugin_dir_url(__FILE__ ));
define('IVN_ALLKINDSMATERIAL_HTML_FILE_PATH', ABSPATH . '/documents/all-kinds-material/index.html');
define('IVN_ALLKINDSMATERIAL_DOCUMENTS_URI', '/documents/all-kinds-material/download/');
define('IVN_ALLKINDSMATERIAL_DOCUMENTS_PATH', ABSPATH . IVN_ALLKINDSMATERIAL_DOCUMENTS_URI);
define('IVN_ALLKINDSMATERIAL_URL', '/wp-admin/admin.php?page=ivn-all-kinds-material');
define('IVN_ALLKINDSMATERIAL_IMAGES_URL', IVN_ALLKINDSMATERIAL_PLUGIN_URL . 'images/');

load_plugin_textdomain('ivn-all-kinds-material', false, dirname(plugin_basename(__FILE__)) . '/languages/');

if ( ! function_exists('add_action')) {
	echo 'do call a plugin in directly.';
	exit;
}

add_action('admin_enqueue_scripts', 'ivn_all_kinds_material_load_js_and_css');
function ivn_all_kinds_material_load_js_and_css() {
	if (preg_match('(ivn-all-kinds-material)', $_SERVER['REQUEST_URI'])) {
		if ((strpos($_SERVER['REQUEST_URI'], "w=cre") !== false) || (strpos($_SERVER['REQUEST_URI'], "w=upd") !== false)) {
			// jqueryvalidation
			wp_register_script('ivn_all_kinds_material_jqueryvalidation.js', IVN_ALLKINDSMATERIAL_PLUGIN_URL . 'vendors/jquery-validation-1.13.0/jquery.validate.min.js');
			wp_enqueue_script('ivn_all_kinds_material_jqueryvalidation.js');
			wp_register_script('ivn_all_kinds_material_jqueryvalidation_locale_ja.js', IVN_ALLKINDSMATERIAL_PLUGIN_URL . 'vendors/jquery-validation-1.13.0/localization/messages_ja.min.js');
			wp_enqueue_script('ivn_all_kinds_material_jqueryvalidation_locale_ja.js');
		}
	}

}

/**
create tables & directory
*/
function ivn_all_kinds_material_activation_options() {
	// check variable
	if ( ! defined('IVN_ALLKINDSMATERIAL_DOCUMENTS_PATH')) {
		trigger_error('Documents-path does not exist.', 
			headers_sent() || WP_DEBUG ? E_USER_WARNING : E_USER_NOTICE);
		return false;
	}
	// check directory
	if ( ! is_dir(IVN_ALLKINDSMATERIAL_DOCUMENTS_PATH)) {
		mkdir(IVN_ALLKINDSMATERIAL_DOCUMENTS_PATH, 0777, TRUE);
	}
	
	/* CREATE TABLE ⇒ .git/_database/upgrade/ivn_all_kinds_materials_create_2511.sql */
	return true;
}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'ivn_all_kinds_material_activation_options');

function ivn_all_kinds_material_manage() {
	require_once IVN_ALLKINDSMATERIAL_PLUGIN_PATH . "modules/manage.php";
	return true;
}

function ivn_all_kinds_material_actions() {
	add_menu_page(
		__('各種資料ダウンロード管理', 'ivn-all-kinds-material'),
		__('各種資料DL', 'ivn-all-kinds-material'),
		'edit_pages',
		'ivn-all-kinds-material', "ivn_all_kinds_material_manage",
		IVN_ALLKINDSMATERIAL_IMAGES_URL . 'img_download_16x16.png', 8);
}

add_action('admin_menu', 'ivn_all_kinds_material_actions');

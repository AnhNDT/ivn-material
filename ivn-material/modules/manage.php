<?php
// global variables & utilities functions
global $MATERIALS_CATEGORY_LIST;
global $MATERIALS_DISPLAY_PAGE_LIST;

/**
 * materials.category
 */
$MATERIALS_CATEGORY_LIST = array(
	'helpful' => 'お役立ち資料',
	'usecase' => '事例資料',
);

/**
 * materials.display_page
 * ◆：【特徴】
 * ■：【シーン】
 * ▲：【事例】
 */
$MATERIALS_DISPLAY_PAGE_LIST = array(
	'1227' => '◆', // function-business/
	'1230' => '◆', // function-mail/
	'1232' => '◆', // function-personal/
	'1266' => '■', // scene-business-telephone/
	'1258' => '■', // scene-btob-marketing/
	'1260' => '■', // scene-btob-nurturing/
	'1264' => '■', // scene-business-list/
	'1255' => '■', // scene-btob-mail/
	'1262' => '■', // scene-business-corporate/
	);

/**
 */
function get_posts_by_type($type='usecase') {
	$sSQL = <<<EOT
SELECT wp_posts.ID, wp_posts.post_title as name
FROM wp_posts
WHERE post_type = '$type'
	AND post_status = 'publish'
ORDER BY name
EOT;
	global $wpdb;
	return $wpdb->get_results($sSQL);
}

/**
 */
function get_posts_by_ID($list_id) {
	$sSQL = <<<EOT
SELECT wp_posts.ID, wp_posts.post_title as name
FROM wp_posts
WHERE post_status = 'publish'
	AND ID IN ($list_id)
ORDER BY name
EOT;
	global $wpdb;
	return $wpdb->get_results($sSQL);
}

/**
 */
function loadListMaterialsDisplayPage() {
	global $MATERIALS_DISPLAY_PAGE_LIST;
	// function & scene
	$list_id = implode(",", array_keys($MATERIALS_DISPLAY_PAGE_LIST));
	$list_posts = get_posts_by_ID($list_id);
	if ($list_posts != NULL) {
		foreach ($list_posts as $objPost) {
			$MATERIALS_DISPLAY_PAGE_LIST[$objPost->ID] .= $objPost->name;
		}
	}
	// attach list usecase
	$list_posts = get_posts_by_type();
	if ($list_posts != NULL) {
		foreach ($list_posts as $objPost) {
			$MATERIALS_DISPLAY_PAGE_LIST[$objPost->ID] = "▲" . $objPost->name;
		}
	}
	return true;
}

/**
 * get name of materials.display_page
 */
function getNameMaterialsDisplayPage($key = '') {
	global $MATERIALS_DISPLAY_PAGE_LIST;
	$strName = "";
	if ($key == NULL) return $strName;
	if ($key == '') return $strName;
	$arrTemp = explode(',', $key);
	foreach ($arrTemp as $value) {
		if (isset($MATERIALS_DISPLAY_PAGE_LIST[$value])) {
			$strName .= getOmitTitle($MATERIALS_DISPLAY_PAGE_LIST[$value]) . "<br>";
		}
	}
	return $strName;
}

/**
 * get name of materials.category
 */
function getNameMaterialsCategory($key = 'helpful') {
	global $MATERIALS_CATEGORY_LIST;
	return $MATERIALS_CATEGORY_LIST[$key];
}

/**
 *
 */
function getOmitTitle($str, $length=15, $trimmarker = '...') {
	if (mb_strlen($str) > $length) {
		return mb_substr($str, 0, $length, 'utf-8') . $trimmarker;
	}
	return $str;
}

/**
 * YYYY-MM-DD
 */
function formatDateYmd($date) {
	if ( ! isset($date)) return '';
	if ($date == '') return '';
	$phpdate = strtotime($date);
	return date('Y-m-d', $phpdate);
}

/**
 * select-control materials.usecase
 */
function createOptionMaterialsUsecase($selectedKey, $arrayObject) {
	echo "<option></option>";
	foreach ($arrayObject as $theUsecase) {
		if ($theUsecase->ID == "$selectedKey") {
			echo "<option value='$theUsecase->ID' selected>$theUsecase->name</option>";
		} else {
			echo "<option value='$theUsecase->ID'>$theUsecase->name</option>";
		}
	}
}

/**
 * select-control supports multiple
 */
function createOption($selectedKey, $arrayData) {
	foreach ($arrayData as $key => $value) {
		if (strpos($selectedKey, "$key") !== false) {
			echo "<option value='$key' selected>$value</option>";
		} else {
			echo "<option value='$key'>$value</option>";
		}
	}
}

/**
 * select-control materials.category
 */
function createOptionMaterialsCategory($selectedKey='0') {
	global $MATERIALS_CATEGORY_LIST;
	createOption($selectedKey, $MATERIALS_CATEGORY_LIST);
}

/**
 * select-control materials.display_page
 */
function createOptionMaterialsDisplayPage($selectedKey='0') {
	global $MATERIALS_DISPLAY_PAGE_LIST;
	echo "<option></option>";
	createOption($selectedKey, $MATERIALS_DISPLAY_PAGE_LIST);
}

// main
require_once IVN_MATERIAL_PLUGIN_PATH . "modules/controllers/MaterialsController.php";
$objMaterialsController = new MaterialsController();
$objMaterialsController->actions();

<?php
// global variables & utilities functions
global $MATERIALS_CATEGORY_LIST;
global $MATERIALS_DISPLAY_PAGE_LIST;

/**
 * materials.category
 */
$MATERIALS_CATEGORY_LIST = array (
						'helpful' => 'お役立ち資料',
						'usecase' => '事例資料',
					);
/**
 * materials.display_page
 */
$MATERIALS_DISPLAY_PAGE_LIST = array (
						'usecase' => '★活用事例の詳細',
						'scene' => '◆活用シーンの詳細',
						'function' => '▲特徴・機能の詳細',
				);

/**
 * get name of materials.category
 */
function getMaterialsCategoryName($key = 'helpful') {
	global $MATERIALS_CATEGORY_LIST;
	return $MATERIALS_CATEGORY_LIST[$key];
}

/**
 * get name of materials.display_page
 */
function getMaterialsDisplayPageName($key = 'usecase') {
	global $MATERIALS_DISPLAY_PAGE_LIST;
	$arrTemp = explode( ',', $key );
	$strName = "";
	foreach ($arrTemp as $value) {
		$strName .= $MATERIALS_DISPLAY_PAGE_LIST[$value] . "<br>";
	}
	return $strName;
}

/**
 * YYYY-MM-DD
 */
function formatDateYmd($date) {
	if (!isset($date)) return '';
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
		if ( $theUsecase->ID == "$selectedKey" ) {
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
		if (strpos( $selectedKey, "$key" ) !== false) {
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

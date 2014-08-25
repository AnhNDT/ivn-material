<?php
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
function formatDateYmdJP($date) {
	if ( ! isset($date)) return '';
	if ($date == '') return '';
	$phpdate = strtotime($date);
	return date('Y年m月d日', $phpdate);
}
function convertReadableFileSize($size, $unit='') {
	if (( ! $unit && $size >= 1<<30) || $unit == "GB")
		return number_format($size/(1<<30),2)."GB";
	if (( ! $unit && $size >= 1<<20) || $unit == "MB")
		return number_format($size/(1<<20),2)."MB";
	if (( ! $unit && $size >= 1<<10) || $unit == "KB")
		return number_format($size/(1<<10),2)."KB";
	return number_format($size)." bytes";
}
// main
require_once IVN_ALLKINDSMATERIAL_PLUGIN_PATH . "modules/controllers/AllKindsMaterialsController.php";
$objAKMController = new AllKindsMaterialsController();
$objAKMController->actions();

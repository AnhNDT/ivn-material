<?php
global $IVN_Model;

$material_list = $IVN_Model->search_data;
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta name="robots" content="noindex,nofollow">
	<meta name="googlebot" content="noindex">
	<title>各種資料ダウンロード</title>
	<link href="http://promote.list-finder.jp/images/favicon.ico" rel="shortcut icon">
	<link rel="stylesheet" href="css/reset.css" type="text/css">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/rollover.js"></script>
</head>
<body>
	<div id="wrap"><!--wrap-->
		<div id="main_wrap"><!--main_wrap-->
			<div id="main" class="clearfix"><!--main-->
				<div id="mainL1"><!--mainL-->
					<div id="function"><!--function-->
<?php
// RENDER-MATERIAL-LIST-[BEGIN]
$intRecords = 0;
if ($material_list):
	$flgBoxLeft = false;
	$strClassBox = '';
	$flgAddnewRow = true;
	$intTotalRecords = count($material_list);
	foreach ($material_list as $theMaterial):
		$strClassBox = 'right';
		$flgBoxLeft = !$flgBoxLeft;
		$intRecords++;
		if ($flgBoxLeft) {
			$strClassBox = 'left';
			$flgAddnewRow = true;
		}
		$file_description = json_decode($theMaterial->file_description, TRUE);
		$file_description['ext'] = strtoupper($file_description['ext']);

		if ($flgBoxLeft) {
			echo "						<div class='row_material'><!--row_material-->\r\n";
		}
?>
							<div class="box_<?php echo $strClassBox; ?>">
								<h2><span class="headline"><?php echo htmlspecialchars($theMaterial->title); ?></span></h2>
								<div class="box_material_download sdw"><!--box_material_download-->
									<div class="inr clearfix"><!--inr-->
										<div class="inrLayer"><!--inrLayer-->
											<h3><?php echo $theMaterial->description; ?></h3>
											<div class="box_content">
												<div class="box_date1" <?php if ( ! isset($theMaterial->publish_start_date)) echo "style='display:none;'"; ?>>
													<p class="box_text_left">適用開始日</p>
													<p class="box_text_right"><?php echo formatDateYmdJP($theMaterial->publish_start_date); ?></p>
												</div>
												<div class="box_date2">
													<p class="box_text_left">最終更新日</p>
													<p class="box_text_right"><?php echo formatDateYmdJP($theMaterial->publish_updated_date); ?></p>
												</div>
												<div class="box_footer">
													
													<div class="text2">
														<p>形式　：<?php echo $file_description['ext']; ?></p>
														<p>サイズ：<?php echo $file_description['size']; ?></p>
													</div>
													<div class="btn_download"><a href="<?php echo IVN_ALLKINDSMATERIAL_DOCUMENTS_URI . $theMaterial->filename;?>"><img src="images/ekm_btn_download.png" alt="ダウンロードする" width="202" height="45" class="rollover" target="_blank"/></a></div>
												</div>
											</div>
										</div><!--/inrLayer-->
									</div><!--/inr-->
								</div><!--/box_material_download-->
								<div class="clear"></div>
							</div>
<?php
		if ((!$flgBoxLeft) || ($flgBoxLeft && ($intRecords == $intTotalRecords))){ // close row
			echo "							<div class='clear'></div>\r\n";
			echo "						</div><!--/row_material-->\r\n";
		}
?>
<?php
	endforeach;
endif;
if ($intRecords == 0) {
	_e('各種資料ダウンロードがありません。');

}
$IVN_Model->html_generate_result = array(
	'records' => $intRecords,
	'status' => 'OK',
);
// RENDER-MATERIAL-LIST-[END]
?>
					</div><!--/function-->
				</div><!--/mainL1-->
			</div><!--main-->
		</div><!--/main_wrap-->
	</div><!--/wrap-->
</body>
</html>
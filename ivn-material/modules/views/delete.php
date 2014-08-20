<?php
global $IVN_Model;

$method = "delete";
$workAction = IVN_MATERIAL_URL ."&amp;w=sav";

	$objMaterial = $IVN_Model;
?>

<style>

h2 span {
	padding-right:35px;
	background:url(<?php echo IVN_MATERIAL_IMAGES_URL; ?>img_download_32x32.png) no-repeat left center;
}

#filename-review {
	border-style:solid;
	border-width:1px;
	float:left;
	margin:13px 5px 5px 1px;
	padding:3px 5px;
	text-align:left;
	width:25em;
}
.form-field .show-text {
	width:35em;
}
</style>
<div class="wrap"><!--/wrap-お役立ち資料ダウンロード　削除-->
	<h2><span></span><?php _e( 'お役立ち資料ダウンロード', 'ivn-material' ); ?>～<?php _e( '削除', 'ivn-material' ); ?></h2>
	<p><?php _e('ダウンロードファイルを削除し、サイトのダウンロード一覧ページから削除する。', 'ivn-material'); ?>
		<br/>　※ <a target="_blank" href="<?php echo get_site_url(); ?>/download-materials/"><?php _e( '一覧ページはこちら', 'ivn-material' ); ?></a></p>
<form action="<?php echo $workAction; ?>" method="post" name="creatematerial" id="creatematerial" class="validate" enctype="multipart/form-data">
<input name="method" type="hidden" value="<?php echo $method; ?>" />
<input name="ID" type="hidden" value="<?php echo $objMaterial->ID; ?>" />
<table class="form-table">
	<tr class="form-field"> 
		<th scope="row"><label for="title"><?php _e( 'タイトル', 'ivn-material' ); ?></label></th>
		<td><div class="show-text"><?php echo $objMaterial->title; ?></div></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="filename"><?php _e( '添付ファイル', 'ivn-material' ); ?></label></th>
		<td><div id="filename-review" style="display: block;">※<?php echo $objMaterial->filename; ?></div></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="publish_date_start"><?php _e( '日付', 'ivn-material' ); ?></label></th>
		<td><?php echo formatDateYmd($objMaterial->publish_date_start); ?></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="category"><?php  _e( 'どのページにリストする', 'ivn-material' ); ?></label></th>
		<td><?php echo getMaterialsDisplayPageName($objMaterial->display_page); ?></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="creator"><?php _e( '対象者', 'ivn-material' ); ?></label></th>
		<td><div class="show-text"><?php echo $objMaterial->creator; ?></div></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="category"><?php _e( 'カテゴリー', 'ivn-material' ); ?></label></th>
		<td><?php echo getMaterialsCategoryName($objMaterial->category); ?></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="creator"><?php _e( '事例', 'ivn-material' ); ?></label></th>
		<td><?php echo $objMaterial->post_title; ?></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="creator"><?php _e( '概要', 'ivn-material' ); ?></label></th>
		<td><div class="show-text"><?php echo $objMaterial->description; ?></div></td>
	</tr>
	</table>

<p class="submit">
	<input type="submit" id="btnSubmit" class="button button-primary" value="<?php _e('削除', 'ivn-material'); ?>" />
</p>
</form>
</div><!--/wrap-お役立ち資料ダウンロード　削除-->
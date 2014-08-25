<?php
global $IVN_Model;

$method = "delete";
$workAction = IVN_ALLKINDSMATERIAL_URL ."&amp;w=sav";

$objMaterial = $IVN_Model;
?>

<style>

h2 span {
	padding-right:35px;
	background:url(<?php echo IVN_ALLKINDSMATERIAL_IMAGES_URL; ?>img_download_32x32.png) no-repeat left center;
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
<div class="wrap"><!--/wrap-各種資料ダウンロード　削除-->
	<h2><span></span><?php _e('各種資料ダウンロード', 'ivn-all-kinds-material'); ?>～<?php _e('削除', 'ivn-all-kinds-material'); ?></h2>
	<p><?php _e('ダウンロードファイルを削除し、サイトのダウンロード一覧ページから削除する。', 'ivn-all-kinds-material'); ?>
		<br/>　※ <a target="_blank" href="<?php echo get_site_url(); ?>/documents/all-kinds-material/index.html"><?php _e('一覧ページはこちら', 'ivn-all-kinds-material'); ?></a></p>
<form action="<?php echo $workAction; ?>" method="post" name="creatematerial" id="creatematerial" class="validate" enctype="multipart/form-data">
<input name="method" type="hidden" value="<?php echo $method; ?>" />
<input name="ID" type="hidden" value="<?php echo $objMaterial->ID; ?>" />
<table class="form-table">
	<tr class="form-field"> 
		<th scope="row"><label for="title"><?php _e('タイトル', 'ivn-all-kinds-material'); ?></label></th>
		<td><div class="show-text"><?php echo $objMaterial->title; ?></div></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="filename"><?php _e('添付ファイル', 'ivn-all-kinds-material'); ?></label></th>
		<td><div id="filename-review" style="display: block;">※<?php echo $objMaterial->filename; ?></div></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="publish_updated_date"><?php _e('最終更新日', 'ivn-all-kinds-material'); ?></label></th>
		<td><?php echo formatDateYmd($objMaterial->publish_updated_date); ?></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="publish_start_date"><?php  _e('適用開始日', 'ivn-all-kinds-material'); ?></label></th>
		<td><?php echo formatDateYmd($objMaterial->publish_start_date); ?></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="display_order"><?php _e('表示順序', 'ivn-all-kinds-material'); ?></label></th>
		<td><div class="show-text"><?php echo $objMaterial->display_order; ?></div></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="description"><?php _e('概要', 'ivn-all-kinds-material'); ?></label></th>
		<td><div class="show-text"><?php echo $objMaterial->description; ?></div></td>
	</tr>
	</table>

<p class="submit">
	<input type="submit" id="btnSubmit" class="button button-primary" value="<?php _e('削除', 'ivn-all-kinds-material'); ?>" />
</p>
</form>
</div><!--/wrap-各種資料ダウンロード　削除-->
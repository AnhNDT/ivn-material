<?php
global $IVN_Model;

$txt_screen_title = __('各種資料ダウンロード', 'ivn-all-kinds-material') . '～' . __('新規作成', 'ivn-all-kinds-material');
$txt_screen_description = __('新しいダウンロードファイルを作成し、サイトのダウンロード一覧ページに追加する。', 'ivn-all-kinds-material');
$method = "insert";
$workAction = IVN_ALLKINDSMATERIAL_URL ."&amp;w=sav";

$objMaterial = $IVN_Model;
// detect workAction==CREate or UPDate
if ($objMaterial->ID != '-1') {
	$txt_screen_title = __('各種資料ダウンロード', 'ivn-all-kinds-material') . '～' . __('編集', 'ivn-all-kinds-material');
	$txt_screen_description = __('ダウンロードファイルを更新し、サイトのダウンロード一覧ページに反映する。', 'ivn-all-kinds-material');
	$method = "update";
}
?>
<style>

h2 span {
	padding-right:35px;
	background:url(<?php echo IVN_ALLKINDSMATERIAL_IMAGES_URL; ?>img_download_32x32.png) no-repeat left center;
}
#creatematerial input.regular-text,
#creatematerial select,
#creatematerial textarea {
	width:35em;
}

#creatematerial span.description_required {
	color:#F78181;
	font-size:13px;
	font-style:italic;
}

textarea,
input[type="text"],
input[type="file"],
input,
select {
	border-color:#DDD;
	box-shadow:0px 1px 2px rgba(0, 0, 0, 0.07);
}

input:invalid,
textarea:invalid,
select:invalid {
	border-color:#ff0000;
}
#filename-review {
	border-style:solid;
	border-width:1px;
	float:left;
	margin:0px 1px;
	padding:3px 5px;
	text-align:left;
	width:25em;
}
/**/
#field { margin-left: .5em; float: left; }
#field, label {
	font-family:Arial, Helvetica, sans-serif;
	font-size:small;
}
br { clear: both; }
input { border: 1px solid black; margin-bottom: .5em;  }
input.error { border: 1px solid red; }
label.error {
	background:url('<?php echo IVN_ALLKINDSMATERIAL_IMAGES_URL; ?>unchecked.gif') no-repeat;
	padding-left:16px;
	margin-left:.3em;
}
label.valid {
	background: url('<?php echo IVN_ALLKINDSMATERIAL_IMAGES_URL; ?>checked.gif') no-repeat;
	display:block;
	width:16px;
	height:16px;
}
</style>

<div class="wrap"><!--wrap-各種資料ダウンロード　追加-->
	<h2><span></span><?php echo $txt_screen_title; ?></h2>
	<p><?php echo $txt_screen_description; ?>　<a target="_blank" href="<?php echo IVN_ALLKINDSMATERIAL_IMAGES_URL; ?>materials_guide.png"><img src="<?php echo IVN_ALLKINDSMATERIAL_IMAGES_URL; ?>help.png" alt="HELP" height="16" width="16"></a>
		<br/>　※ <a target="_blank" href="<?php echo get_site_url(); ?>/documents/all-kinds-material/index.html"><?php _e('一覧ページはこちら', 'ivn-all-kinds-material'); ?></a>
	</p>
<form action="<?php echo $workAction; ?>" method="post" name="creatematerial" id="creatematerial" class="validate" enctype="multipart/form-data">
<input name="method" type="hidden" value="<?php echo $method; ?>" />
<input name="ID" type="hidden" value="<?php echo $objMaterial->ID; ?>" />
<input name="filename_old" type="hidden" value="<?php echo $objMaterial->filename; ?>" />
<table class="form-table">
	<tr class="form-required"> 
		<th scope="row"><label for="title"><?php _e('タイトル', 'ivn-all-kinds-material'); ?> <span class="description_required">(<?php _e('必須', 'ivn-all-kinds-material'); ?>)</span></label></th>
		<td><input name="title" type="text" id="title" autofocus required class="regular-text" placeholder="例: ご利用規約" value="<?php echo $objMaterial->title; ?>" maxlength="26"/></td>
	</tr>
	<tr class="form-required">
		<th scope="row"><label for="filename"><?php _e('添付ファイル', 'ivn-all-kinds-material'); ?> <span class="description_required">(<?php _e('必須', 'ivn-all-kinds-material'); ?>)</span></label></th>
		<td>
			<input name="filename" type="file" id="filename" class="regular-text" <?php if($objMaterial->filename == '') {echo 'required';} ?> />
			<br/><div id="filename-review" style="display: block;">※<?php echo $objMaterial->filename; ?></div>
		</td>
	</tr>
	<tr class="">
		<th scope="row"><label for="publish_updated_date"><?php _e('最終更新日', 'ivn-all-kinds-material'); ?> <span class="description_required">(<?php _e('必須', 'ivn-all-kinds-material'); ?>)</span></label></th>
		<td><input name="publish_updated_date" type="text" id="publish_updated_date" class="regular-text" placeholder="<?php echo date('Y-m-d'); ?>" required value="<?php echo formatDateYmd($objMaterial->publish_updated_date); ?>" /></td>
	</tr>
	<tr class="">
		<th scope="row"><label for="publish_start_date"><?php _e('適用開始日', 'ivn-all-kinds-material'); ?></label></th>
		<td><input name="publish_start_date" type="text" id="publish_start_date" class="regular-text" placeholder="<?php echo date('Y-m-d'); ?>" value="<?php echo formatDateYmd($objMaterial->publish_start_date); ?>" /></td>
	</tr>
	<tr class="">
		<th scope="row"><label for="display_order"><?php _e('表示順序', 'ivn-all-kinds-material'); ?> <span class="description_required">(<?php _e('必須', 'ivn-all-kinds-material'); ?>)</span></label></th>
		<td><input name="display_order" type="text" id="display_order" class="regular-text" placeholder="1" required value="<?php echo $objMaterial->display_order; ?>" /><br>　※9999:最低</td>
	</tr>
	<tr class="">
		<th scope="row"><label for="description"><?php _e('概要', 'ivn-all-kinds-material'); ?> <span class="description_required">(<?php _e('必須', 'ivn-all-kinds-material'); ?>)</span></label></th>
		<td><textarea rows="4" cols="50" name="description" type="text" id="description" required placeholder="例: リストファインダーご利用規約です。"><?php echo $objMaterial->description; ?></textarea> </td>
	</tr>
	</table>

<p class="submit">
	<input type="submit" id="btnSubmit" class="button button-primary" value="<?php _e('保存', 'ivn-all-kinds-material'); ?>" />
</p>
</form>
</div><!--/wrap-各種資料ダウンロード　追加-->
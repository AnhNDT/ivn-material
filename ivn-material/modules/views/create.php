<?php
global $IVN_Model;

$txt_screen_title = __( 'お役立ち資料ダウンロード', 'ivn-material' ) . '～' . __( '新規作成', 'ivn-material' );
$txt_screen_description = __( '新しいダウンロードファイルを作成し、サイトのダウンロード一覧ページに追加する。', 'ivn-material' );
$method = "insert";
$workAction = IVN_MATERIAL_URL ."&amp;w=sav";
?>

<?php
	$objMaterial = $IVN_Model;
	// detect workAction==CREate or UPDate
	if ($objMaterial->ID != '-1') {
		$txt_screen_title = __( 'お役立ち資料ダウンロード', 'ivn-material' ) . '～' . __( '編集', 'ivn-material' );
		$txt_screen_description = __( 'ダウンロードファイルを更新し、サイトのダウンロード一覧ページに反映する。', 'ivn-material' );
		$method = "update";
	}
?>

<script type='text/javascript'>
jQuery(document).ready(function($) {
	$("#display_page").select2({
		//minimumInputLength : 2,
		closeOnSelect : false,
		allowClear: true,
		width: "35em",
	});
	
	$("#post_id").select2({
		//minimumInputLength : 2,
		closeOnSelect : false,
		allowClear: true,
		width: "35em",
	});

	// fix error-message jqueryvalidation+selec2
	$("#post_id").removeAttr("title");
	

	$('#creatematerial').validate({
		rules: {
			publish_date_start: {
				date: true
			}
		},
		// fix error-message jqueryvalidation+selec2
		highlight: function (element, errorClass, validClass) {
			var elem = $(element);
			//alert(elem.attr("id"));
			if (elem.hasClass("select2-offscreen")) {
				// remove error style of <div>
				$("#s2id_" + elem.attr("id")).removeClass(errorClass);
				// adjust error style of select * multiple-select,
				$("#s2id_" + elem.attr("id") +" ul").css("border-color", "#F00");
				$("#s2id_" + elem.attr("id") +" a").css("border-color", "#F00");
			}
		},
		// When removing make the same adjustments as when adding
		unhighlight: function (element, errorClass, validClass) {
			var elem = $(element);
			if (elem.hasClass("select2-offscreen")) {
				$("#s2id_" + elem.attr("id") + " ul").css("border-color", "");
				$("#s2id_" + elem.attr("id") +" a").css("border-color", "");
			}
		},
	});
	// If the change event fires we want to see if the form validates.
	// But we don't want to check before the form has been submitted by the user initially.
	$(".select2-offscreen").change(function(){
		$(this).valid();
	});
});

</script>
<style>

h2 span {
	padding-right:35px;
	background:url(<?php echo IVN_MATERIAL_IMAGES_URL; ?>img_download_32x32.png) no-repeat left center;
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
	background:url('<?php echo IVN_MATERIAL_IMAGES_URL; ?>unchecked.gif') no-repeat;
	padding-left:16px;
	margin-left:.3em;
}
label.valid {
	background: url('<?php echo IVN_MATERIAL_IMAGES_URL; ?>checked.gif') no-repeat;
	display:block;
	width:16px;
	height:16px;
}
</style>

<div class="wrap">
	<h2><span></span><?php echo $txt_screen_title; ?></h2>
	<p><?php echo $txt_screen_description; ?>　<a target="_blank" href="<?php echo IVN_MATERIAL_IMAGES_URL; ?>materials_guide.png"><img src="<?php echo IVN_MATERIAL_IMAGES_URL; ?>help.png" alt="HELP" height="16" width="16"></a>
		<br/>　※ <a target="_blank" href="<?php echo get_site_url(); ?>/download-materials/"><?php _e( '一覧ページはこちら', 'ivn-material' ); ?></a></p>
		
<form action="<?php echo $workAction; ?>" method="post" name="creatematerial" id="creatematerial" class="validate" enctype="multipart/form-data">
<input name="method" type="hidden" value="<?php echo $method; ?>" />
<input name="ID" type="hidden" value="<?php echo $objMaterial->ID; ?>" />
<input name="filename_old" type="hidden" value="<?php echo $objMaterial->filename; ?>" />
<table class="form-table">
	<tr class="form-required"> 
		<th scope="row"><label for="title"><?php _e( 'タイトル', 'ivn-material' ); ?> <span class="description_required">(<?php _e( '必須', 'ivn-material' ); ?>)</span></label></th>
		<td><input name="title" type="text" id="title" autofocus required class="regular-text" placeholder="例: 持続的に商談につながるセミナー運営とは(詳細編)" value="<?php echo $objMaterial->title; ?>" /></td>
	</tr>
	<tr class="form-required">
		<th scope="row"><label for="filename"><?php _e( '添付ファイル', 'ivn-material' ); ?> <span class="description_required">(<?php _e( '必須', 'ivn-material' ); ?>)</span></label></th>
		<td>
			<input name="filename" type="file" id="filename"  class="regular-text" <?php if($objMaterial->filename == '') {echo 'required';} ?> />
			<br/><div id="filename-review" style="display: block;">※<?php echo $objMaterial->filename; ?></div>
		</td>
	</tr>
	<tr class="">
		<th scope="row"><label for="publish_date_start"><?php _e( '日付', 'ivn-material' ); ?> <span class="description_required">(<?php _e( '必須', 'ivn-material' ); ?>)</span></label></th>
		<td><input name="publish_date_start" type="text" id="publish_date_start"  class="regular-text" placeholder="<?php echo date('Y-m-d'); ?>" required value="<?php echo formatDateYmd($objMaterial->publish_date_start); ?>" /></td>
	</tr>
	<tr class="">
		<th scope="row"><label for="display_page"><?php _e( 'どのページにリストする', 'ivn-material' ); ?> <span class="description_required">(<?php _e( '必須', 'ivn-material' ); ?>)</span></label></th>
		<td>
			<select name="display_page[]" id="display_page" required multiple placeholder="--- <?php _e( '以下項目を選択してください', 'ivn-material' ); ?> ---" ><?php createOptionMaterialsDisplayPage($objMaterial->display_page); ?>
		</td>
	</tr>
	<tr class="">
		<th scope="row"><label for="creator"><?php _e( '対象者', 'ivn-material' ); ?> <span class="description_required">(<?php _e( '必須', 'ivn-material' ); ?>)</span></label></th>
		<td><input name="creator" type="text" id="creator"  class="regular-text" placeholder="例: 法人営業・マーケティング担当者" required value="<?php echo $objMaterial->creator; ?>" /></td>
	</tr>
	<tr class="">
		<th scope="row"><label for="category"><?php _e( 'カテゴリー', 'ivn-material' ); ?> <span class="description_required">(<?php _e( '必須', 'ivn-material' ); ?>)</span></label></th>
		<td>
			<select name="category" id="category" required placeholder="--- <?php _e( '以下項目を選択してください', 'ivn-material' ); ?> ---" ><?php createOptionMaterialsCategory($objMaterial->category); ?></select>
		</td>
	</tr>
	<tr class="usecase">
		<th scope="row"><label for="post_id"><?php _e( '事例', 'ivn-material' ); ?> <span class="description_required">(<?php _e( '必須', 'ivn-material' ); ?>)</span></label></th>
		<td>
			<select name="post_id" id="post_id" required placeholder="--- <?php _e( '以下項目を選択してください', 'ivn-material' ); ?> ---" >
				<?php createOptionMaterialsUsecase($objMaterial->post_id, $objMaterial->searchUsecase()); ?>
			</select>
		</td>
	</tr>
	<tr class="">
		<th scope="row"><label for="description"><?php _e( '概要', 'ivn-material' ); ?></label></th>
		<td><textarea rows="4" cols="50" name="description" type="text" id="description"placeholder="例: データベース開発支援ツール"><?php echo $objMaterial->description; ?></textarea> </td>
	</tr>
	</table>

<p class="submit">
	<input type="submit" id="btnSubmit" class="button button-primary" value="<?php _e('保存', 'ivn-material'); ?>" />
</p>
</form>
</div>
<?php
global $IVN_Model;

$material_list = $IVN_Model->search_data;
$categoryCounts = array (
	'all' => 0,
);

// count materials.category
$tmpList = $IVN_Model->countCategory();
foreach ($tmpList as $theCount) {
	$categoryCounts[$theCount->name] += $theCount->value;
}

?>

<style>
h2 span {
	padding-right:35px;
	background: url(<?php echo IVN_ALLKINDSMATERIAL_IMAGES_URL; ?>img_download_32x32.png) no-repeat left center;
}
.wp-list-table .column-title { width: auto; }
.wp-list-table .column-publish-updated-date,
.wp-list-table .column-publish-start-date { width: 85px; }
.wp-list-table .column-display-order { width: 65px; }
.wp-list-table .column-filename { width: 40px; }
.wrap .html-generate {
	color:#0174DF;
	font-size:14px;
}
.wrap .html-generate-records {
	color:#0040FF;
	font-size:16px;
	font-weight:bold;
}
</style>
<div class="wrap"><!--wrap-各種資料ダウンロード　一覧-->
	<h2>
		<span></span><?php _e('各種資料ダウンロード', 'ivn-all-kinds-material'); ?>～<?php _e('一覧', 'ivn-all-kinds-material'); ?>
		<a href="<?php echo IVN_ALLKINDSMATERIAL_URL ."&amp;w=cre&amp;wID=-1"; ?>" class="add-new-h2"><?php _e('追加', 'ivn-all-kinds-material'); ?></a>
	</h2>
	<p><a href="<?php echo IVN_ALLKINDSMATERIAL_URL ."&amp;w=gen&amp;wID=-1"; ?>" class="add-new-h2"><?php _e('ページ再作成', 'ivn-all-kinds-material'); ?></a>&nbsp;<?php _e('をクリックしてダウンロード一覧のHTMLページを再作成する。', 'ivn-all-kinds-material'); ?>　　　　　※ <a target="_blank" href="<?php echo get_site_url(); ?>/documents/all-kinds-material/index.html"><?php _e('一覧ページはこちら', 'ivn-all-kinds-material'); ?></a>
<?php if (isset($IVN_Model->html_generate_result)): ?>
		<br>　　（<span class="html-generate"><?php _e('HTMLページが再作成されました。ダウンロードファイル数＝', 'ivn-all-kinds-material'); ?></span><span class="html-generate-records"><?php echo $IVN_Model->html_generate_result['records'];?></span>）
<?php endif; ?>
	</p>

<form method='POST' action="<?php echo IVN_ALLKINDSMATERIAL_URL; ?>">
<div class="tablenav top">
	<div class="alignleft actions bulkactions">
		<select name='action' disabled>
			<option value='' selected='selected'>Bulk Actions</option>
			<option value='delete'>Delete</option>
		</select>
		<input type="submit" name="" id="doaction" class="button action" value="Apply" disabled />
	</div>
	<ul class='subsubsub'>
		<li class="all"><a href="<?php echo IVN_ALLKINDSMATERIAL_URL; ?>" class="current" >All <span class="count">(<?php echo $categoryCounts['all']; ?>)</span></a></li>
	</ul>
	<br class="clear" />
</div>

<table class="wp-list-table widefat fixed ivn-material" cellspacing="0">
	<thead>
	<tr>
		<th scope='col' class='manage-column column-cb check-column'>
			<input id="cb-select-all-1" type="checkbox" />
		</th>
		<th scope='col' class='manage-column column-title sortable asc'>
			<a href="<?php echo IVN_ALLKINDSMATERIAL_URL; ?>">
				<span><?php _e('タイトル', 'ivn-all-kinds-material'); ?></span><span class="sorting-indicator"></span></a>
		</th>
		<th scope='col' class='manage-column column-publish-updated-date'>
			<span><?php _e('最終更新日', 'ivn-all-kinds-material'); ?></span>
		</th>
		<th scope='col' class='manage-column column-publish-start-date'>
			<span><?php _e('適用開始日', 'ivn-all-kinds-material'); ?></span>
		</th>
		<th scope='col' class='manage-column column-display-order'>
			<span><?php _e('表示順序', 'ivn-all-kinds-material'); ?></span>
		</th>
		<th scope='col' class='manage-column column-filename'><img width="20" height="20" src="<?php echo IVN_ALLKINDSMATERIAL_IMAGES_URL; ?>img_attachment_40x40.png"/></th>
	</tr>
	</thead>

	<tfoot>
	<tr>
		<th scope='col' class='manage-column column-cb check-column'>
			<input id="cb-select-all-2" type="checkbox" />
		</th>
		<th scope='col' class='manage-column column-title sortable asc'>
			<a href="<?php echo IVN_ALLKINDSMATERIAL_URL; ?>">
				<span><?php _e('タイトル', 'ivn-all-kinds-material'); ?></span><span class="sorting-indicator"></span></a>
		</th>
		<th scope='col' class='manage-column column-publish-updated-date'>
			<span><?php _e('最終更新日', 'ivn-all-kinds-material'); ?></span>
		</th>
		<th scope='col' class='manage-column column-publish-start-date'>
			<span><?php _e('適用開始日', 'ivn-all-kinds-material'); ?></span>
		</th>
		<th scope='col' class='manage-column column-display-order'>
			<span><?php _e('表示順序', 'ivn-all-kinds-material'); ?></span>
		</th>
		<th scope='col' class='manage-column column-filename'><img width="20" height="20" src="<?php echo IVN_ALLKINDSMATERIAL_IMAGES_URL; ?>img_attachment_40x40.png"/></th>
	</tr>
	</tfoot>

	<tbody id="the-list">
<?php
// RENDER-MATERIAL-LIST-[BEGIN]
if ($material_list):
	$oddRow = false;
	foreach ($material_list as $theMaterial):
		$urlWorkAction= IVN_ALLKINDSMATERIAL_URL . "&amp;wID=" . $theMaterial->ID . "&amp;w=";
		$oddRow = !$oddRow;
?>
		<tr id='material-<?php echo $theMaterial->ID; ?>' class="<?php if($oddRow) echo "alternate"; ?>">
			<th scope='row' class='check-column'>
				<input type='checkbox' name='ivn_materials[]' id='material_<?php echo $theMaterial->ID; ?>' value='<?php echo $theMaterial->ID; ?>' />
			</th>
			<td class="column-title">
				<strong><a href="<?php echo $urlWorkAction ."upd"; ?>"><?php echo htmlspecialchars($theMaterial->title); ?></a></strong>
				<br />
				<div class="row-actions">
					<span class='edit'><a href="<?php echo $urlWorkAction ."upd"; ?>"><?php _e('編集', 'ivn-all-kinds-material' ); ?></a> | </span>
					<span class='delete'><a class='submitdelete' href="<?php echo $urlWorkAction ."del"; ?>"><?php _e('削除', 'ivn-all-kinds-material'); ?></a></span>
				</div>
			</td>
			<td class="column-publish-updated-date"><?php echo formatDateYmd($theMaterial->publish_updated_date); ?></td>
			<td class="column-publish-start-date"><?php echo formatDateYmd($theMaterial->publish_start_date); ?></td>
			<td class="column-display-order"><?php echo $theMaterial->display_order; ?></td>
			<td class="column-filename"><a target="_blank" href="<?php echo IVN_ALLKINDSMATERIAL_DOCUMENTS_URI . $theMaterial->filename; ?>"><img width="24" height="24" src="<?php echo IVN_ALLKINDSMATERIAL_IMAGES_URL; ?>img_download_32x32.png"/></a></td>
		</tr>
<?php
	endforeach;
endif;
// RENDER-MATERIAL-LIST-[END]
?>
	</tbody>
</table>

</form>

<br class="clear" />
</div><!--/wrap-各種資料ダウンロード　一覧-->
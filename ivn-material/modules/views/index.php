<?php
global $IVN_Model;
global $MATERIALS_CATEGORY_LIST;

$material_list = $IVN_Model->search_data;
$categoryCounts = array (
						'all' => 0,
						'helpful' => 0,
						'usecase' => 0,
					);
// count materials.category
$tmpList = $IVN_Model->countCategory();
foreach ( $tmpList as $theCount ) {
	if ( $theCount->name == 'helpful' ) {
		$categoryCounts['helpful'] = $theCount->value;
	} elseif ( $theCount->name == 'usecase' ) {
		$categoryCounts['usecase'] = $theCount->value;
	} 
	$categoryCounts['all'] += $theCount->value;
}
// searching materials.category
$categorySearching = 'all';
if ( isset( $_GET['category'] ) ) {
	$categorySearching = $_GET['category'];
}
?>

<style>
h2 span {
	padding-right:35px;
	background: url(<?php echo IVN_MATERIAL_IMAGES_URL; ?>img_download_32x32.png) no-repeat left center;
}
.wp-list-table .column-title { width: 30%; }
.wp-list-table .column-publish-date-start { width: 85px; }
.wp-list-table .column-display-page { width: 115px; }
.wp-list-table .column-filename { width: 40px; }

</style>
<div class="wrap"><!--wrap-お役立ち資料ダウンロード　一覧-->
	<h2>
		<span></span>
		<?php _e( 'お役立ち資料ダウンロード', 'ivn-material' ); ?>～<?php _e( '一覧', 'ivn-material' ); ?>
		<a href="<?php echo IVN_MATERIAL_URL ."&amp;w=cre&amp;wID=-1"; ?>" class="add-new-h2"><?php _e( '追加', 'ivn-material' ); ?></a>
	</h2>
	<p>　※ <a target="_blank" href="<?php echo get_site_url(); ?>/download-materials/"><?php _e( '一覧ページはこちら', 'ivn-material' ); ?></a></p>
<form method='POST' action="<?php echo IVN_MATERIAL_URL; ?>">
<div class="tablenav top">
	<div class="alignleft actions bulkactions">
		<select name='action' disabled>
			<option value='' selected='selected'>Bulk Actions</option>
			<option value='delete'>Delete</option>
		</select>
		<input type="submit" name="" id="doaction" class="button action" value="Apply" disabled />
	</div>
	<div class='tablenav-pages one-page' style="display: none;">
		<span class="displaying-num">2 items</span>
		<span class='pagination-links'><a class='first-page disabled' title='Go to the first page' href='http://anhndt.list-finder.jp:8080/wp-admin/users.php'>&laquo;</a>
		<a class='prev-page disabled' title='Go to the previous page' href='http://anhndt.list-finder.jp:8080/wp-admin/users.php?paged=1'>&lsaquo;</a>
		<span class="paging-input"><input class='current-page' title='Current page' type='text' name='paged' value='1' size='1' /> of <span class='total-pages'>1</span></span>
		<a class='next-page disabled' title='Go to the next page' href='http://anhndt.list-finder.jp:8080/wp-admin/users.php?paged=1'>&rsaquo;</a>
		<a class='last-page disabled' title='Go to the last page' href='http://anhndt.list-finder.jp:8080/wp-admin/users.php?paged=1'>&raquo;</a></span>
	</div>
	<ul class='subsubsub'>
		<li class='all'><a href='<?php echo IVN_MATERIAL_URL; ?>' <?php if ($categorySearching == 'all') echo "class='current'"; ?> >All <span class="count">(<?php echo $categoryCounts['all']; ?>)</span></a> |</li>
		<li class='administrator'><a href='<?php echo IVN_MATERIAL_URL ."&amp;category=helpful"; ?>' <?php if ($categorySearching == 'helpful') echo "class='current'"; ?>><?php echo $MATERIALS_CATEGORY_LIST['helpful']; ?> <span class="count">(<?php echo $categoryCounts['helpful']; ?>)</span></a> |</li>
		<li class='administrator'><a href='<?php echo IVN_MATERIAL_URL ."&amp;category=usecase"; ?>' <?php if ($categorySearching == 'usecase') echo "class='current'"; ?>><?php echo $MATERIALS_CATEGORY_LIST['usecase']; ?> <span class="count">(<?php echo $categoryCounts['usecase']; ?>)</span></a></li>
	</ul>
	<br class="clear" />
</div>

<table class="wp-list-table widefat fixed ivn-material" cellspacing="0">
	<thead>
	<tr>
		<th scope='col' class='manage-column column-cb check-column'>
			<input id="cb-select-all-1" type="checkbox" />
		</th>
		<th scope='col' class='manage-column column-title sortable desc'>
			<a href="<?php echo IVN_MATERIAL_URL; ?>">
				<span><?php _e( 'タイトル', 'ivn-material' ); ?></span><span class="sorting-indicator"></span></a>
		</th>
		<th scope='col' class='manage-column column-publish-date-start sortable desc'>
			<a href="<?php echo IVN_MATERIAL_URL; ?>">
				<span><?php _e( '日付', 'ivn-material' ); ?></span><span class="sorting-indicator"></span></a>
		</th>
		<th scope='col' class='manage-column column-display-page'>
				<span><?php _e( 'どのページにリストする', 'ivn-material' ); ?></span>
		</th>
		<th scope='col' class='manage-column column-creator sortable desc'>
			<a href="<?php echo IVN_MATERIAL_URL; ?>">
				<span><?php _e( '対象者', 'ivn-material' ); ?></span><span class="sorting-indicator"></span></a>
		</th>
		<th scope='col' class='manage-column column-filename'><img width="20" height="20" src="<?php echo IVN_MATERIAL_IMAGES_URL; ?>img_attachment_40x40.png"/></th>
	</tr>
	</thead>

	<tfoot>
	<tr>
		<th scope='col' class='manage-column column-cb check-column'>
			<input id="cb-select-all-2" type="checkbox" />
		</th>
		<th scope='col' class='manage-column column-title sortable desc'>
			<a href="<?php echo IVN_MATERIAL_URL; ?>">
				<span><?php _e( 'タイトル', 'ivn-material' ); ?></span><span class="sorting-indicator"></span></a>
		</th>
		<th scope='col' class='manage-column column-publish-date-start sortable desc'>
			<a href="<?php echo IVN_MATERIAL_URL; ?>">
				<span><?php _e( '日付', 'ivn-material' ); ?></span><span class="sorting-indicator"></span></a>
		</th>
		<th scope='col' class='manage-column column-display-page'>
				<span><?php _e( 'どのページにリストする', 'ivn-material' ); ?></span>
		</th>
		<th scope='col' class='manage-column column-creator sortable desc'>
			<a href="<?php echo IVN_MATERIAL_URL; ?>">
				<span><?php _e( '対象者', 'ivn-material' ); ?></span><span class="sorting-indicator"></span></a>
		</th>
		<th scope='col' class='manage-column column-filename'><img width="20" height="20" src="<?php echo IVN_MATERIAL_IMAGES_URL; ?>img_attachment_40x40.png"/></th>
	</tr>
	</tfoot>

	<tbody id="the-list">
<?php
// RENDER-MATERIAL-LIST-[BEGIN]
if ($material_list):
	$oddRow = false;
	foreach ($material_list as $theMaterial):
		$urlWorkAction= IVN_MATERIAL_URL . "&amp;wID=" . $theMaterial->ID . "&amp;w=";
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
					<span class='edit'><a href="<?php echo $urlWorkAction ."upd"; ?>"><?php _e( '編集', 'ivn-material' ); ?></a> | </span>
					<span class='delete'><a class='submitdelete' href="<?php echo $urlWorkAction ."del"; ?>"><?php _e( '削除', 'ivn-material' ); ?></a></span>
				</div>
			</td>
			<td class="name column-publish-date-start"><?php echo formatDateYmd($theMaterial->publish_date_start); ?></td>
			<td class="name column-display-page"><?php echo getMaterialsDisplayPageName($theMaterial->display_page); ?></td>
			<td class="creator column-creator"><?php echo htmlspecialchars($theMaterial->creator); ?></td>
			<td class="filename column-filename"><a target="_blank" href="<?php echo IVN_MATERIAL_DOCUMENTS_URI . $theMaterial->filename; ?>"><img width="32" height="32" src="<?php echo IVN_MATERIAL_IMAGES_URL; ?>img_download_32x32.png"/></a></td>
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
</div><!--/wrap-お役立ち資料ダウンロード　一覧-->
<?php
class AllKindsMaterials
{
	public $ID = "-1";
	public $title = "";
	public $filename = "";
	public $filename_old = "";
	public $description = "";
	public $publish_updated_date = "";
	public $publish_start_date = "";
	public $display_order = "9999";
	public $file_description = null;
	public $search_data = null;
	public $html_generate_result = null;

	public function __construct() {
		// do nothing
	}

	/**
	 * save uploaded file to  /YYYYMM/000007777712
	 */
	public function populatePOST() {
		foreach ($_POST as $var => $value) {
			if (is_string($value)) {
				$this->$var = trim($value);
				continue;
			}
			// convert array to string
			if (is_array($value)) {
				$this->$var = implode(',', $value);
			}
		}
		
		// retrieve uploaded .filename
		if (isset($_FILES['filename']) && ($_FILES['filename']['name'] != '')) {
			$tmpFile = $_FILES['filename'];
			$tmpDirName = '';
			if ($this->filename_old == '') {
				// create folder /YYYYMM/
				$tmpDirName = date('Ym');
				$tmpDirPath = IVN_ALLKINDSMATERIAL_DOCUMENTS_PATH . "$tmpDirName/";
				if ( ! is_dir($tmpDirPath)) {
					mkdir($tmpDirPath, 0777, TRUE);
				}
				// create folder /YYYYMM/000001111122/
				$tmpDirName .= "/" . str_pad(strval(time()), 12, '0', STR_PAD_LEFT);
				$tmpDirPath= IVN_ALLKINDSMATERIAL_DOCUMENTS_PATH . "$tmpDirName/";
				if ( ! is_dir($tmpDirPath)) {
					mkdir($tmpDirPath, 0777, TRUE);
				}
			} else {
				// get created folder from ->filename= 'YYYYMM/000001111122/filename.txt'
				$tmpDirName = substr($this->filename_old, 0, 19);
			}
			
			// re-check
			$tmpDirPath= IVN_ALLKINDSMATERIAL_DOCUMENTS_PATH . "$tmpDirName/";
			if ( ! is_dir($tmpDirPath) ) {
					mkdir($tmpDirPath, 0777, TRUE);
			}
			
			// convert filename to UTF-8
			$newFileName = mb_convert_encoding($tmpFile['name'], "UTF-8", "auto");
			$newFilePath = $tmpDirPath . $newFileName;
			if ( ! copy($tmpFile['tmp_name'], $newFilePath)) {
				trigger_error('cannot save file ... ' .$newFilePath,
					headers_sent() || WP_DEBUG ? E_USER_WARNING : E_USER_NOTICE);
				return false;
			}
			$arr_file_description = array();
			$arr_file_description['ext'] = pathinfo($newFilePath, PATHINFO_EXTENSION);
			$arr_file_description['size'] = convertReadableFileSize($_FILES['filename']['size']);
			$this->file_description = json_encode($arr_file_description);
			// set filename with properly path
			$this->filename = "$tmpDirName/$newFileName";
			$this->filename_old = '';
		}
		// or set old filename
		if ($this->filename_old != '') {
			$this->filename = $this->filename_old;
		}
	}

	/**
	 */
	public function retrieveID($id) {
		$sSQL = <<<EOT
SELECT im.ID, im.title, im.filename,
	im.publish_updated_date, im.publish_start_date, 
	im.description, im.display_order
FROM ivn_all_kinds_materials im
WHERE im.deleted_flag = 0
	AND im.ID=$id
EOT;
		global $wpdb;
		$arrTemp = $wpdb->get_row($sSQL, ARRAY_A);
		if (isset($arrTemp)) {
			foreach ($arrTemp as $var => $value) {
				$this->$var = htmlspecialchars($value);
			}
			$this->filename_old = $this->filename;
		}
	}

	/**
	 */
	public function search($strCond = '') {
		$sSQL = <<<EOT
SELECT ID, title, filename,
	publish_updated_date, publish_start_date,
	display_order, description, file_description
FROM ivn_all_kinds_materials im
WHERE im.deleted_flag = 0
	$strCond
ORDER BY im.display_order ASC, im.publish_updated_date DESC;
EOT;
		global $wpdb;
		$this->search_data = $wpdb->get_results($sSQL);
	}

	/**
	 */
	public function validate() {
		return true;
	}

	/**
	 */
	public function insert() {
		$strV = "$this->ID, ";
		$strV .= "'$this->title', ";
		$strV .= "'$this->filename', ";
		$strV .= "'$this->description', ";
		$strV .= "'$this->publish_updated_date', ";
		if ($this->publish_start_date != '') {
			$strV .= "'$this->publish_start_date', ";
		} else {
			$strV .= "NULL, ";
		}
		$strV .= "'$this->display_order', ";
		$strV .= "'$this->file_description', ";
		$strV .= 'NOW()';
		$sSQL = <<<EOT
INSERT INTO ivn_all_kinds_materials (ID, title, filename, description,
	publish_updated_date, publish_start_date, display_order, file_description,
	updated_date)
VALUES($strV);
EOT;
		global $wpdb;
		return $wpdb->query($sSQL);
	}

	/**
	 */
	public function update() {
		$strID = $this->ID;
		$strV = "title='$this->title', \n";
		$strV .= "filename='$this->filename', \n";
		$strV .= "description='$this->description', \n";
		$strV .= "publish_updated_date='$this->publish_updated_date', \n";
		$strV .= "publish_start_date=',$this->publish_start_date,', \n";
		$strV .= "display_order='$this->display_order', \n";
		if (isset($this->file_description)) {
			$strV .= "file_description='$this->file_description', \n";
		}
		$strV .= 'updated_date=NOW() ';
		$sSQL = <<<EOT
UPDATE ivn_all_kinds_materials
SET
	$strV
WHERE ID = $strID
EOT;
		global $wpdb;
		return $wpdb->query($sSQL);
	}

	/**
	 */
	public function delete() {
		$strID = $this->ID;
		$sSQL = <<<EOT
UPDATE ivn_all_kinds_materials
SET deleted_flag = 1
WHERE ID = $strID
EOT;
		global $wpdb;
		return $wpdb->query($sSQL);
	}

	/**
	 */
	public function countCategory() {
		$sSQL = <<<EOT
SELECT 'all' as 'name', COUNT(ID) as 'value'
FROM ivn_all_kinds_materials
WHERE deleted_flag = 0
ORDER BY name
EOT;
		global $wpdb;
		return $wpdb->get_results($sSQL);
	}

}

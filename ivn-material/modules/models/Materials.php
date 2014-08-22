<?php
class Materials
{
	public $ID = "-1";
	public $title = "";
	public $filename = "";
	public $filename_old = "";
	public $description = "";
	public $publish_date_start;
	/**
	 * search pattern ',nnnn,'
	 * sample: display_page = ',1227,1230,1232,'
	 */
	public $display_page = "";
	public $creator = "";
	public $category = '';
	public $display_order = "9999";
	public $search_data = null;

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
				$tmpDirPath = IVN_MATERIAL_DOCUMENTS_PATH . "$tmpDirName/";
				if ( ! is_dir($tmpDirPath)) {
					mkdir($tmpDirPath, 0777, TRUE);
				}
				// create folder /YYYYMM/000001111122/
				$tmpDirName .= "/" . str_pad(strval(time()), 12, '0', STR_PAD_LEFT);
				$tmpDirPath= IVN_MATERIAL_DOCUMENTS_PATH . "$tmpDirName/";
				if ( ! is_dir($tmpDirPath)) {
					mkdir($tmpDirPath, 0777, TRUE);
				}
			} else {
				// get created folder from ->filename= 'YYYYMM/000001111122/filename.txt'
				$tmpDirName = substr($this->filename_old, 0, 19);
			}
			
			// re-check
			$tmpDirPath= IVN_MATERIAL_DOCUMENTS_PATH . "$tmpDirName/";
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
SELECT im.ID, im.title, im.filename, im.publish_date_start, im.display_page, 
	im.creator, im.category, im.description
FROM ivn_materials im
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
		$this->display_page = trim($this->display_page, ',');
	}

	/**
	 */
	public function search($strCond = '') {
		$sSQL = <<<EOT
SELECT ID,
	title,
	filename,
	publish_date_start,
	display_page,
	creator
FROM ivn_materials im
WHERE im.deleted_flag = 0
	$strCond
ORDER BY im.display_order ASC, im.updated_date DESC;
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
		$strV .= "'$this->publish_date_start', ";
		$strV .= "',$this->display_page,', ";
		$strV .= "'$this->creator', ";
		$strV .= "'$this->category', ";
		$strV .= "'$this->description', ";
		$strV .= 'NOW()';
		$sSQL = <<<EOT
INSERT INTO ivn_materials (ID, title, filename, publish_date_start, display_page,
	creator, category, description, updated_date)
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
		$strV .= "publish_date_start='$this->publish_date_start', \n";
		$strV .= "display_page=',$this->display_page,', \n";
		$strV .= "creator='$this->creator', \n";
		$strV .= "category='$this->category', \n";
		$strV .= "description='$this->description', \n";
		$strV .= 'updated_date=NOW() ';
		$sSQL = <<<EOT
UPDATE ivn_materials
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
UPDATE ivn_materials
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
SELECT category as 'name', COUNT(ID) as 'value'
FROM ivn_materials
WHERE deleted_flag = 0
GROUP BY category
ORDER BY name
EOT;
		global $wpdb;
		return $wpdb->get_results($sSQL);
	}

}

<?php
require_once IVN_ALLKINDSMATERIAL_PLUGIN_PATH . "modules/models/AllKindsMaterials.php";
global $IVN_Model;

/**
 * AllKindsMaterialsController Controller
 * processed actions as folows
 * 	workAction= CREate/ UPDate/ DELete/ LISt/ INDex/ VIEw/ SAVe(insert+update+delete)/ GENerate
 */
class AllKindsMaterialsController
{

	public function __construct() {
		//
	}
	/**
	 */
	public function actions() {
		$workActions = '';
		if (isset( $_GET['w'])) {
			$workActions = $_GET['w'];
		}
		switch ( $workActions ) {
			case 'cre': // CREate
				$this->actionCreate();
				break;
			case 'upd': // UPDate
				$this->actionUpdate();
				break;
			case 'del': // DELete
				$this->actionDelete();
				break;
			case 'sav': // SAVe
				$this->actionSave();
				break;
			case 'gen': // GENerate
				$this->actionGenerate();
				break;
			default: // LISt/ INDex/ VIEw
				$this->actionIndex();
				break;
		}
		return true;
	}

	/**
	 */
	public function actionIndex() {
		$model = new AllKindsMaterials();
		$strCond = "";
		// search & render view-index
		$model->search($strCond);
		$this->render('index', $model);
		return true;
	}


	/**
	 */
	public function actionCreate() {
		$model = new AllKindsMaterials();
		// render view-create
		$this->render('create', $model);
		return true;
	}

	/**
	 */
	public function actionUpdate() {
		$model = new AllKindsMaterials();
		if (isset($_GET['wID'])) {
			$model->retrieveID($_GET['wID']);
		}
		// render view-create
		$this->render('create', $model);
		return true;
	}

	/**
	 */
	public function actionSave() {
		$model = new AllKindsMaterials();
		if (isset($_POST['method'])) {
			// retrieve data from $_POST
			$model->populatePOST();
			// case of validated==true, update DB
			if ($model->validate()) {
				switch ($_POST['method']) {
					case 'insert':
						$model->insert();
						break;
					case 'update':
						$model->update();
						break;
					case 'delete':
						$model->delete();
						break;
				}
				// search & render view-index
				$model->search();
				$this->render('index', $model);
				return true;
			}
		}
		
		// case of ERROR, render view-create
		$this->render('create', $model);
		return true;
	}

	/**
	 */
	public function actionDelete() {
		$model = new AllKindsMaterials();
		if (isset($_GET['wID'])) {
			$model->retrieveID($_GET['wID']);
		}
		// delete
		$this->render('delete', $model);
		return true;
	}
	/**
	 */
	public function actionGenerate() {
		$model = new AllKindsMaterials();
		// search all
		$model->search();
		// generate HTML file
		ob_start(); // turn on output buffering
		$this->render('generate', $model);
		$tmpHtml = ob_get_contents(); // get the contents of the output buffer
		ob_end_clean(); // clean (erase) the output buffer and turn off output buffering
		file_put_contents(IVN_ALLKINDSMATERIAL_HTML_FILE_PATH, $tmpHtml); // write final string to file
		// render index
		$this->render('index', $model);
		return true;
	}
	/**
	 */
	public function render($viewName = 'index', $model=null) {
		if ( ! isset($viewName)) {
			$viewName = 'index';
		}
		$filename = $viewName .'.php';
		if (isset($model)) {
			global $IVN_Model;
			$IVN_Model = $model;
		}
		require_once IVN_ALLKINDSMATERIAL_PLUGIN_PATH . 'modules/views/' . $filename;
	}

}

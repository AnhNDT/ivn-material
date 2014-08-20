<?php
require_once IVN_MATERIAL_PLUGIN_PATH . "modules/models/Materials.php";
global $IVN_Model;

/**
 * Materials Controller
 * processed actions as folows
 * 	workAction= CREate/ UPDate/ DELete/ LISt/ INDex/ VIEw/ SAVe(insert+update+delete)
 */
class MaterialsController {

	public function __construct() {
		//
	}
	/**
	 */
	public function actions() {
		$workActions = '';
		if ( isset( $_GET['w'] ) ) {
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
			default: // LISt/ INDex/ VIEw
				$this->actionIndex();
				break;
		}
		return true;
	}

	/**
	 */
	public function actionIndex() {
		$model = new Materials();
		$strCond = "";
		if ( isset( $_GET['category'] ) ) {
			$strCond = "AND im.category ='" . $_GET['category'] . "'";
		}
		// search & render view-index
		$model->search( $strCond );
		$this->render( 'index', $model );
		return true;
	}


	/**
	 */
	public function actionCreate() {
		$model = new Materials();
		// render view-create
		$this->render( 'create', $model );
		return true;
	}

	/**
	 */
	public function actionUpdate() {
		$model = new Materials();
		if ( isset( $_GET['wID'] ) ) {
			$model->retrieveID( $_GET['wID'] );
		}
		// render view-create
		$this->render( 'create', $model );
		return true;
	}

	/**
	 */
	public function actionSave() {
		$model = new Materials();
		if ( isset( $_POST['method'] ) ) {
			// retrieve data from $_POST
			$model->populatePOST();
			// case of validated==true, update DB
			if ( $model->validate() ) {
				switch ( $_POST['method'] ) {
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
				$this->render( 'index', $model );
				return true;
			}
		}
		
		// case of ERROR, render view-create
		$this->render( 'create', $model );
		return true;
	}

	/**
	 */
	public function actionDelete() {
		$model = new Materials();
		if ( isset( $_GET['wID'] ) ) {
			$model->retrieveID( $_GET['wID'] );
		}
		// delete
		$this->render( 'delete', $model );
		return true;
	}

	/**
	 */
	public function render( $viewName = 'index', $model=null ) {
		if ( ! isset( $viewName ) ) {
			$viewName = 'index';
		}
		$filename = $viewName .'.php';
		if ( isset( $model ) ) {
			global $IVN_Model;
			$IVN_Model = $model;
		}
		require_once IVN_MATERIAL_PLUGIN_PATH . 'modules/views/' . $filename;
	}

}

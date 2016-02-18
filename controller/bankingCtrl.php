<?php 
require_once('common/constants.php');
require_once('view/bankingView.php');
require_once('model/bankingModel.php');

/**
 * Class BankingController. 
 * It handles all the request from user side and delegatwés it to the model for manipulation.
 *
 */ 
 class BankingController{
	 private $name;
	 private $age;
	 private $id;
	 private $page_mode;
	 
	/**
	 * Sets the data to be used within the application.
	 *
	 * @param : none
	 */
	 private function dataConstruct(){
		 $this->page_mode = (!isset($_REQUEST['page_mode']) ) ? PAGE_MODE_DEFAULT : $_REQUEST['page_mode'];
		 $this->id = (!isset($_REQUEST['operation_id']) ) ? PAGE_MODE_DEFAULT : $_REQUEST['operation_id'];
		 $this->name = (!isset($_REQUEST['name']) ) ? '' : $_REQUEST['name'];
		 $this->age = (!isset($_REQUEST['age']) ) ? '' : $_REQUEST['age'];
		 $this->editId = (!isset($_REQUEST['edit_id']) ) ? '' : $_REQUEST['edit_id'];
	 }
	 
	 /**
	 * Main function which handles all the event invoked by the users.
	 *
	 * @param: none
	 */
	 public function main(){
		 $view = new BankingView();
		 $model = new BankingModel();
		 $this->dataConstruct();
		 $viewObj = new stdClass();
		 $model->getConnection();
		 // event handling
		 switch($this->page_mode){
			 // default mode is view mode in this application
			 case PAGE_MODE_DEFAULT: 
				$viewObj->page_mode = PAGE_MODE_DEFAULT;
				$viewObj->result = $model->displayRecord();
				$view->renderDefaultView($viewObj);
				break;
			 // deleting the record 
			 case PAGE_MODE_DELETE:
				$model->deleteRecord($this->id);
				$viewObj->page_mode = PAGE_MODE_DEFAULT;
				$viewObj->prev_page_mode = $this->page_mode;
				$viewObj->result = $model->displayRecord();
				$view->renderDefaultView($viewObj);
			    break;
			// adding the record view	
			 case PAGE_MODE_ADD :
				$viewObj->page_mode = PAGE_MODE_ADD;
				$view->renderAddEditView($viewObj);
				break;
			//	inserting the record into db
			 case PAGE_MODE_INSERT :
				$createObj = new stdClass();
				$createObj->name = $this->name;
				$createObj->age = $this->age;
				$model->createRecord($createObj);
				$viewObj->page_mode = PAGE_MODE_DEFAULT;
				$viewObj->prev_page_mode = $this->page_mode;
				$viewObj->result = $model->displayRecord();
				$view->renderDefaultView($viewObj);
				break;
			// edit view of a particular record	
			case PAGE_MODE_EDIT_VIEW :
				$viewObj->page_mode = PAGE_MODE_EDIT_VIEW;
				$viewObj->id = $this->id;
				$viewObj->result = $model->getRecord($this->id);
				$view->renderAddEditView($viewObj);
				break;
			// updating a particular record	
			case PAGE_MODE_UPDATE :
				$updateObj  = new stdClass();
				$updateObj->name = $this->name;
				$updateObj->age = $this->age;
				$updateObj->id = $this->editId;
				$viewObj->result = $model->updateRecord($updateObj);
				$viewObj->page_mode = PAGE_MODE_DEFAULT;
				$viewObj->prev_page_mode = $this->page_mode;
				$viewObj->result = $model->displayRecord();
				$view->renderDefaultView($viewObj);
				break;	
		 }
	 }
	 
 }
 // initializing the controller
 $controller = new BankingController();
 $controller->main();
?>
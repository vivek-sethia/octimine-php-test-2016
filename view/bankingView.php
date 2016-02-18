<?php
/**
 * Class BankingView. 
 * It provides the view based on the data presented to it. It also interacts with controller 
 *
 */ 
class BankingView {
	// private variables
	private $html;
	private $prev_page_mode;
	
	 /**
	 * Constructor function
	 *
	 * @param: none
	 */
	public function BankingView(){
			$this->html = '';
	}
	
	 /**
	 * Render common top part of the view
	 * @param: none
	 */
	private function renderTop(){
		$this->html .= "<html>";
		$this->html .= "<head>";
		$this->html .= "<link rel='stylesheet' type='text/css' href='libs/bootstrap.min.css' />";
		$this->html .= "<style>
							table{
								border : 1px solid #ccc;
							}
							.btn{
								margin-left:10px;
							}
						</style>";
		$this->html .= "</head>";
		$this->html .= "<body>";
		$this->html .= "<div class='container-fluid'>";
		
		//alert boxes for succesful operations
		if( isset($this->prev_page_mode) &&  $this->prev_page_mode == PAGE_MODE_INSERT) $alert_text = "Record added successfully.";
		else if( isset($this->prev_page_mode) &&  $this->prev_page_mode== PAGE_MODE_UPDATE) $alert_text = "Record updated successfully.";
		else if( isset($this->prev_page_mode) &&  $this->prev_page_mode== PAGE_MODE_DELETE) $alert_text = "Record deleted successfully.";
		
		if( isset($this->prev_page_mode)	)	
		$this->html .= "<div class='alert alert-success'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							".$alert_text."
						</div>";
	}
	
	/**
	 * Render function which renders the common bottom part.
	 * @param: none
	 */
	private function renderBottom(){
		$this->html .= "</div>";
		$this->html .= "</body>";
		$this->html .= "<script src='libs/jquery.min.js'></script>";
		$this->html .= "<script src='libs/jquery.DataTables.min.js'></script>";
		$this->html .= "<script src='libs/bootstrap.min.js'></script>";
		$this->html .= "<script src='libs/dataTables.bootstrap.min.js'></script>";
		$this->html .= "<script src='app.js'></script>";
		$this->html .= "</html>";
	}
	
	/**
	 * Render function which renders the default view.
	 * @param:  Object - $viewObj - All the data needed for constructing the view.
	 */
	public function renderDefaultView($viewObj){
			if (isset($viewObj->prev_page_mode)) {
				$this->prev_page_mode = $viewObj->prev_page_mode;
			}
			$this->renderTop();
			
			$this->html .= "<h1>Customer Records</h1>";
			$this->html .= "<a href='?page_mode=".PAGE_MODE_ADD."' class='pull-right'>Add More</a>";
			$this->html .= "<form id='customer' method='post' >";
			$this->html .= "<input id='operation_id' name='operation_id' type='hidden'/>";
			$this->html .= "<input id='page_mode' name='page_mode' type='hidden'/>";
			$this->html .= "<table id='customerRecords' class='table table-striped'>";
			$this->html .= "<thead>";
			$this->html .= "<tr>";
			$this->html .= "<th class='col-md-6'>Name</th>";
			$this->html .= "<th class='col-md-4'>Age</th>";
			$this->html .= "<th class='col-md-2'>Actions</th>";
			$this->html .= "</tr>";
			$this->html .= "</thead>";
			$this->html .= "<tbody>";
			if(  $viewObj->result->count >0 ){
				for($i=0;$i<$viewObj->result->count;$i++){
					$this->html .= "<tr>";
					$this->html .= "<td>".$viewObj->result->name[$i]."</td>";
					$this->html .= "<td>".$viewObj->result->age[$i]."</td>";
					$this->html .= "<td id='".$viewObj->result->id[$i]."' class='btn-toolbar'><button class='edit btn btn-primary'>Edit</button><button class='delete btn btn-danger' >Delete</button></td>";
					$this->html .= "</tr>";
				}
			}
			$this->html .= "</tbody>";
			$this->html .= "</table>";
			$this->html .= "</form>";
			
			$this->renderBottom();
			echo $this->html;
	}
	/**
	 * Render function which renders the add/edit view.
	 * @param:  Object - $viewObj - All the data needed for constructing the view.
	 */
	public function renderAddEditView($viewObj){
		if (isset($viewObj->prev_page_mode)) {
				$this->prev_page_mode = $viewObj->prev_page_mode;
		}
		$this->renderTop();
		
		// initializing constants needed for switching between add and edit views
		$header_text = ($viewObj->page_mode == PAGE_MODE_EDIT_VIEW) ? "Updating Record": "Adding Record";
		$edit_id = ($viewObj->page_mode == PAGE_MODE_EDIT_VIEW) ? $viewObj->id: "";
		$name = ($viewObj->page_mode == PAGE_MODE_EDIT_VIEW) ? $viewObj->result->name: "";
		$age = ($viewObj->page_mode == PAGE_MODE_EDIT_VIEW) ? $viewObj->result->age: "";
		$btn_id = ($viewObj->page_mode == PAGE_MODE_EDIT_VIEW) ? "update": "save";
		$btn_text = ($viewObj->page_mode == PAGE_MODE_EDIT_VIEW) ? "Update": "Save";
		
		$this->html .= "<h1>".$header_text."</h1>";
		$this->html .= "<form id='customer' method='post' >";
		$this->html .= "<input id='page_mode' name='page_mode' type='hidden'/>";
		$this->html .= "<input id='edit_id' name='edit_id' type='hidden' value='".$edit_id."'/>";
		
		$this->html .= "<table class='table'>";
		
		$this->html .= "<tr class='row'>";
		$this->html .= "<td class='col-md-2'>Name</td>";
		$this->html .= "<td><input name='name' value='".$name."'/></td>";

		$this->html .= "</tr>";
		$this->html .= "<tr class='row'>";
		$this->html .= "<td>Age</td>";
		$this->html .= "<td><input name='age' value='".$age."'/></td>";
		$this->html .= "</tr>";
		
		$this->html .= "<tr class='row'>";
		$this->html .= "<td></td>";
		$this->html .= "<td>";
		$this->html .="<button id='".$btn_id."' class='btn btn-primary'>".$btn_text."</button>";
		$this->html .="<button id='back' class='btn btn-primary'>Back</button>";
		$this->html .= "</td>";
		$this->html .= "</tr>";
		
		$this->html .= "</table>";
		$this->html .= "</form>";
		
		$this->renderBottom();
		
		echo $this->html;
	}
}

?>

<?php
/**
 * Class BankingModel. 
 * It handles all the database manipulation based on the user interaction and provide service to the views.
 *
 */ 
class BankingModel {
	private $conn;
	/**
	 * Gets the database connection required for the application.
	 *
	 * @param : none
	 */
	public function getConnection(){
		$servername = DATABASE_SERVER_NAME;
		$username = DATABASE_USER_NAME;
		$password = DATABASE_USER_PASSWORD;
		$database = DATABASE_USED;

		// Create connection
		$this->conn = new mysqli($servername, $username, $password, $database);

		// Check connection
		if ($this->conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}  
		
	}
	/**
	 * Creates a record within the databased based on user inputs.
	 *
	 * @param : 1. Object - $createObj  - contains user data such as name and age
	 */
	public function createRecord($createObj){
		$query = "INSERT INTO banking_records (name, age) VALUES (?, ?)";	
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("ss", $createObj->name, $createObj->age);
		$stmt->execute();
		
	}
	/**
	 *  Deletes a record from the application based on user id.
	 *
	 * @param : 1. int - $id  - user id which is going to be deleted.
	 */
	public function deleteRecord($id){
		$query = "UPDATE banking_records SET is_deleted =1 WHERE id = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("s", $id);
		$stmt->execute();
	}
	/**
	 *  Displays all the record from the application which are not deleted.
	 *
	 * @param : none
	 */
	public function displayRecord(){
		$query = "SELECT id,name,age FROM banking_records where is_deleted=0";
		$result = mysqli_query($this->conn, $query);
		$resultObj = new stdClass();
		$count = mysqli_num_rows($result );
		$i=0;
		if( $count >0){
			while($row = mysqli_fetch_assoc($result)){
				$resultObj->id[$i] = $row['id'];
				$resultObj->name[$i] = $row['name'];
				$resultObj->age[$i] = $row['age'];
				$i++;
			}
		}
		$resultObj->count = $count;
		return $resultObj;
	}
	/**
	 * Updates a specific record within the databased based on user inputs.
	 *
	 * @param : 1. Object - $updateObj  - contains user data name,age and id.
	 */
	public function updateRecord($updateObj){
		$query = "UPDATE banking_records SET name=? , age=? where id=?";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("sss", $updateObj->name, $updateObj->age, $updateObj->id);
		$stmt->execute();
	}
	/**
	 * Fetches a specific record within the databased based on user id.
	 *
	 * @param : 1. int - $id  - user id
	 */
	public function getRecord($id){
		$query = "SELECT name,age FROM banking_records where id= ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("s", $id);
		$result = $stmt->execute();
		$resultObj = new stdClass();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$resultObj->name = $row['name'];
		$resultObj->age = $row['age'];
		return $resultObj;
	}
}

?>
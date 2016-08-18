<?php

	class DbHandler{
		
		private $conn;
		
		function __construct(){
			
			require_once dirname(__FILE__) . './db_connect.php';
			
			// opening db connection
			$db = new DbCOnnect();
			$this->conn = $db->connect();
			
		}
		
		
		//create new user if not existed		
		public function createUser ($name, $emil){
			
			$response = array();
			
			//first check if user already existed in db
			if(!$this->isUserExists($email)){
				$stmt = $this->conn->prepare("INSERT INTO users(name,email)values(?,?)");
				$stmt = bind_param("ss", $name,$email);
				
				$result = $stmt->execute();
				$stmt->close();
				
				//check for successful insetion
				if($result){
					//user successfully inserted
					$response["error"] = false;
					$response["user"] =$this->getUserByEmail($email);
				}else{
					// Failed to create user
					$response["error"] = true;
					$response["message"] ="Oops! An error occurred while registering";
				}
			}else{
				//user with same email already existed in the db
				$response["error"]=false;
				$response["response"]=$this->getUserByEmail($email);
			}
			return $response;
		}//-- End - createUser
		
		// updating user GCM registration ID
		public function updateGcmId($user_id, $gcm_registation_id){
			$response = array();
			
			
			
		}//END-GCM registration
		
		
	}

?>
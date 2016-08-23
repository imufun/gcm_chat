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
		public function updateGcmId($user_id, $gcm_registration_id){
			$response = array();
			$stmt =$this->conn->prepare("UPDATE user SET gcm_registration_id=? WHERE user_id=? ");
			$stmt->bind_param("si",$gcm_registration_id, $user_id);
			
			if($stmt->execute()){
				 // User successfully updated
				 $response['error'] = false;
				 $response['message'] = 'GCM registration ID updated successfully';
				
			}else{
				//Failed to update user
				$response['error']=true;
				$response['message']= "Failed to update GCM registration ID";
				$stmt->error;
			}
			$stmt->close();
			return $response;
		}//END-GCM registration
		
		 //Start->fetching single user by id
		 public function getUser($user_id){
			 $stmt = $this->conn->prepare("SELECT user_id, name, email, gcm_registration_id, created_at FROM users user_id=?");
			 $stmt = bind_param("s", $user_id);
			  if($stmt->execute()){
				  $stmt->bind_result($user_id, $name, $email, $gcm_registration_id, $created_at);
				  $stmt->fetch();
				  $user = array();
				  $user["user_id"] =$user_id;
				  $user["name"] = $name;
				  $user["email"]=$email;
				  $user["gcm_registration_id"]=$gcm_registration_id;
				  $user["created_at"]=$created_at;
				  $stmt->close();
				  return $user; 
				}else{
					return null;
				}
		 }//END->fetching single user by id
		
		
	}

?>
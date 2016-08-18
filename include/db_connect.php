<?php

	/*--------------------------------*
	|								  |	
	|---Handling database connection--|	
	|								  |	
	*---------------------------------*/


	class DbCOnnect{
		private $conn;
		
		
		
		function __construct(){
			connect();
		}
	
	 /**
     * Establishing database connection
     * @return database connection handler
     */
	 
	 
	 function connect(){
		include_once dirname(__FILE__) . '/config.php'; 

		// connection to mysql database
		$this->conn = new mysqli(DB_USERNAME,DB_PASSWORD,DB_HOST,DB_NAME);
		
		// Check for database connection error		
		if(mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_errno();
		}	
		// returing connection resource	
		return $this->$conn;
		
	 }
	 
	
	
	
	
	}
?>
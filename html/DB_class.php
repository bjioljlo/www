<?php
	class DB
	{
		var $_dbConn = 0;
		var $_queryResoure = 0;
		function DB()
		{
			
		}
		
		function connect_db($host,$user,$pwd,$dbname)
		{

			$dbConn=mysqli_connect($host,$user,$pwd);

			if (!$dbConn) 
			{
				echo "Error: Unable to connect to MySQL.";
				echo "Debugging errno: " . mysqli_connect_errno();
				echo "Debugging error: " . mysqli_connect_error();
				die("Mysql connect error");
			}
			//echo "Success: A proper connection to MySQL was made! The my_db database is great.";
			//echo "Host information: " . mysqli_get_host_info($dbConn);


			mysqli_query($dbConn,"SET NAMES utf8");
			if(!mysqli_select_db($dbConn,$dbname))
			{
				die("Mysql select DB error");
			}


			$this->_dbConn = $dbConn;
			return true;
		}
		
		function query($sql)
		{
			$Result = mysqli_query($this->_dbConn,$sql);
			if(!$Result)
			{
				die("mysql query error: ");
			}
			$this -> result = $Result;
			//$this->_queryResoure = $Result;
			return $Result;
		}
		/**Get array return by Mysql*/
		function m_fetch_array()
		{
			return mysqli_fetch_array($this->result,MYSQLI_ASSOC);
		}
		
		
		function get_num_rows()
		{
			return mysqli_num_rows($this->result);
		}
		function get_num_fields() 
		{
			return mysqli_num_fields($this->result);
		}
		
		/*Get the cuurent id*/
		function get_insert_id()
		{
			return mysqli_insert_id($this->_dbConn);
		}
		
		function  breakMysql()
		{
			mysqli_close($this->dbConn);
		}
		function clean_result()
		{
			mysqli_free_result($this->result);
		}
		
	}
?>
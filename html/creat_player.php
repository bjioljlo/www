<?php session_start();
?>
<?php
include_once("DB_class.php");
include_once("DB_config.php");

$mainDB = new DB();
$mainDB->connect_db($_DB['host'],$_DB['username'],$_DB['password'],$_DB['dbname']);

$_unitydata = $_POST['playerinfo'];//get data from unity
if($_unitydata == null){
	echo"1";//unitydata is wrong
	return;
}
$_playerinfo = json_decode($_unitydata);//decode data with json 

//get and set player info--------
$playerinfo_name = $_playerinfo->Name;
$playerinfo_passwd = $_playerinfo->Passwd;
if($playerinfo_name == "" or $playerinfo_passwd == ""){
	echo"2";//name or password was no cerect
	return;
}

//check this name has be used------
$Sql = "select Name from playerInfo where Name = '$playerinfo_name'";
$mainDB->query($Sql);
$rownum = $mainDB->get_num_rows();
if($rownum > 0 or $playerinfo_name == null) {
	echo "3";//Has this name
	return;
}

//Add player
$Sql = "insert into playerInfo (Name,Passwd) values ('$playerinfo_name','$playerinfo_passwd')";
$mainDB->query($Sql);
$playerinfo_id = $mainDB->get_insert_id();

//reload playerinfo to check
$Sql = "select * from playerInfo where ID = '$playerinfo_id'";
$mainDB->query($Sql);
$playerinfo_array = $mainDB->m_fetch_array();
if($playerinfo_array["Name"] != $playerinfo_name or $playerinfo_array["Passwd"] != $playerinfo_passwd){
	echo "4";//db data is not right
	return;
}

//set session data
$_SESSION["player_name"] = $playerinfo_name;
$_SESSION["player_id"] = $playerinfo_id;
$_SESSION["player_passwd"] = $playerinfo_passwd;
$_SESSION["player_highscore"] = $playerinfo_array["Passwd"];

//send data to unity
echo json_encode($playerinfo_array);

//close and clean mysqldata
$mainDB->breakMysql();
$mainDB->clean_result();

?>
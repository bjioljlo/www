<?php session_start();?>
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
$playerinfo_highscore = $_playerinfo->Highscore;
if($playerinfo_name == "" or $playerinfo_highscore == ""){
	echo"2";//name or password or highscore was no cerect
	return;
}

//check this name has in database------
$Sql = "select * from playerInfo where Name = '$playerinfo_name'";
$mainDB->query($Sql);
$rownum = $mainDB->get_num_rows();
if($rownum <= 0 ) {
	echo "5";//database not has this account
	return;
}

//update highscore
$Sql = "update playerInfo set Highscore = '$playerinfo_highscore' where Name = '$playerinfo_name'";
$mainDB->query($Sql);

//reload playerinfo to check
$Sql = "select * from playerInfo where Name = '$playerinfo_name'";
$mainDB->query($Sql);
$playerinfo_array = $mainDB->m_fetch_array();
if($playerinfo_array["Name"] != $playerinfo_name or $playerinfo_array["Highscore"] != $playerinfo_highscore){
	echo "4";//db data is not right
	return;
}

//set session data
$_SESSION["player_highscore"] = $playerinfo_highscore;

//send data to unity
echo json_encode($playerinfo_array);

//close and clean mysqldata
$mainDB->breakMysql();
$mainDB->clean_result();

//test git function
?>
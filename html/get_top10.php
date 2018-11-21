<?php
include_once("DB_class.php");
include_once("DB_config.php");

$mainDB = new DB();
$mainDB->connect_db($_DB['host'],$_DB['username'],$_DB['password'],$_DB['dbname']);

$Sql = "select * from topRank where Rank <=10 and Rank >=1";
$mainDB -> query($Sql);


while($mainDB->get_num_rows()<1)
{
	//echo "TopRank is not ready.Please press F5!";//top10 is not OK
	//return;
	$sql = "select * from topRankBack where Rank <=10 and Rank >=1";
	$mainDB -> query($Sql);
	if($mainDB->get_num_rows()<1)
	{
		$Sql = "select * from topRank where Rank <=10 and Rank >=1";
		$mainDB -> query($Sql);
	}
}

$top10_array[] = array();
$times = 0;

while($row = $mainDB->m_fetch_array()) {
	$top10_array[$times] = $row;
	$times ++;
}

echo json_encode($top10_array);
?>

<p>
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

$total_fields = $mainDB->get_num_fields();
$total_rows = $mainDB->get_num_rows();

?>

</p>
<table align="center" border="1">
<h1 align ="center"> Game TOP 10 Player </h1>
<tr>
<td align="center"> Rank </td>
<!--<td align="center"> id </td>-->
<td align="center"> name </td>
<td align="center"> HighScore </td>
</tr>

<?php
for($i=0;$i<$total_rows;$i++)
{
	$row1 = $mainDB->m_fetch_array(); 
?>
	
<tr>
<td align="center"> <?php echo $row1[Rank]; ?> </td>
<!--<td align="center"> <?php echo $row1[ID]; ?> </td>-->
<td align="center"> <?php echo $row1[Name]; ?> </td>
<td align="center"> <?php echo $row1[Highscore]; ?> </td>
</tr>
<?php } ?>
</table>
	

<?php
require("configOut.php");
$TotalUPD= 0;
$TotalINS= 0;
$idPOS = 2; //Kaupluse ID
$link1 = mysqli_connect($out_hostname, $out_username, $out_password)
    or die('Cant connect OUT: ' . mysql_error());
//$qu = mysqli_query($link1,"SET CHARACTER SET utf8");
$link = mysqli_connect($in_hostname, $in_username, $in_password) or die('Cant connect IN: ' . mysql_error());
mysqli_select_db($link1, $out_db) or die('Cant select remote OUT DB');

$result = mysqli_query($link1, "SELECT EAN,name,cena,tara FROM tovar WHERE IDPOS =".$idPOS) ;
 $rowstotal = mysqli_num_rows($result); // get number of rows returned 
 if ($rowstotal) {  
   while ($row=mysqli_fetch_row($result))
    {
    $ean = $row[0];
    $nameTovar= $row[1];
    $cena= $row[2];
    $tara= $row[3];
   //echo  $EAN ." ".$nameTovar." ".$cena." ".$tara."<br>";
	$changesNR = chkNins($ean,$cena,$tara,$nameTovar);
	$pizza  = $changesNR;
$pieces = explode("|", $pizza);
@$TotalUPD= $TotalUPD + $pieces[0];
@$TotalINS= $TotalINS + $pieces[1];
	}  
			} 
echo "Inserted: ".$TotalINS;
echo "<br>Updated: ".$TotalUPD;
@mysqli_free_result($result);
@mysqli_close($link1);
@mysqli_close($link);

function chkNins($ean,$cena,$tara,$nameTovar)
{
$inserted = 0;
$updated = 0;
$link = $GLOBALS['link'] ;
$in_db = $GLOBALS['in_db'] ;
mysqli_select_db($link, $in_db) or die('Cant select local IN DB');
	$tovarINchk = mysqli_query($link, "SELECT id,EAN,hind FROM tovar WHERE EAN ='".$ean."' LIMIT 1");	
	@$ifTovarON = mysqli_num_rows($tovarINchk); 
		if ($ifTovarON) {  //nashel tovar
			$tovarON = mysqli_fetch_row($tovarINchk);
			$hind = $tovarON [2];			
				if($hind <>$cena) //cena neta obnovim!
				{
//echo "EAN=".$ean." - ".$hind." - ".$cena." cena neta! ";
				$cenaUpdt = mysqli_query($link, "UPDATE tovar SET hind='$cena', name='$nameTovar', tara='$tara' WHERE EAN='$ean'");
				 $ifcenaUpdt = 1;
									}				
			}
			else { //nenashel tovar i vstavil
//echo $ean." tovara net!!<br>";
			$TovarINS = mysqli_query($link, "INSERT INTO tovar (EAN, name, hind, tara) VALUES ('$ean', '$nameTovar', '$cena', '$tara')")  or die('Cant INSERT local IN DB');
			$ifTovarINS = 1;
				}
					
@mysqli_free_result($tovarINchk);
$totalstring = $ifcenaUpdt."|".$ifTovarINS;
return $totalstring;
}
?>
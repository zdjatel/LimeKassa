<?php

//CREDENTIALS FOR DB
define('DBSERVER', 'd13476.mysql.zonevs.eu');
define('DBUSER', 'd13476_kassa');
define('DBPASS', 'rD5cW5L8FKEe');
define('DBNAME', 'd13476_kassa');
$mustamae1161 = "http://85.253.223.242:4445/posxml.jsp";
$mustamae1162 = "http://85.253.223.242:4446/posxml.jsp";
$url = $mustamae1162;

// $username = $f3->get('SESSION.user');

$connect = mysqli_connect("d13476.mysql.zonevs.eu", "d13476_kassa", "rD5cW5L8FKEe", "d13476_kassa");

//sub_total

$doknr = $_POST["doknr"];
$doc_cat = "";
$kuupaev = $_POST["date"];
$summa = $_POST["sub_total"];
$pos = "Tatari 64";
$pank = $_POST["payhow"];
$autor = $_POST["autor"];

///pangamaks
if ($pank == 2) {
    $pankrespone = sendXmlOverPost($url, $summa);
    $responsetxt = getTextBetweenTags($pankrespone, "ReturnCode");
echo "Pank ReturnCode: ".$responsetxt;
}
$sql2 = "INSERT INTO raha_zurnal (doknr, doc_cat, kuupaev, summa, pos, pank, autor)
VALUES ('" . $doknr . "',  '" . $doc_cat . "', '" . $kuupaev . "', '" . $summa . "', '" . $pos . "', '" . $pank . "', '" . $autor . "')";

$result = mysqli_query($connect, $sql2);

if ($result) {
    //$echoline = "Оплачено!";
} else {
    $echoline = " Error with table RAHA_ZURNAL " . mysqli_error($connect);
}

$number = count($_POST["product"]);
if ($number > 0) {
    for ($i = 0; $i < $number; $i++) {
        if (trim($_POST["product"][$i] != '')) {
            $sql = "INSERT INTO tehing VALUES(0,'" . mysqli_real_escape_string($connect, $_POST["product"][$i]) . "', 
                '" . mysqli_real_escape_string($connect, $_POST["name"][$i]) . "', 
                '" . mysqli_real_escape_string($connect, $_POST["tk"][$i]) . "', 
                '" . mysqli_real_escape_string($connect, $_POST["total"][$i]) . "', 
                '" . mysqli_real_escape_string($connect, $_POST["doknr"]) . "')";

            $result2 = mysqli_query($connect, $sql);

            if ($result2) {
                $echoline = "Оплачено!";
            } else {
                $echoline = " Error with table TEHING: " . mysqli_error($connect);
            }
        }
    }
    /// Itogo bank i cache
    $sql3 = "SELECT SUM(`summa`) FROM `raha_zurnal` WHERE `pank`=2";
   $result3 = mysqli_query($connect, $sql3); 
    while ($row1  =  mysqli_fetch_array($result3) )
{	
	$pankItogo=$row1[0];
	
	}
	
    /// --Return--///
    echo $echoline . $pankrespone.$pankItogo;
    //     mysqli_free_result($result);

    mysqli_close($connect);
} else {
    echo "Please Enter Name";
}

function getTextBetweenTags($string, $tagname) {
    $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
    preg_match($pattern, $string, $matches);
    return $matches[1];
}
function sendXmlOverPost($url, $Amount)
{
    $TransactionID = "";
    $Amount = $Amount  * 100;
    $xml = chr(60) . chr(63) . "xml version=\"1.0\" encoding=\"ISO-8859-1\"" . chr(62) . chr(60) . "!DOCTYPE PosTCP SYSTEM \"postcp.dtd\"><PosTCP version=\"4.2.5\"><TransactionRequest><Amount>$Amount</Amount><CurrencyName>EUR</CurrencyName><TransactionID>$TransactionID</TransactionID><PreAuthorisation>0</PreAuthorisation></TransactionRequest></PosTCP>";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); //timeout in seconds
    curl_setopt($ch, CURLOPT_URL, $url);

    // For xml, change the content-type.
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

    // Send to remote and return data to caller.
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

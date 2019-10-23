<?php
//set_time_limit(80);
$mustamae1161 = "http://85.253.223.242:4445/posxml.jsp";
$mustamae1162 = "http://85.253.223.242:4446/posxml.jsp";
$url=$mustamae1162;
$Amount=1;

$TransactionID = "";
$message = "";
 while (list($key, $val) = each($_POST)) { 
$message .= "$key : $val<br>"; 
							} 
echo "POSTs:".$message;
 
$result = sendXmlOverPost($url,$Amount);
echo "<br>Response: ".$result;

$resultxml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
<PosTCP version=\"4.2.5\">
	<TransactionResponse>
		<ReturnCode>10</ReturnCode>
		<Reason></Reason>
		<TransactionData>
			<Amount>100</Amount>
			<CurrencyName>EUR</CurrencyName>
			<DateTime>16.10.2019 11:34:49</DateTime>
			<Stan>011790</Stan>
			<Type>T1</Type>
			<CardAction>2</CardAction>
			<AuthorizationNo>641700</AuthorizationNo>
			<SignatureRequired>0</SignatureRequired>
			<PINVerified>1</PINVerified>
		</TransactionData>
		<CardData>
			<PhysicalType>51</PhysicalType>
			<Pan>************0836</Pan>
			<CardName>EC/MC</CardName>
			<Expires>**/**</Expires>
			<ServiceCode>221</ServiceCode>
			<AL>DEBIT MASTERCARD</AL>
			<AID>A0000000041010</AID>
		</CardData>
		<TerminalData>
			<ID>ICT45940</ID>
			<TerminalName>12452032 010</TerminalName>
			<Name>Alkotrend OU</Name>
			<Address>Mustamae tee 116 Tallinn EST</Address>
			<MerchantRegNo>12452032</MerchantRegNo>
			<PayDesk>010</PayDesk>
			<VerificationResult>0000008000</VerificationResult>
			<ApplicationCryptogram>CDE929B6782A4F3E</ApplicationCryptogram>
		</TerminalData>
	</TransactionResponse>
</PosTCP>"; 
$txt = getTextBetweenTags($result, "ReturnCode");
echo "ReturnCode: ".$txt;
function getTextBetweenTags($string, $tagname) {
    $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
    preg_match($pattern, $string, $matches);
    return $matches[1];
}



function sendXmlOverPost($url,$Amount) {
$Amount=$Amount  * 100;
$xml = chr(60).chr(63)."xml version=\"1.0\" encoding=\"ISO-8859-1\"".chr(62).chr(60)."!DOCTYPE PosTCP SYSTEM \"postcp.dtd\"><PosTCP version=\"4.2.5\"><TransactionRequest><Amount>$Amount</Amount><CurrencyName>EUR</CurrencyName><TransactionID>$TransactionID</TransactionID><PreAuthorisation>0</PreAuthorisation></TransactionRequest></PosTCP>";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,60); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 60); //timeout in seconds
	curl_setopt($ch, CURLOPT_URL, $url);

	// For xml, change the content-type.
	curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

	// Send to remote and return data to caller.
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
?>
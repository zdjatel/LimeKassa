<?php 

$connect = mysqli_connect("d13476.mysql.zonevs.eu", "d13476_kassa", "rD5cW5L8FKEe", "d13476_kassa");
 // Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


 		
 		$sqltran = mysqli_query($connect, "SELECT * FROM raha_zurnal") or die(mysqli_error($connect));
 		// $sqltran = mysqli_query($connect, "SELECT raha_zurnal.doknr, tehing.product FROM raha_zurnal, tehing GROUP BY doknr") or die(mysqli_error($connect));
		$arrVal = array();

		$i=1;
 		while ($rowList = mysqli_fetch_array($sqltran)) {
 								 
						$name = array(

 	 		 	 				'doknr' => $rowList['doknr'],
	 		 	 				'doc_cat' => $rowList['doc_cat'],
	 		 	 				'kuupaev' => $rowList['kuupaev'],
	 		 	 				'summa' => $rowList['summa'],
	 		 	 				'pank' => $rowList['pank'],
	 		 	 				'pos' => $rowList['pos'],
	 		 	 				'autor' => $rowList['autor']
	 		 	 				
 	 		 	 			);		


							array_push($arrVal, $name);	
			$i++;			
	 	}
	 		 echo  json_encode($arrVal);		
 

	 	mysqli_close($connect);
?>   
 
<?php

//CREDENTIALS FOR DB
define('DBSERVER', 'd13476.mysql.zonevs.eu');
define('DBUSER', 'd13476_kassa');
define('DBPASS', 'rD5cW5L8FKEe');
define('DBNAME', 'd13476_kassa');


try {
    if (isset($_POST['doknr']) && !empty($_POST['doknr'])) {
		$connect = mysqli_connect("d13476.mysql.zonevs.eu", "d13476_kassa", "rD5cW5L8FKEe", "d13476_kassa");
		
        // Sanitize your inputs. I'm guessing link is a string?
        //$ean = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $doknr = $_POST['doknr'];
        // create query string for prepared statement
		$sqltran = mysqli_query($connect, "SELECT * FROM tehing WHERE doknr = $doknr") or die(mysqli_error($connect));
 	    $arrVal = array();

	   $i=1;
		while ($rowList = mysqli_fetch_array($sqltran)) {
								 
					   $name = array(

						   'product' => $rowList['product'],
                           'EAN' => $rowList['EAN'],
                           'tk' => $rowList['tk'],
                           'total' => $rowList['total'],
						   'doknr' => $rowList['doknr']
								  
							   );		


						   array_push($arrVal, $name);	
		   $i++;			
		}

        // // prepare statement and bind variables
        // $stmt = $mysqli->prepare($sql);
        // $stmt->bind_param('s', $doknr);
        // $stmt->execute();

        // $result = $stmt->get_result();

        // $row = $result->fetch_assoc();
        // $stmt->close();


        sendResponse(200, $arrVal);
        //sendResponse(200, $result);
    }

    sendResponse(400, ['status' => 'Link not supplied']);
} catch (\Exception $e) {
    sendResponse(500, ['status' => $e->getMessage()]);
}

/**
 * Sends JSON encoded response to client side with response http code.
 */
function sendResponse($code, $response)
{

    http_response_code($code);
    echo json_encode($response);
    exit();
}


/**
 * Handles connecting to mysql.
 *
 * @return object $connect instance of MySQLi class
 */
function connect()
{
    try {
        $connect = new \mysqli("d13476.mysql.zonevs.eu", "d13476_kassa", "rD5cW5L8FKEe", "d13476_kassa");
        return $connect;
    } catch (mysqli_sql_exception $e) {
        throw $e;
    }
}


?>   
 
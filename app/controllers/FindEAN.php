<?php

//CREDENTIALS FOR DB
define('DBSERVER', 'd13476.mysql.zonevs.eu');
define('DBUSER', 'd13476_kassa');
define('DBPASS', 'rD5cW5L8FKEe');
define('DBNAME', 'd13476_kassa');


try {
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $mysqli = connect();

        // Sanitize your inputs. I'm guessing link is a string?
        //$ean = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $ean = $_POST['name'];
        // create query string for prepared statement
        $sql = "SELECT name, hind, tara FROM tovar WHERE EAN = ? LIMIT 1";

        // prepare statement and bind variables
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $ean);
        $stmt->execute();

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        $stmt->close();


        sendResponse(200, $row);
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

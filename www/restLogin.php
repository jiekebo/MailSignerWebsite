<?php
require_once ('XML/Serializer.php');
require_once 'rest.php';

$objDOM = new DOMDocument();
$objDOM->load('misc/connection.xml');

$MySQL_host = $objDOM->getElementsByTagName('host')->item(0)->nodeValue;
$MySQL_user = $objDOM->getElementsByTagName('user')->item(0)->nodeValue;
$MySQL_pass = $objDOM->getElementsByTagName('pass')->item(0)->nodeValue;
$db = $objDOM->getElementsByTagName('db')->item(0)->nodeValue;

mysql_connect($MySQL_host, $MySQL_user, $MySQL_pass) /*or die (mysql_error())*/;
mysql_select_db($db) /*or die (mysql_error())*/;

function query($string, $debug=0){
    if($debug==1)
        print $string;
    if($debug==2)
        error_log($string);

    $result = mysql_query($string);

    if(!$result){
        error_log("SQL error: ".mysql_error()."\n\nOriginal query: $string\n");
        die("SQL error: ".mysql_error()."\n<br/>\nOriginal query: $string\n<br/>\n<br/>");
    }
    return $result;
}

function query_table($sql, $debug=0){
    $result = query($sql, $debug);

    $table = array();
    if(mysql_num_rows($result)>0){
        $i = 0;
        while($table[$i] = mysql_fetch_assoc($result))
            $i++;
        unset($table[$i]);
    }
    mysql_free_result($result);
    return $table;
}

$data = RestUtils::processRequest();
$input = $data->getRequestVars();

// Find activated users of the entered email
$userData = query_table("SELECT `idUser`, `companyName`, `firstName`, `lastName`, `password`, `userType`
                         FROM `User` 
                         WHERE `mail` = '{$input['user']}' AND `activated` = 1");

// If amount of activated users is larger than 1 (meaning there is a real customer account and a demo account)
// find the customer account!
$userIndex = 0;
if(sizeof($userData)>1){
    while($userData[$userIndex]['userType'] != 'cst')
        $userIndex++;
}

// if password is correct and user is activated log in
if(crypt($input['pass'], $userData[$userIndex]['password'])==$userData[$userIndex]['password']){
    $timeStamp = date('Y-m-d', time());
    $mailSignerUsers = query_table("SELECT
                                        `pright`.`quantity`
                                    FROM
                                        (SELECT
                                            `Order`.`active`,
                                            `Order`.`expires`,
                                            `OrderItem`.`productNumber`,
                                            `OrderItem`.`quantity`
                                        FROM `Order`
                                        JOIN `OrderItem`
                                        ON `Order`.`idOrder` = `OrderItem`.`idOrder`
                                        WHERE `Order`.`idUser` = '{$userData[$userIndex]['idUser']}' AND `Order`.`active` = 1 AND '$timeStamp' <= `Order`.`expires`)
                                       AS pright
                                    JOIN `Product`
                                    ON `pright`.`productNumber` = `Product`.`productNumber`
                                    WHERE `Product`.`productType` = 'MailSigner'");
    // Send response if licence has expired here (users = 0)
    $userData[$userIndex]['users'] = $mailSignerUsers[0]['quantity'];
    
    $returnData = array();
    foreach ($userData[$userIndex] as $key => $value) {
        if($key != 'idUser' && $key != 'password'){
            $returnData[$key] = urlencode($value);
        }
    };

    $premiumSignatures = query_table("SELECT
                                          `Product`.`productName`,
                                          `Product`.`imageLocation`
                                      FROM
                                          (SELECT
                                              `Order`.`active`,
                                              `OrderItem`.`productNumber`,
                                              `OrderItem`.`quantity`
                                          FROM `Order`
                                          JOIN `OrderItem`
                                          ON `Order`.`idOrder` = `OrderItem`.`idOrder`
                                          WHERE `Order`.`idUser` = '{$userData[0]['idUser']}' AND `Order`.`active` = 1)
                                          AS pright
                                      JOIN `Product`
                                      ON `pright`.`productNumber` = `Product`.`productNumber`
                                      WHERE `Product`.`productType` = 'Signature' AND `Product`.`productState` = 1");

    $i = 0;
    foreach ($premiumSignatures as $key => $value) {
        foreach($value as $name => $val)
            $returnData['signatures']['signature_'.$i][$name] = $val;
        $i++;
    }

    $options = array('indent' => '     ','addDecl' => false,'rootName' => 'Result',XML_SERIALIZER_OPTION_RETURN_RESULT => true);
    $serializer = new XML_Serializer($options);
    RestUtils::sendResponse(200, $serializer->serialize($returnData), 'application/xml');
} else {
    // send 200 response containing xml to java showing wrong password etc...
    $returnData = array();
    $returnData['companyName'] = 0;
    $returnData['firstName'] = 0;
    $returnData['lastName'] = 0;
    $returnData['userType'] = 0;
    $returnData['users'] = 0;
    $options = array('indent' => '     ','addDecl' => false,'rootName' => 'Result',XML_SERIALIZER_OPTION_RETURN_RESULT => true);
    $serializer = new XML_Serializer($options);
    RestUtils::sendResponse(200, $serializer->serialize($returnData), 'application/xml');
}
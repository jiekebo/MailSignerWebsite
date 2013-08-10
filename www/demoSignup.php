<?php
include('include.php');

$userExistsCheck = query_list("SELECT *
                               FROM `User`
                               WHERE `mail` = '{$_GET['email1']}'
                                   AND `activated` = 1");
if($userExistsCheck[11] == 1){
    echo "1";
    $error = 1;
} else {
    echo "0";
}
if(!inputChecker("mail", $_GET['email1'])){
    echo "1";
    $error = 1;
} else {
    echo "0";
}
if($_GET['email1'] != $_GET['email2']){
    echo "1";
    $error = 1;
} else {
    echo "0";
}
if(!inputChecker("pass", $_GET['password1'])){
    echo "1";
    $error = 1;
} else {
    echo "0";
}
if($_GET['password1'] != $_GET['password2']){
    echo "1";
    $error = 1;
} else {
    echo "0";
}

if($error){
    echo "1";
} else if (!$_GET['confirm']) {
    echo "0";
} else {
    echo "0";
    $cryptPass = crypt($_GET['password1']);
    $cnt = query_list("SELECT `isoName` FROM `Countries` WHERE `Name` = '{$_GET['country']}'");
    // Insert user data, deactivated
    query("INSERT INTO `User` (`companyName`, `firstName`, `lastName`, `mail`, `password`, `address`, `city`, `postCode`, `country`, `userType`)
           VALUES ('demo', 'demo', 'demo', '{$_GET['email1']}', '$cryptPass', 'demo', 'demo', 0000, 'DK', 'dmo')");
    // Get the assigned user id (maximum id if several tries to sign up)
    $idUser = query_list("SELECT MAX(`idUser`) FROM `User` WHERE `Mail` = '{$_GET['email1']}'");
    // Get timestamp, product validity and calculate expiry date
    $timeStamp = date('Y-m-d H:i:s', time());
    $product = query_list("SELECT `productNumber`,`priceDKK`,`validity`
                           FROM `Product`
                           WHERE `quantity` > '{$_GET['users']}'
                               AND `productType` = 'MailSigner'
                               AND `productState` = 1
                               LIMIT 1");
    $expiryDate = date('Y-m-d H:i:s', strtotime($timeStamp) + (30*24*60*60));
    // dueDate is always 30 days ahead
    $dueDate = date('Y-m-d H:i:s', strtotime($timeStamp) + (30*24*60*60));
    // Insert an order head with the users data, billing address, dates
    query("INSERT INTO `Order` (`idUser`, `address`, `city`, `postcode`, `date`, `expires`, `dueDate`)
           VALUES ('$idUser[0]', '{$_GET['address']}', '{$_GET['city']}', '{$_GET['postcode']}', '$timeStamp', '$expiryDate', '$dueDate')");
    // Get order head id, to be used in the order lines. Newest order on the exact time from certain user
    $idOrder = query_list("SELECT MAX(`idOrder`)
                           FROM `Order`
                           WHERE `idUser` = '$idUser[0]' AND `date` = '$timeStamp'");
    // Create an order line containing the mailsigner, with the amount of users requested
    $priceDKK = $product[1] * 10;
    query("INSERT INTO `OrderItem` (idOrder, productNumber, quantity, priceDKK)
           VALUES ('$idOrder[0]', '$product[0]', '10', '$priceDKK')");

    // Html mail source with active php fields
    include('activationMail.php');

    // send the mail
    include('Mail.php');
    include('Mail/mime.php');

    $message = new Mail_mime();
    $message->setTXTBody("Test");
    $message->setHTMLBody($html);
    $body = $message->get();
    $extraheaders = array("From"=>"MailSigner Trial Service <invoice@mailsigner.com>", "Subject"=>"Your MailSigner Trial Activation");
    $headers = $message->headers($extraheaders);
    $to = "<" . $_GET['email1'] . ">";
    $mail = Mail::factory("mail");
    $mail->send($to, $headers, $body);
}
?>
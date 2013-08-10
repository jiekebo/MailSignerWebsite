<?php
include('include.php');

if($_GET['users'] == 0){
    echo "1";
    $error = 1;
} else {
    echo "0";
}
$userExistsCheck = query_list("SELECT * 
                               FROM `User`
                               WHERE `mail` = '{$_GET['email1']}'
                                   AND `activated` = 1
                                   AND `userType` <> 'dmo'");
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
if(!inputChecker("company", $_GET['company'])){
    echo "1";
    $error = 1;
} else {
    echo "0";
}
if(!inputChecker("name", $_GET['fname'])){
    echo "1";
    $error = 1;
} else {
    echo "0";
}
if(!inputChecker("name", $_GET['lname'])){
    echo "1";
    $error = 1;
} else {
    echo "0";
}
if(!inputChecker("address", $_GET['address'])){
    echo "1";
    $error = 1;
} else {
    echo "0";
}
if(!inputChecker("name", $_GET['city'])){
    echo "1";
    $error = 1;
} else {
    echo "0";
}
if(!inputChecker("number", $_GET['postcode'])){
    echo "1";
    $error = 1;
} else {
    echo "0";
}
if(!$_GET['country']){
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
           VALUES ('{$_GET['company']}', '{$_GET['fname']}', '{$_GET['lname']}', '{$_GET['email1']}', '$cryptPass', '{$_GET['address']}', '{$_GET['city']}', {$_GET['postcode']}, '$cnt[0]', 'cst')");
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
    $expiryDate = calculateExpiry($product[2], strtotime($timeStamp));
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
    $priceDKK = $product[1] * $_GET['users'];
    query("INSERT INTO `OrderItem` (idOrder, productNumber, quantity, priceDKK)
           VALUES ('$idOrder[0]', '$product[0]', '{$_GET['users']}', '$priceDKK')");

    // Create invoice pdf
    createInvoice($idUser[0], $idOrder[0], 'invoices/', 'F');

    // Html mail source with active php fields
    include('activationMail.php');

    // send the mail
    include('Mail.php');
    include('Mail/mime.php');

    $message = new Mail_mime();
    $message->setTXTBody("Test");
    $message->setHTMLBody($html);
    $message->addAttachment('invoices/'.$idOrder[0].'-'.date('Y-m-d').'.pdf');
    $body = $message->get();
    $extraheaders = array("From"=>"MailSigner Invoice <invoice@mailsigner.com>", "Subject"=>"MailSigner Invoice");
    $headers = $message->headers($extraheaders);
    $to = $_GET['fname'] . $_GET['lname'] . "<" . $_GET['email1'] . ">";
    $mail = Mail::factory("mail");
    $mail->send($to, $headers, $body);
}
?>
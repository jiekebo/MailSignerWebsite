<?php
include ('include.php');
if($_GET['quantity'] == null || !is_numeric($_GET['quantity'])) {
} else {
    $product = query_list("SELECT `priceDKK`
                       FROM `Product`
                       WHERE `quantity` >= {$_GET['quantity']}
                           AND `productType` = 'MailSigner'
                           AND `productState` = 1
                       LIMIT 1");
    echo $product[0];
}
?>
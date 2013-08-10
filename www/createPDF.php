<?php
include('include.php');
if($_GET['order']){
    createInvoice($_SESSION['id'], $_GET['order'], '', 'D');
}
mysql_close();
?>

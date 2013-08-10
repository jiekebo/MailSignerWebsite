<?php
include('include.php');
$userData = query_list("SELECT * FROM `User` WHERE `idUser` = {$_SESSION['id']}");
// if password is correct and user is activated log in
if(crypt($_GET['oldPass'], $userData[5])==$userData[5]){
    if($_GET['newPass'] == $_GET['confirmPass']){
        if(inputChecker("pass", $_GET['newPass'])){
            $cryptPass = crypt($_GET['newPass']);
            query("UPDATE `User` SET `password` = '$cryptPass' WHERE `idUser` = '{$_SESSION['id']}'");
            echo "3";
        } else {
            // not a password, regex
            echo "2";
        }
    } else {
        // new passwords don't match
        echo "1";
    }
} else {
    // doesn't match old password
    echo "0";
}
?>
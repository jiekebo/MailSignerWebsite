<?php
/*
 * Performs a login from a javascript input, and validates the input upon returning
 * codes to the javascript interface
 * 0: 
 */
include('include.php');
if ($_SESSION['id'] && $_GET['logout']) {
    session_unset();
    session_destroy();
    echo "1";
} else if ($_SESSION['id']){
    echo "1";
} else if((!$_GET['userLogin'] && !$_GET['userPass'])){
    echo "0";
} else {
    $userData = query_list("SELECT * 
                            FROM `User`
                            WHERE `mail` = '{$_GET['userLogin']}' AND `activated` = 1 AND `userType` <> 'dmo'");
    // if password is correct and user is activated log in.
    // TODO: give warning if demo users tries to log in!
    if(crypt($_GET['userPass'], $userData[5])==$userData[5]){
        $_SESSION['id'] = $userData[0];
        $_SESSION['name'] = $userData[2];
        $_SESSION['familyName'] = $userData[3];
        echo "1";
    } else {
        echo "0";
    }
}
?>

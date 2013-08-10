<?php
session_start();

$objDOM = new DOMDocument();
$objDOM->load('misc/connection.xml');

$MySQL_host = $objDOM->getElementsByTagName('host')->item(0)->nodeValue;
$MySQL_user = $objDOM->getElementsByTagName('user')->item(0)->nodeValue;
$MySQL_pass = $objDOM->getElementsByTagName('pass')->item(0)->nodeValue;
$db = $objDOM->getElementsByTagName('db')->item(0)->nodeValue;

mysql_connect($MySQL_host, $MySQL_user, $MySQL_pass) /*or die (mysql_error())*/;
mysql_select_db($db) /*or die (mysql_error())*/;


//This stops SQL Injection in POST vars
foreach ($_POST as $key => $value) {
    $_POST[$key] = mysql_real_escape_string(stripslashes(trim($value)));
}

//This stops SQL Injection in GET vars
foreach ($_GET as $key => $value) {
    $_GET[$key] = mysql_real_escape_string(stripslashes(trim($value)));
}

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

function query_list($sql, $debug=0){
    $result = query($sql, $debug);
    
    if($lst = mysql_fetch_row($result)){
        mysql_free_result($result);
        return $lst;
    }
    mysql_free_result($result);
    return false;
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

function calculateExpiry($yearsValidity, $timeStamp) {
    // compensate for leap years (one extra day in february)
    if ((int)date('m', $timeStamp) <= 2){
        $year = (int) date('y', $timeStamp);
        echo $year%4 . "<br/>";
        echo $year%100 . "<br/>";
        echo $year%400 . "<br/>";
        if((($year % 4 == 0) && ($year % 100 != 0)) || ($year % 400 == 0)){
            $dueDate = date('Y-m-d H:i:s', $timeStamp + ($yearsValidity*366*24*60*60));
        }
    // normal year
    } else {
        $dueDate = date('Y-m-d H:i:s', $timeStamp + ($yearsValidity*365*24*60*60));
    }
    return $dueDate;
}

function createInvoice($user, $order, $outPath, $outMethod){
    require_once('misc/tcpdf/config/lang/eng.php');
    require_once('misc/tcpdf/tcpdf.php');
    class MYPDF extends TCPDF {
        public function Header() {
            $this->setJPEGQuality(90);
            $this->Image('img/invlogo.png', 120, 10, 75, 0, 'PNG', 'http://www.mailsigner.com', '', true, 150, '', false, false, 0, false, false, false);

        }
        public function Footer() {
            $this->SetY(-15);
            $this->SetFont(PDF_FONT_NAME_MAIN, 'I', 8);
            $this->Cell(0, 10, 'MailSigner - The easy way to manage mail signatures', 0, false, 'C');
        }
        public function CreateTextBox($textval, $x = 0, $y = 0, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L') {
            $this->SetXY($x+20, $y); // 20 = margin left
            $this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
            $this->Cell($width, $height, $textval, 0, false, $align);
        }
    }

    // create a PDF object
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document (meta) information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('MailSigner');
    $pdf->SetTitle('MailSigner Invoice');
    $pdf->SetSubject('MailSigner Invoice');
    $pdf->SetKeywords('MailSigner, Invoice');

    // add a page
    $pdf->AddPage();

    $pdf->SetFillColor(200,200,200);
    $pdf->MultiCell(60, 5, "<b>MailSigner &copy;</b> <br /> Kronetorpsgatan 70D <br /> 21227 Malmö <br /> Sweden", 1, 'L', 1, 1, '130', '35', true, 0, true);

    $userData = query_list("SELECT * FROM `User` WHERE `idUser` = $user");
    $orderData = query_list("SELECT * FROM `Order` WHERE `idUser` = $user and idOrder = $order");
    $country = query_list("SELECT * FROM `Countries` WHERE `isoName` = '{$userData['9']}'");
    if($orderData != NULL){
        $orderDetails = query_table("SELECT
                                        `OrderItem`.`productNumber`,
                                        `Product`.`productName`,
                                        `Product`.`description`,
                                        `Product`.`productType`,
                                        `OrderItem`.`quantity`,
                                        `Product`.`priceDKK`,
                                        `OrderItem`.`priceDKK` AS totalPriceDKK
                                    FROM `OrderItem`
                                    JOIN `Product`
                                    ON `OrderItem`.`productNumber` = `Product`.`productNumber`
                                    WHERE `idOrder` = $order");

        // create address box
        $pdf->CreateTextBox(utf8_encode($userData['1']), 0, 55, 80, 10, 10, 'B');
        $pdf->CreateTextBox(utf8_encode($userData['2']) . " " . utf8_encode($userData['3']), 0, 60, 80, 10, 10);
        $pdf->CreateTextBox(utf8_encode($userData['6']), 0, 65, 80, 10, 10);
        $pdf->CreateTextBox(utf8_encode($userData['8']) . ", " . utf8_encode($userData['7']), 0, 70, 80, 10, 10);
        $pdf->CreateTextBox(utf8_encode($country['1']), 0, 75, 80, 10, 10);


        // invoice title / number
        $pdf->CreateTextBox("Order ref.: #" . $orderData['0'], 0, 90, 120, 20, 16);

        // date, order ref
        $pdf->CreateTextBox("Order date: " . date('Y-m-d', strtotime($orderData['5'])), 0, 105, 0, 10, 10);
        if(strtotime($orderData['6']) == 0){
            $expires = '';
        } else {
            $expires = date('Y-m-d', strtotime($orderData['6']));
        }
        $pdf->CreateTextBox("Licence expires: " . $expires, 0, 110, 0, 10, 10);
        $pdf->CreateTextBox('Invoice Date: '.date('Y-m-d'), 130, 105, 0, 10, 10);
        //$pdf->CreateTextBox('Order ref.: #6765765', 0, 105, 0, 10, 10, '', 'R');

        // list headers
        $pdf->CreateTextBox('Quantity', 0, 120, 20, 10, 10, 'B', 'C');
        $pdf->CreateTextBox('Product or service', 20, 120, 90, 10, 10, 'B');
        $pdf->CreateTextBox('Price', 110, 120, 30, 10, 10, 'B', 'R');
        $pdf->CreateTextBox('Amount', 140, 120, 30, 10, 10, 'B', 'R');

        $pdf->Line(20, 129, 195, 129);

        $currY = 128;
        $total = 0;

        foreach ($orderDetails as $orderRow){
            $pdf->CreateTextBox($orderRow['quantity'], 0, $currY, 20, 10, 10, '', 'C');
            $pdf->CreateTextBox($orderRow['productName'], 20, $currY, 90, 10, 10, '');
            $pdf->CreateTextBox($orderRow['priceDKK'].' DKK', 110, $currY, 30, 10, 10, '', 'R');
            $amount = $orderRow['quantity']*$orderRow['priceDKK'];
            $pdf->CreateTextBox($amount.' DKK', 140, $currY, 30, 10, 10, '', 'R');
            $currY = $currY+5;
            $total += $amount;
        }
        $pdf->Line(20, $currY+4, 195, $currY+4);

        // output the total row
        $pdf->CreateTextBox('Total ' . number_format($total, 2, '.', '').' DKK', 140, $currY+5, 30, 10, 10, 'B', 'R');

        // some payment instructions or information
        $pdf->setXY(20, $currY+30);
        $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);
        $dueDate = date('Y-m-d', strtotime($orderData['7']));
        $pdf->MultiCell(175, 10, "<em>Payment expected within 30 days of purchase ($dueDate) </em>.", 0, 'L', 0, 1, '', '', true, null, true);

        //Close and output PDF document
        $pdf->Output($outPath . $orderData['0'].'-'.date('Y-m-d').'.pdf', $outMethod);
    }
}

function nav(){
    if(!$_SESSION == null){
        ?>
        <ul class='menu'>
            <li class='home'><a href="./">Home</a></li>
            <li class='shop'><a href="./shop">Shop</a></li>
            <li class='download'><a href="./download">Download</a></li>
            <li class='support'><a href="./support">Support</a></li>
            <li class='contact'><a href="./profile">Contact</a></li>
            <li class='login'><a href="#">Login</a></li>
        </ul>
        <script type="text/javascript">
            $(".login").click(function(){
                $("#light").fadeIn(400);
                $("#fade").fadeIn(1000);
            });
        </script>
        <?php
    } else {
        ?>
        <ul class='menuLogin menu'>
            <li class='home'><a href="./">Home</a></li>
            <li class='shop'><a href="./shop">Shop</a></li>
            <li class='download'><a href="./download">Download</a></li>
            <li class='support'><a href="./support">Support</a></li>
            <li class='contact'><a href="./profile">Profile</a></li>
            <li class='login' id="login"><a href="#">Logout</a></li>
        </ul>
        <script type="text/javascript">
            $("#login").click(function(){
                $.get('login.php?logout=1', loginState);
                function loginState(data){
                    if(data == 1){
                        window.location = './';
                    }
                }
            });
        </script>
        <?php
    }
}

function loginBox(){
    ?>
    <div id="light" class="vertical">
        <div class="horizontal">
            <form class="loginForm" action="" method="post">
                <table>
                    <tr>
                        <td><label>E-mail:</label></td><td><label>Password:</label></td>
                    </tr>
                    <tr>
                        <td><input id="userLogin" type="text" name="userLogin" maxlength="30"/></td>
                        <td><input id="userPass" type="password" name="userPass" maxlength="30"/></td>
                    </tr>
                    <tr><td></td><td style="font: normal 10px verdana; vertical-align: top;"><a href="loginRecover">Forgot password?</a></td></tr>
                </table>
            </form>
            <div class="result"></div>
            <a href="#" class="button greenButton loginButtonPos" id="loginButton">LOGIN</a>
            <a href="#" class="button redButton cancelButtonPos" id="cancelButton">CANCEL</a>
        </div>
    </div>
    <div id="fade" class="overlay"></div>
    <script type="text/javascript">
        function performLogin(){
            userLogin = $('#userLogin').val();
            userPass = $('#userPass').val();
            $('.result').css({background: "url('./img/load.gif') no-repeat scroll 5px 4px #AAAAAA", width: "30px"});
            $('.result').html("");
            $.get('login.php?userLogin='+userLogin+"&userPass="+userPass, loginState);
            function loginState(data){
                if(data == 1){
                    window.location.reload();
                } else {
                    $('.result').css({background: "none", width: "150px"});
                    $('.result').html("Invalid username/password");
                }
            }
        }
        $("#userLogin, #userPass").keypress(function(e){
            if (e.which == 13)
            {
                performLogin();
            }
        });
        $("#loginButton").click(performLogin);
        $("#cancelButton").click(function(){
            $('#light').hide();
            $('#fade').hide();
        });
    </script>
    <?php
}

function sitemap(){
    ?>
    <div class="footer footer_1">
        <h3>Why MailSigner?</h3>
        <ul>
            <li><a href="./management">Management</a></li>
            <li><a href="./creativity">Creativity</a></li>
            <li><a href="./compatibility">Compatibility</a></li>
        </ul>
    </div>
    <div class="footer">
        <h3>Purchasing</h3>
        <ul>
            <li><a href="./shop">Shop</a></li>
            <li><a href="./download">Download</a></li>
        </ul>
    </div>
    <div class="footer">
        <h3>Customer Care</h3>
        <ul>
            <li><a href="./support">Support</a></li>
            <li><a href="./profile">My Profile</a></li>
        </ul>
    </div>
    <div class="footer">
        <h3>MailSigner Blog</h3>
        <ul>
            <li><a href="#">Coming soon!</a></li>
            <!--<li><a href="./support">Very important stuffs!!!</a></li>
            <li><a href="./profile">Evil important stuffs!!!</a></li>-->
        </ul>
    </div>
    <?php
}

function copyright(){
    echo "&copy; 2010 MailSigner &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; <a href='mailto:info@mailsigner.com' class='copyrightLink'>info@mailsigner.com</a>";
}

function inputChecker($type, $string){
    $regExpNames = "/^.{0,45}$/";
    $regExpAddress = "/^.{0,45}$/";
    $regExpCompany = "/^.{0,45}$/";
    $regExpPass = "/^[A-z0-9._?!]{5,15}$/";
    $regExpMail = "/^[^0-9][A-z0-9_-]+([.][A-z0-9_-]+)*[@][A-z0-9_-]+([.][A-z0-9_-]+)*[.][A-z]{2,4}$/";
    $regExpNumber = "/^[0-9]+$/";
    switch ($type) {
    case "pass":
        if(preg_match($regExpPass, $string)){
            return 1;
        } else {
            return 0;
        }
        break;
    case "name":
        if(preg_match($regExpNames, $string)){
            return 1;
        } else {
            return 0;
        }
        break;
    case "address":
        if(preg_match($regExpAddress, $string)){
            return 1;
        } else {
            return 0;
        }
    case "company":
        if(preg_match($regExpCompany, $string)){
            return 1;
        } else {
            return 0;
        }
    case "mail":
        if(preg_match($regExpMail, $string)){
            return 1;
        } else {
            return 0;
        }
        break;
    case "number":
        if(preg_match($regExpNumber, $string)){
            return 1;
        } else {
            return 0;
        }
        break;
    default:
        break;
    }
}

function htmlHeader($title){
    ?>
    <head>
        <title><?php echo $title; ?></title>

        <meta name="description" content="Easily deploy and manage many users multiple signatures. Works with all major mail clients and online mail services. It even works without an Active Directory. Will run on multiple platforms." />
        <meta name="keywords" content="mail signature, mail signer, deployment, management, outlook, thunderbird, gmail, hotmail, active directory, pc, mac, linux" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="copyright" content="Copyright © 2010 MailSigner" />
        <meta name="author" content="Jacob Salomonsen" />
        <meta name="designer" content="Jacob Salomonsen" />
        <meta name="robots" content="index, follow" />
        <meta name="googlebot" content="index, follow" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta name="revisit-after" content="7 Days" />
        <meta name="google-site-verification" content="7Mk5c-fX1koufkyIoqBqpwD8cHP16DSMb_gtvjuc61k" />

        <link rel="icon" type="image/x-icon" href="/favicon.ico" />
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
        <link rel="stylesheet" href="css/960.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="css/menu.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="css/reset.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="css/style.css"type="text/css" media="screen" />
        <link rel="stylesheet" href="css/tableStyle.css" type="text/css" media="screen"/>

        <script type="text/javascript"  src="scr/jquery-1.4.2.min.js"></script>
        <link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.5.custom.css" type="text/css"/>

        <script src="scr/jquery-1.4.2.min.js" type="text/javascript"></script>
        <script src="scr/jquery-ui-1.8.5.custom.min.js" type="text/javascript"></script>
    </head>
    <?php
}
?>
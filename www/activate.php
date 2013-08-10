<?php
include ('include.php');
// gets: id, md5(idUser.cryptPass)  user, idUser
// Select the user with idUser id
$userData = query_list("SELECT password
                        FROM User
                        WHERE idUser = '{$_GET['user']}'");
if(md5($_GET['user'].$userData[0]) == $_GET['id']){
    query("UPDATE `User` SET `activated` = '1' WHERE `idUser`={$_GET['user']}");
	?>
		<html>
		<head>
                    <style type='text/css'>
                    html, body {
                        height: 100%;
                        margin: 0;
                        padding: 0;
                    }
                    img#bg {
                        position:fixed;
                        top:0;
                        left:0;
                        width:100%;
                        height:100%;
                    }
                    #outer {
                        position: absolute;
                        top: 50%;
                        left: 0px;
                        width: 100%;
                        height: 1px;
                        overflow: visible;
                        z-index:1;
                    }
                    #inner {
                        width: 478px;
                        height: 166px;
                        margin-left: -248px;  /***  width / 2   ***/
                        position: absolute;
                        top: -97px;          /***  height / 2   ***/
                        left: 50%;
                    }
                    #button{
                        background: url('img/activated_button.png') no-repeat;
                        width: 496px;
                        height: 193px;
                    }
                    #button a{
                        position: relative;
                        top: 11px;
                        display: block;
                        width: 478px;
                        height: 166px;
                        margin: auto;
                    }
                    </style>
		</head>
		<body>
                    <div id="outer">
                        <div id="inner">
                            <div id='button'><a href='http://www.mailsigner.com'></a></div>
                        </div>
                    </div>
                    <img src="img/activated_bg.png" alt="background image" id="bg" />
                    <?php include_once("analyticstracking.php") ?>
		</body>
		</html>
	<?php
} else {
    	?>
		<html>
		<head>
                    <style type='text/css'>
                    html, body {
                        height: 100%;
                        margin: 0;
                        padding: 0;
                    }
                    img#bg {
                        position:fixed;
                        top:0;
                        left:0;
                        width:100%;
                        height:100%;
                    }
                    #outer {
                        position: absolute;
                        top: 50%;
                        left: 0px;
                        width: 100%;
                        height: 1px;
                        overflow: visible;
                        z-index:1;
                    }
                    #inner {
                        width: 478px;
                        height: 166px;
                        margin-left: -248px;  /***  width / 2   ***/
                        position: absolute;
                        top: -97px;          /***  height / 2   ***/
                        left: 50%;
                    }
                    #button{
                        background: url('img/deactivated_button.png') no-repeat;
                        width: 496px;
                        height: 193px;
                    }
                    #button a{
                        position: relative;
                        top: 11px;
                        display: block;
                        width: 478px;
                        height: 166px;
                        margin: auto;
                    }
                    </style>
		</head>
		<body>
                    <div id="outer">
                        <div id="inner">
                            <div id='button'><a href='http://www.mailsigner.com'></a></div>
                        </div>
                    </div>
                    <img src="img/activated_bg.png" alt="background image" id="bg" />
                    <?php include_once("analyticstracking.php") ?>
		</body>
		</html>
	<?php
}
mysql_close();?>
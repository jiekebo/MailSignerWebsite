<?php include('include.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <?php htmlHeader("MailSigner - The easy way to manage mail signatures, even without Active Directory and Outlook"); ?>
    <body>
        <div class="container_12">
            <div class="grid_4 logo"></div>
            <div class="grid_8">
                <?php nav(); ?>
            </div>
            <div class="grid_12 smallHeader"></div>
            <div class="grid_12 contents" style="height: 450px;">
                <div class="titleBackground shopColor">
                    <div class="titleImagePos shopIcon"></div>
                    <div class="titleTextPos">
                        <h1>Recover your account</h1>
                        <p>Enter your e-mail below</p>
                    </div>
                </div>
                <div class="text">
                    If you have lost the password for your account, please enter your e-mail below.<br/>
                    An automatically generated password will be sent to you, which you can use to login again.<br/>
                    We advise you to change the password from your profile page.
                    <form action="<?php echo "loginRecover?action=recover";?>" method="post">
                        <input type="text" name="eMail"/><input type="submit" value="Send"/>
                    </form>
                    <?php
                        function gen_trivial_password($len = 8){
                            $r = '';
                            for($i=0; $i<$len; $i++)
                                $r .= chr(rand(0, 25) + ord('a'));
                            return $r;
                        }

                        if(isset($_GET['action']) && $_GET['action'] == 'recover'){
                            $pass;
                            $eMail = $_POST['eMail'];
                            $pass = gen_trivial_password();
                            $cryptPass = crypt($pass);
                            query("UPDATE `User`
                                   SET `password`='$cryptPass'
                                   WHERE `mail`='$eMail' and `activated`='1'");

                            include('Mail.php');
                            include('Mail/mime.php');

                            $message = new Mail_mime();
                            $message->setTXTBody("Your temporary password is: " . $pass);
                            //$message->setHTMLBody($html);
                            $body = $message->get();
                            $extraheaders = array("From"=>"MailSigner Invoice <invoice@mailsigner.com>", "Subject"=>"MailSigner Invoice");
                            $headers = $message->headers($extraheaders);
                            $to = "<" . $eMail . ">";
                            $mail = Mail::factory("mail");
                            $mail->send($to, $headers, $body);
                        }
                    ?>
                </div>
            </div>
            <div class="grid_12 siteMap"><?php sitemap(); ?></div>
            <div class="clear"></div>
            <div class="grid_12">
                <?php copyright(); ?>
            </div>
        </div>
        <?php loginBox(); ?>
        <?php include_once("analyticstracking.php") ?>
    </body>
</html>
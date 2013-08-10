<?php include('include.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <?php htmlHeader("MailSigner - The easy way to manage mail signatures, even without Active Directory and Outlook"); ?>
    <body id="download">
        <div class="container_12">
            <div class="grid_4 logo"></div>
            
            <div class="grid_8">
                <?php nav(); ?>
            </div>
            
            <div class="grid_12 smallHeader"></div>
            
            <div class="grid_12 titleBackground shopColor">
                <div class="titleImagePos shopIcon"></div>
                <div class="titleTextPos">
                    <h1>Download MailSigner</h1>
                    <p>Here you can download the latest MailSigner</p>
                </div>
            </div>

            <div class="grid_1">&nbsp;</div>
            
            <div class="grid_4 contents">
                <div class="formDivider">
                    <fieldset class="inputField">
                        <legend>Account Details</legend>
                        <table>
                            <tr><td class="label">E-mail</td><td><input id="email1" type="text" name="email1"/></td></tr>
                            <tr class="inputError" id="userExists"><td></td><td>user already exists</td></tr>
                            <tr class="inputError" id="emailCheck"><td></td><td>Not an email</td></tr>
                            <tr><td class="label">Repeat E-mail</td><td><input id="email2" type="text" name=""/></td></tr>
                            <tr class="inputError" id="emailMatch"><td></td><td>e-mail addresses don't match</td></tr>
                            <tr><td class="label">Password</td><td><input id="password1" type="password" name=""/></td></tr>
                            <tr class="inputError" id="passCheck"><td></td><td>Not a password</td></tr>
                            <tr><td class="label">Repeat password</td><td><input id="password2" type="password" name=""/></td></tr>
                            <tr class="inputError" id="passMatch"><td></td><td>Passwords don't match</td></tr>
                        </table>
                    </fieldset>
                    <a href="javascript:void(0);" class="button greenButton" id="submit" style="float: left; margin-bottom: 30px;">Submit</a>
                </div>
            </div>

            <div class="grid_6">
                Please click the link below to download MailSigner.<br/>
                You can also sign up for a 30 day trial, just provide us with your mail and the password you would like.<br/>
                <a href="./dl/MailSigner.exe" class="columButtonPos button blueButton">Download</a>
                <h3>Sign up for a 30 day trial (limited to 10 users) here:</h3>
            </div>
            
            <div class="grid_1">&nbsp;</div>

            <div class="grid_12 siteMap"><?php sitemap(); ?></div>
            
            <div class="grid_12">
                <?php copyright(); ?>
            </div>
        </div>
        <?php loginBox(); ?>
        <div id="successDialog" class="vertical">
            <div class="horizontal">
                <h3>Your account has been created!</h3>
                <div class="successDialogText">To activate your account, check your e-mail. Upon starting the
                software, enter your login-information you have just provided
                for the website. Note, a demo signup cannot be used to log in to the website.</div>
                <a href="#" class="button greenButton cancelButtonPos" id="okButton">OK</a>
            </div>
        </div>
        <script type="text/javascript">
            var email1;
            var email2;
            var password1;
            var password2;
            $(document).ready(function(){
                $('#userExists').hide();
                $('#emailCheck').hide();
                $('#emailMatch').hide();
                $('#passCheck').hide();
                $('#passMatch').hide();
            });
            $('#submit').click(function(){
                submitDetails();
            });
            $('#confirmButton').click(function(){
                orderConfirmation();
            });

            function submitDetails(){
                resetForm();
                loadData();
                $.get("demoSignup.php?" +
                    "&email1="+email1+
                    "&email2="+email2+
                    "&password1="+password1+
                    "&password2="+password2+
                    "&confirm=1", orderValidation);
            }

            function resetForm(){
                $('#userExists').hide();
                $('#emailCheck').hide();
                $('#emailMatch').hide();
                $('#passCheck').hide();
                $('#passMatch').hide();
            }

            function loadData(){
                email1 = $('#email1').val();
                email2 = $('#email2').val();
                password1 = $('#password1').val();
                password2 = $('#password2').val();
            }

            function orderValidation(data){
                if(data == 0){
                    $('#successDialog').show();
                } else {
                    if(data.charAt(0) == 1){
                        $('#userExists').show();
                    }
                    if(data.charAt(1) == 1){
                        $('#emailCheck').show();
                    }
                    if(data.charAt(2) == 1){
                        $('#emailMatch').show();
                    }
                    if(data.charAt(3) == 1){
                        $('#passCheck').show();
                    }
                    if(data.charAt(4) == 1){
                        $('#passMatch').show();
                    }
                }
            }
        </script>
        <script type="text/javascript">
            $('#okButton').click(function(){
                $('#successDialog').fadeOut(500);
            });
        </script>
        <?php include_once("analyticstracking.php") ?>
    </body>
</html>
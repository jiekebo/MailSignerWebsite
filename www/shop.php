<?php include('include.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <?php htmlHeader("MailSigner - The easy way to manage mail signatures, even without Active Directory and Outlook"); ?>
    <body id="shop">
        <div class="container_12">
            <div class="grid_4 logo"></div>
            <div class="grid_8">
                <?php nav(); ?>
            </div>
            <div class="grid_12 smallHeader"></div>
            <div class="grid_12 contents">
                <?php if($_SESSION['id']){?>
                    <div class="titleBackground shopColor">
                        <div class="titleImagePos shopIcon"></div>
                        <div class="titleTextPos">
                            <h1>Purchase Premium Signatures</h1>
                            <p>They are thouroughly tested, and will give your company a great image</p>
                        </div>
                    </div>
                    <div class="text">

                    </div>
                <?php } else { ?>
                    <div class="titleBackground shopColor">
                        <div class="titleImagePos shopIcon"></div>
                        <div class="titleTextPos">
                            <h1>Purchase MailSigner</h1>
                            <p>It will save you time</p>
                        </div>
                    </div>
                    <div class="text">
                        <ul style="margin-left: 14px; list-style-type:disc;">
                            <li>Here you can purchase a licence for using MailSigner.</li>
                            <li>The licence is valid for one year.</li>
                            <li>As long as the licence is valid you have <b>FREE, FULL</b> support.</li>
                            <li>In the form below, select the amount of users you would like, and enter your details.</li>
                            <li>By selecting users you will be able to see the price directly.</li>
                            <li>Please contact us if you need more than 500 users.</li>
                        </ul>
                        <br/>
                        <h1>1. Select amount of users</h1>
                        <div class="inputError" id="usersError">Please select amount of users</div>
                        <div style="padding: 20px !important; float: left;"><div style="width: 600px;" id="slider"></div></div>
                        <table style="text-align: right;">
                            <tr><td style="width:100px;"><label for="amount"><b>Users:</b></label></td><td style="padding-left: 5px; text-align: left;"><div id="value">0</div></td></tr>
                            <tr><td><b>Per user:</b></td><td style="padding-left: 5px; text-align: left;"><div id="unitPrice">0</div></td></tr>
                            <tr><td><b>Total:</b></td><td style="padding-left: 5px; text-align: left;"><div style="font: 14px Verdana; color: #FA0;" id="totalPrice">0</div></td></tr>
                        </table>
                        <script type="text/javascript">
                            var users = 0;
                            $('#slider').slider({range: "min", min: 1, max: 300});
                            $('#slider').slider({
                               slide: function(event, ui) {
                                   users = ui.value;
                                   $("#value").html(users);
                               },
                               stop: function(){
                                   $.get('priceCalculator.php?quantity='+users, updatePrice)
                                   function updatePrice(data){
                                       $('#unitPrice').html(data);
                                       $('#totalPrice').html(data * users);
                                   }
                               }
                            });
                        </script>
                        <br/>
                        <h1>2. Enter your details</h1>
                        <div style="position:relative; width:873px; height:210px; margin-top: 15px;">
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
                        </div>
                        <div class="formDivider">
                            <fieldset class="inputField">
                                <legend>Your details</legend>
                                <table>
                                    <tr><td class="label">Company</td><td><input id="company" type="text" name=""/></td></tr>
                                    <tr class="inputError" id="companyCheck"><td></td><td>Not a company name</td></tr>
                                    <tr><td class="label">First name</td><td><input id="fname" type="text" name=""/></td></tr>
                                    <tr class="inputError" id="fnameCheck"><td></td><td>Not a name</td></tr>
                                    <tr><td class="label">Last name</td><td><input id="lname" type="text" name=""/></td></tr>
                                    <tr class="inputError" id="lnameCheck"><td></td><td>Not a name</td></tr>
                                </table>
                            </fieldset>
                        </div>
                        <div class="formDivider">
                            <fieldset class="inputField">
                                <legend>Your address</legend>
                                <table>
                                    <tr><td class="label">Address</td><td><input id="address" type="text" name=""/></td></tr>
                                    <tr class="inputError" id="addressCheck"><td></td><td>Not an address</td></tr>
                                    <tr><td class="label">City</td><td><input id="city" type="text" name=""/></td></tr>
                                    <tr class="inputError" id="cityCheck"><td></td><td>Not a city</td></tr>
                                    <tr><td class="label">Postcode</td><td><input id="postcode" type="text" name=""/></td></tr>
                                    <tr class="inputError" id="postcodeCheck"><td></td><td>Not a postcode</td></tr>
                                    <tr><td class="label">Country</td><td><select id="country"><?php $query = mysql_query("SELECT * FROM Countries ORDER BY name"); while($row = mysql_fetch_array($query)){ echo "<option value='{$row['name']}'>{$row['name']}</option>"."\n";}?></select></td></tr>
                                </table>
                            </fieldset>
                        </div>
                        </div>
                        <a href="javascript:void(0);" class="button greenButton" id="submit" style="float: left; margin-bottom: 25px;">Submit</a>
                        <a href="javascript:void(0);" class="button redButton" id="confirmButton" style="float: left; margin-left: 30px;">Confirm</a>
                        <br/>
                        <script type="text/javascript">
                            var email1;
                            var email2;
                            var password1;
                            var password2;
                            var company;
                            var fname;
                            var lname;
                            var address;
                            var city;
                            var postcode;
                            var country;
                            $(document).ready(function(){
                                $('#usersError').hide();
                                $('#userExists').hide();
                                $('#emailCheck').hide();
                                $('#emailMatch').hide();
                                $('#passCheck').hide();
                                $('#passMatch').hide();
                                $('#companyCheck').hide();
                                $('#fnameCheck').hide();
                                $('#lnameCheck').hide();
                                $('#addressCheck').hide();
                                $('#cityCheck').hide();
                                $('#postcodeCheck').hide();
                                $('#confirmButton').hide();
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
                                $.get("orderMailsigner.php?" +
                                    "users="+users+
                                    "&email1="+email1+
                                    "&email2="+email2+
                                    "&password1="+password1+
                                    "&password2="+password2+
                                    "&company="+company+
                                    "&fname="+fname+
                                    "&lname="+lname+
                                    "&address="+address+
                                    "&city="+city+
                                    "&postcode="+postcode+
                                    "&country="+country, orderValidation);
                            }

                            function orderConfirmation(){
                                resetForm();
                                loadData();
                                $.get("orderMailsigner.php?" +
                                    "users="+users+
                                    "&email1="+email1+
                                    "&email2="+email2+
                                    "&password1="+password1+
                                    "&password2="+password2+
                                    "&company="+company+
                                    "&fname="+fname+
                                    "&lname="+lname+
                                    "&address="+address+
                                    "&city="+city+
                                    "&postcode="+postcode+
                                    "&country="+country+
                                    "&confirm=1",orderConfirmation);
                                function orderConfirmation(result){
                                    if(result == 0){
                                        $('#successTitle').html("Thank you for choosing MailSigner!");
                                        $('#successText').html("To activate your software, check your e-mail. Upon starting the software, enter the e-mail and password you have just provided for the website.");
                                        $('#successDialog').show();
                                    } else {
                                        orderValidation(result);
                                        $('#confirmButton').hide();
                                    }
                                }
                            }

                            function resetForm(){
                                $('#usersError').hide();
                                $('#userExists').hide();
                                $('#emailCheck').hide();
                                $('#emailMatch').hide();
                                $('#passCheck').hide();
                                $('#passMatch').hide();
                                $('#companyCheck').hide();
                                $('#fnameCheck').hide();
                                $('#lnameCheck').hide();
                                $('#addressCheck').hide();
                                $('#cityCheck').hide();
                                $('#postcodeCheck').hide();
                            }

                            function loadData(){
                                email1 = $('#email1').val();
                                email2 = $('#email2').val();
                                password1 = $('#password1').val();
                                password2 = $('#password2').val();
                                company = $('#company').val();
                                fname = $('#fname').val();
                                lname = $('#lname').val();
                                address = $('#address').val();
                                city = $('#city').val();
                                postcode = $('#postcode').val();
                                country = $('#country').val();
                            }

                            function orderValidation(data){
                                if(data == 0){
                                    $('#confirmButton').show();
                                    $('#successTitle').html("Please confirm");
                                    $('#successText').html("To complete your order, please confirm that your details are correct and that you have chosen the right amount of users.");
                                    $('#successDialog').show();
                                } else {
                                    if(data.charAt(0) == 1){
                                        $('#usersError').show();
                                    }
                                    if(data.charAt(1) == 1){
                                        $('#userExists').show();
                                    }
                                    if(data.charAt(2) == 1){
                                        $('#emailCheck').show();
                                    }
                                    if(data.charAt(3) == 1){
                                        $('#emailMatch').show();
                                    }
                                    if(data.charAt(4) == 1){
                                        $('#passCheck').show();
                                    }
                                    if(data.charAt(5) == 1){
                                        $('#passMatch').show();
                                    }
                                    if(data.charAt(6) == 1){
                                        $('#companyCheck').show();
                                    }
                                    if(data.charAt(7) == 1){
                                        $('#fnameCheck').show();
                                    }
                                    if(data.charAt(8) == 1){
                                        $('#lnameCheck').show();
                                    }
                                    if(data.charAt(9) == 1){
                                        $('#addressCheck').show();
                                    }
                                    if(data.charAt(10) == 1){
                                        $('#cityCheck').show();
                                    }
                                    if(data.charAt(11) == 1){
                                        $('#postcodeCheck').show();
                                    }
                                    if(data.charAt(12) == 1){
                                        // only needed if country isn't selected...
                                    }
                                    //alert(data + country);
                                }
                            }
                        </script>
                    </div>
                <?php } ?>
            </div>
            <div class="grid_12 siteMap"><?php sitemap(); ?></div>
            <div class="clear"></div>
            <div class="grid_12">
                <?php copyright(); ?>
            </div>
        </div>
        <?php loginBox(); ?>
        <div id="successDialog" class="vertical">
            <div class="horizontal">
                <h3 id="successTitle"></h3>
                <div id="successText" class="successDialogText"></div>
                <a href="javascript:void(0);" class="button greenButton cancelButtonPos" id="okButton">OK</a>
            </div>
        </div>
        <script type="text/javascript">
            $('#okButton').click(function(){
                $('#successDialog').fadeOut(500);
            });
        </script>
        <?php include_once("analyticstracking.php") ?>
    </body>
</html>
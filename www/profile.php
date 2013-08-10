<?php include('include.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <?php htmlHeader("MailSigner - The easy way to manage mail signatures, even without Active Directory and Outlook"); ?>
    <body id="contact">
        <div class="container_12">
            <div class="grid_4 logo"></div>
            <div class="grid_8">
                <?php nav(); ?>
            </div>
            <div class="grid_12 smallHeader"></div>
            <div class="grid_12 contents">
                <?php
                if($_SESSION['id']){
                ?>
                <div class="titleBackground shopColor">
                    <div class="titleImagePos shopIcon"></div>
                    <div class="titleTextPos">
                        <h1>Welcome to your profile,
                            <?php
                            if($_SESSION['id']){
                                $userData = query_list("SELECT * FROM `User` WHERE `idUser` = '{$_SESSION['id']}'");
                            }
                            echo $userData['2'] . " " . $userData['3']; ?></h1>
                        <p>Here you can view your personal data, change your password and review your invoices</p>
                    </div>
                </div>
                <div class="text">
                    <div class="box">
                        <div class="productImage"><img src="./img/UserInfo.png" alt=""/></div>
                        <table style="text-align: left;">
                            <thead>
                                <tr style="border-bottom: 1px solid #fff; font-size: 10pt;">
                                    <th colspan="2">Profile</th>
                                    <th colspan="2">Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th width="70px">Company</th><td width="120px"><?php echo $userData['1']; ?></td><th width="70px">Street</th><td><?php echo $userData['6']; ?></td>
                                </tr>
                                <tr>
                                    <th>User Name</th><td><?php echo $userData['2'] . " " . $userData['3']; ?></td><th>City</th><td><?php echo $userData['7']; ?></td>
                                </tr>
                                <tr>
                                    <th>E-Mail</th><td><?php echo $userData['4'] ?></td><th>Postcode</th><td><?php echo $userData['8']; ?></td>
                                </tr>
                                <tr>
                                    <th>Password</th><td><a class="passwordChange" href="javascript:void(0)">Change</a></td><th>Country</th><td><?php echo $userData['9']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <form class="passwordInput" action="javascript: void(0);" method="post">
                            <table>
                            <tr ><th class="label">Enter old password:</th><td class="data"><input id="oldPass" name="oldPass" type="password" maxlength="30"/></td></tr>
                            <tr ><th class="label">Enter new password:</th><td class="data"><input id="newPass" name="newPass" type="password" maxlength="30"/></td></tr>
                            <tr ><th class="label">Confirm new password:</th><td class="data"><input id="confirmPass" name="confirmPass" type="password" maxlength="30"/></td></tr>
                            <tr ><td colspan=2><input id="passwordSubmit" type="submit" value="Save"/></td></tr>
                            </table>
                        </form>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $(".passwordInput").hide();
                        });
                        $(".passwordChange").click(function(){
                            $(".passwordInput").slideToggle();
                        });
                        function changePassword(){
                            //something = $('#something').val();
                            oldPass = $('#oldPass').val();
                            newPass = $('#newPass').val();
                            confirmPass = $('#confirmPass').val();

                            $.get('loginChange?oldPass='+oldPass+'&newPass='+newPass+'&confirmPass='+confirmPass, changePassState);
                            function changePassState(data){
                                if(data == 3){
                                    $(".passwordInput").hide();
                                    alert("Changed yahiii!!");
                                } else if (data == 2) {
                                    alert("Not a password!");
                                } else if (data == 1) {
                                    alert("No match");
                                } else if (data == 0){
                                    alert("not old password");
                                }
                            }
                        }
                        $('#passwordSubmit').click(changePassword);
                    </script>
                    
                    <h2>Your purchases</h2>
                    <?php
                    $rightsTable = query_table("SELECT
                                                        `Product`.`productNumber`,
                                                        `Product`.`productName`,
                                                        `Product`.`description`,
                                                        `Product`.`imageLocation`,
                                                        `Product`.`productType`,
                                                        `pright`.`expires`,
                                                        `pright`.`quantity`
                                                FROM
                                                        (SELECT
                                                                `Order`.`active`,
                                                                `Order`.`expires`,
                                                                `OrderItem`.`productNumber`,
                                                                `OrderItem`.`quantity`
                                                        FROM `Order`
                                                        JOIN `OrderItem`
                                                        ON `Order`.`idOrder` = `OrderItem`.`idOrder`
                                                        WHERE `Order`.`idUser` = '{$_SESSION['id']}]') AS pright
                                                JOIN `Product`
                                                ON `pright`.`productNumber` = `Product`.`productNumber`
                                                WHERE `active` = 1");
                    foreach($rightsTable as $rightsLine){
                        ?>
                        <div class='box'>
                            <div class='productImage'><img alt="" src='<?php echo $rightsLine['imageLocation']; ?>'/></div>
                            <table style="text-align:left; width:250px;">
                                <thead>
                                    <tr>
                                        <th style="border-bottom: 1px solid #fff; font-size: 10pt;" colspan="2">ID: <?php echo $rightsLine['productNumber'] . " - Product: " . $rightsLine['productName']; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($rightsLine['productType']=='MailSigner'){
                                        ?>
                                            <tr>
                                                <td>Users</td>
                                                <td><?php echo $rightsLine['quantity']; ?></td>
                                            </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td>Description</td>
                                        <td><?php echo $rightsLine['description']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Expires</td>
                                        <td><?php echo $rightsLine['expires']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>

                    <h2>Your Invoices</h2>
                    <?php
                    $table = query_table("SELECT * FROM `Order` WHERE `idUser` = '{$_SESSION['id']}'");
                    foreach($table as $assocArray){
                        ($assocArray['active'] == 1)?
                            ($active = "<img src='img/tick.png'/>"):
                            ($active = "<img src='img/cross.png'/>");
                        $idOrder = $assocArray['idOrder'];
                        $address = $assocArray['address'];
                        $postcode = $assocArray['postcode'];
                        $city = $assocArray['city'];
                        $date = $assocArray['date'];
                        $dueDate = $assocArray['dueDate'];
                        // Write never if product doesn't expire
                        (strtotime($assocArray['expires']))?
                            ($expires = date('Y-m-d', strtotime($assocArray['expires']))):
                            ($expires = "Never");
                        $pdfLink = "<a style='position:relative; top: 10px; left: 5px;' href='createPDF.php?order={$assocArray['idOrder']}'><img src='img/page_white_lightning.png' /> Print PDF</a>";

                        $detailsTable = query_table("SELECT
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
                                                    WHERE `idOrder` = '{$assocArray['idOrder']}'");
                    ?>
                    <div class="box">
                        <table width='100%' class='headTable'>
                            <thead>
                                <tr>
                                    <th><?php echo $active; ?></th>
                                    <th>Order <?php echo $idOrder; ?></th>
                                    <th><?php echo $address . " " . $postcode . " " . $city; ?></th>
                                    <th>Placed <?php echo $date; ?></th>
                                    <th>Pay Due <?php echo $dueDate; ?></th>
                                    <th>Expires <?php echo $expires; ?></th>
                                </tr>
                            </thead>
                        </table>
                        <table class="lineTable">
                            <thead>
                                <tr>
                                    <th>Product or service</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($detailsTable as $detailsLine){
                                ?>
                                    <tr>
                                        <td><?php echo $detailsLine['productName']; ?></td>
                                        <td><?php echo $detailsLine['quantity']; ?></td>
                                        <td><?php echo $detailsLine['priceDKK']; ?></td>
                                        <td><?php echo $detailsLine['totalPriceDKK']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pdfLink"><a href='createPDF.php?order=<?php echo $assocArray['idOrder'];?>'><img alt="" style="margin-bottom: -2px;" src='img/page_white_lightning.png'/> Print PDF</a></div>
                    <?php
                    }
                    ?>
                </div>
                <?php } else { ?>
                <div class="titleBackground shopColor">
                    <div class="titleImagePos shopIcon"></div>
                    <div class="titleTextPos">
                        <h1>MailSigner Profile</h1>
                        <p>When you have purchased MailSigner, here is where you check your profile!</p>
                    </div>
                </div>
                <div class="text">
                    <h1>You need a login:</h1>
                    When you have purchased MailSigner (which can be done at <a href="shop">shop</a>), you will recieve a
                    login to this website. This login is also used to unlock the software after <a href="download">download</a>.
                    <p/>When you login to the website your information will be shown on this page. You can also review and
                    save your previous invoices from us directly from your profile page.
                    <div class="button greenButton" id="login">LOGIN</div>
                    <script type="text/javascript">
                        $("#login").click(function(){
                            $("#light").fadeIn(400);
                            $("#fade").fadeIn(1000);
                        });
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
        <?php include_once("analyticstracking.php") ?>
    </body>
</html>
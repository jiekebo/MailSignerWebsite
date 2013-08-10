<?php include('include.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <?php htmlHeader("MailSigner - The easy way to manage mail signatures, even without Active Directory and Outlook"); ?>
    <body id="support">
        <script type="text/javascript">
            $(function() {
		$( "#accordion" ).accordion({active:false});
            });
        </script>
        <div class="container_12">
            <div class="grid_4 logo"></div>
            <div class="grid_8">
                <?php nav(); ?>
            </div>
            <div class="grid_12 smallHeader"></div>
            <div class="grid_12 contents">
                <div class="titleBackground shopColor">
                    <div class="titleImagePos shopIcon"></div>
                    <div class="titleTextPos">
                        <h1>Support</h1>
                        <p>FREE support for MailSigner customers</p>
                    </div>
                </div>
                <div class="text">
                    <h1>Frequently Asked Questions</h1>
                    <br/>
                    <div id="accordion">
                        <h3><a href="#">First header</a></h3>
                        <div>First content</div>
                        <h3><a href="#">Second header</a></h3>
                        <div>Second content</div>
                    </div>
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
<?php include('include.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <?php htmlHeader("MailSigner - The easy way to manage your corporate identity"); ?>
    <body id="home">
        <div class="container_12">
            <div class="grid_4 logo"></div>
            <div class="grid_8">
                <?php nav(); ?>
            </div>
            <div class="grid_12 header"><img src="./img/ribbon.png" alt="" class="ribbon" width="222" height="223" usemap="#ribbonmap"/></div>
            <map id="ribbonmap" name="ribbonmap">
                <area shape="poly" coords="1,10,11,0,98,0,221,124,221,211,212,221,212,201,22,10," href="./download" alt="" title="MailSigner Trial"/>
            </map>
            <div class="c1">
                <h3>Management</h3>
                <div class="columnText">
                    MailSigner is a unique and efficient software which
                    assists you to create and distribute mail signatures
                    to multiple users.
                </div>
                <a href="./management" class="columButtonPos button blueButton">Read More</a>
            </div>
            <div class="c2">
                <h3>Creativity</h3>
                <div class="columnText">
                    Contains an interactive HTML-editor, so you can focus on
                    just designing the signature.
                </div>
                <a href="./creativity" class="columButtonPos button blueButton">Read More</a>
            </div>
            <div class="c3">
                <h3>Compatibility</h3>
                <div class="columnText">
                    MailSigner is compatible with most of the mail-clients
                    existing today, that being both web-based (eg. g-mail,
                    hotmail, yahoo mail, etc.) and local clients
                    (eg. outlook, thunderbird, lotus notes, etc.).
                </div>
                <a href="./compatibility" class="columButtonPos button blueButton">Read More</a>
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
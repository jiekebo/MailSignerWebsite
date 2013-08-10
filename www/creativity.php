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
            <div class="grid_12 contents">
                <div class="titleBackground shopColor">
                    <div class="titleImagePos shopIcon"></div>
                    <div class="titleTextPos">
                        <h1>Creativity</h1>
                        <p>Design with ease!</p>
                    </div>
                </div>
                <div class="text">
                    The consequence of a more globally connected world, is more
                    competition. It is now even more important than ever to have
                    yourself and your company's image standing out.
                    <p/>With MailSigner, this is an easy task. No need to know
                    HTML or CSS, the interactive editor will let you view the
                    result as you are creating it. Feel free to add your own
                    personal style, and let your image increase.
                    <p/>If you are not convinced, try our 30-day demo available
                    in the download section.
                    <img src="img/design.png" style="float:left; margin: 25px 0 25px 0;" width="873"/>
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
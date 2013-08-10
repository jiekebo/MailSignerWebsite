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
                        <h1>Compatibility</h1>
                        <p>Use any mail client</p>
                    </div>
                </div>
                <div class="text">
                    MailSigner is compatible with Microsoft Outlook, and can extract
                    user information from an Active Directory, e.g. the traditional
                    setup. But it doesn't stop there. MailSigner is also compatible
                    with all thinkable mail clients, since it allows you to manually
                    enter user information. A special client has been made for this
                    situation, which runs in the taskbar. By selecting the desired
                    signature from the icon's popup, the signature, complete with
                    the users personal details, will be placed on the clipboard of
                    the computer, ready to be placed in any application.
                    <p/>We have all met the situation whereupon recieving a mail it is
                    unreadable, because the design is messed up in the mail reader.
                    This is a common problem, and is caused by the difference in
                    how each mail reader handles the design. With MailSigner it
                    is easy to avoid this problem as it is rapid to test different
                    designs.

                    We all have met the problem that we could not reach our
                    clients because they use differents mail system, but not any
                    more. Mailsigner software has been tested in all the mail
                    system which exist nowtime, firefox,.....
                    <p/>With mailsigner, your information with be delieverd
                    derictly and exactly as it is to all your clients.

                    <div style="margin: 30px auto 30px auto; width: 750px; overflow: hidden;">
                        <img style="float:left;" width="150" src="img/clients/outlook.jpg"/>
                        <img style="float:left;" width="150" src="img/clients/notes.png"/>
                        <img style="float:left;" width="150" src="img/clients/thunderbird.jpg"/>
                        <img style="float:left;" width="150" src="img/clients/gmail.png"/>
                        <img style="float:left;" width="150" src="img/clients/yahoo.png"/>
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
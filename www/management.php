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
                        <h1>Management</h1>
                        <p>Easily create mail signatures, and maintain them for multiple users!</p>
                    </div>
                    
                </div>
                <div class="text">
                    In our experience, clients have a huge task managing their
                    mail system, especially when each employee must have an
                    individual signature.
                    <p/>First of all a lot of mail signatures will have to be
                    made manually, which contains a large amount of tedious and
                    error prone work, especially for companies with many
                    departments/employees.
                    <p/>Secondly it is very difficult to make any changes to
                    signatures, were they manually created. Imagine you would
                    want to change the company logo, or write a new slogan, then
                    you would have to go over all the employees signatures times
                    how many different signatures you have made for each employee
                    <p/>Based on these demands we developed MailSigner, to help you
                    effortlessly managa the whole company's mail signatures. No
                    hassle, just create and distribute from the easy to use control
                    panel. Afterwards everything is taken care of automatically.
                    <p/>If you don't believe in promises, take MailSigner for a spin
                    for 30 days by signing up for a demo version under in our download
                    section.
                </div>
                <div class="text">
                    <img style="padding-left: 83px;" src="./img/masterDiagram.png" alt=""/>
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
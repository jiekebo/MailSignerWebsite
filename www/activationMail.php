<?php
$html =
"<html>
    <head><title></title></head>
    <body bgcolor='#AAAABB'>
        <table width='792' cellspacing='0' cellpadding='0' border='0' bgcolor='#ffffff' align='center'>
            <tbody><tr>
                    <td width='16' bgcolor='#AAAABB'>
                        <img alt='' width='16' height='1' style='display: block;' src='http://mailsigner.com/img/mail/pixel.gif'>
                    </td>
                    <td>
                        <table width='760' cellspacing='0' cellpadding='0' border='0' align='center'>
                            <tr>
                                <td background='http://mailsigner.com/img/mail/title.png' bgcolor='FFAA00'>
                                    <table cellspacing='0' cellpadding='0' border='0'>
                                        <tr>
                                            <td colspan='4'><img alt='' width='1' height='40' style='display: block;' src='http://mailsigner.com/img/mail/pixel.gif'></td>
                                        </tr>
                                        <tr>
                                            <td><img alt='' width='50' height='1' style='display: block;' src='http://mailsigner.com/img/mail/pixel.gif'></td>
                                            <td><img alt='' src='http://mailsigner.com/img/wax.png'></td>
                                            <td><img alt='' width='10' height='1' style='display: block;' src='http://mailsigner.com/img/mail/pixel.gif'></td>
                                            <td>
                                                <font style='font-family:Arial,Verdana,sans-serif;color:#FFFFFF;font-size:30px;font-weight:bold; line-height: 1.5;font-variant: small-caps;'>MailSigner Activation</font><br/>
                                                <font style='font-family:Arial,Verdana,sans-serif;color:#FFFFFF;font-size:15px;font-style:italic;'>To enable your product, please click the link below</font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan='4'><img alt='' width='1' height='40' style='display: block;' src='http://mailsigner.com/img/mail/pixel.gif'></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table cellspacing='0' cellpadding='0' border='0'>
                                        <tr>
                                            <td><img alt='' width='32' height='1' style='display: block;' src='http://mailsigner.com/img/mail/pixel.gif'></td>
                                            <td>
                                                <font style='font-family: Arial,Verdana,Helvetica,sans-serif; font-size: 20px; color: rgb(0, 0, 0); font-weight: bold; line-height: 40px;'>Please Activate your Account</font>
                                                <br/>
                                                <font style='font-family: Arial,Verdana,Helvetica,sans-serif; font-size: 11px; color: rgb(0, 0, 0); font-weight: normal;'>The following link will allow you to activate your account. Please see attached pdf for order summary and payment details.</font>
                                                <br/>
                                                <br/><a target='_blank' style='font-family: Arial,Verdana,Helvetica,sans-serif; font-size: 11px; color: rgb(46, 148, 210); text-decoration: none; font-weight: bold;' href='http://www.mailsigner.com/activate.php?id=" . md5($idUser[0] . $cryptPass) . "&user={$idUser[0]}'>Activate &gt;</a>
                                                <br/>
                                                <br/><br/>
                                            </td>
                                            <td><img alt='' width='32' height='1' style='display: block;' src='http://mailsigner.com/img/mail/pixel.gif'></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table border='0' cellspacing='0' cellpadding='0' width='100%'>
                            <tbody>
                                <tr>
                                    <td width='33'>&nbsp;</td>
                                    <td width='90'><img alt='' src='http://www.mailsigner.com/img/stamp(mail).png' /></td>
                                    <td>
                                        <font style='font-size: 9px; font-family: Verdana;'><strong>With Best Regards:</strong><br />
                                            MailSigner &copy;<br />
                                            Kronetorpsgatan 70D<br/>
                                            21227 Malm&ouml;<br/>
                                            Sweden<br/>
                                            <a href='mailto:info@mailsigner.com'>info@mailsigner.com</a><br/>
                                            <a href='http://www.mailsigner.com'>www.mailsigner.com</a>
                                        </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='3'><img alt='' width='1' height='20' style='display: block;' src='http://mailsigner.com/img/mail/pixel.gif'></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan='2' style='font-weight: bold; font-size: 11px; color: rgb(146, 145, 145); font-family: Arial,Helvetica,sans-serif;'>
                                        <span style='font-size: 12px;'>&copy;</span> 2010 MailSigner. All rights reserved.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br/>
                    </td>
                    <td width='16' bgcolor='#AAAABB'>
                        <img alt='' width='16' height='1' style='display: block;' src='http://mailsigner.com/img/mail/pixel.gif'>
                    </td>
                </tr>
            </tbody></table>
    </body>
</html>";
?>
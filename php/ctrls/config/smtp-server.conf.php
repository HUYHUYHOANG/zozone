<?php
defined('SMTP_CONFIG_REQUIRED') or die('0opla');

$smtpData = array(
    'gmail' => array(   'host' => 'smtp.gmail.com', 
                        'secure' => 'ssl', /*'tls', */
                        'port' => 465, /*587, */
                        'uid' => 'demo.tnkas@gmail.com', 
                        'hash' => 'QwerT12345!@#$%', 
                        'rcptName'=>'Webmaster'
                    ),
    'myhost' => array(   'host' => 'mail.ihoapm.com', 
                    'secure' => 'ssl',
                    'port' => 465,
                    'uid' => 'wbmaster@ihoapm.com', 
                    'hash' => 'QwerT54321!@#$%', 
                    'rcptName'=>'Webmaster'
                )                  
);
?>
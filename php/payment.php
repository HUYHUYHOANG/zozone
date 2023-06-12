<?php
include('php/ctrls/lib/codec.lib.php');
include('php/ctrls/lib/request.lib.php');

$home = $config['site_url'] . get_current_shop();
$accessToken = CRequest::getStr('access_token');
if(!$accessToken) ++$error;

if(!$error){
    if(! isset($_SESSION[$accessToken])) ++$error;
    else $paymentData = (object)$_SESSION[$accessToken];
}

if(!$error && $paymentData){
    $cancel = CRequest::getStr('cancel');
    if($cancel=='true'){  
        //cancel reservation
        $sql = "UPDATE qr_reservations SET status=1 WHERE id={$paymentData->booking_id}";
        ORM::get_db()->prepare($sql)->execute();
        //clear data
        unset($_SESSION[$accessToken]);
        $home .= "/payment-result?" . $_SERVER['QUERY_STRING'];
        echo $home;die;
        header("Location:{$home}");        
        die;
    }

    $success = CRequest::getStr('success');
    if($success){
        $sql = "UPDATE qr_reservations SET payment_date=NOW() WHERE id={$paymentData->booking_id}";
        ORM::get_db()->prepare($sql)->execute();
        //clear data
        unset($_SESSION[$accessToken]);
        $home .= "/payment-result?" + $_SERVER['QUERY_STRING'];
        header("Location:{$home}");
        die;
    }
}

if($error){
    header("Location:{$home}");
    //error($lang['PAGE_NOT_FOUND'], __LINE__, __FILE__, 1);
    exit();
}

require(__DIR__.'/../includes/payments/PayPal-PHP-SDK/autoload.php');

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

$paymentLink = $link['PAYMENT'].'/?access_token='.$accessToken.'&cid='.$paymentData->cust_id.'&bid='.$paymentData->booking_id;
$returnUrl = $paymentLink . '&success=true';
$cancelUrl = $paymentLink . '&cancel=true';

/*$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AZix0kVwE-ohJ0Fsy9cjjfX0aWtkYgl3unzKF7uVrF6N1gY8CPvr4J8JDcnbMS1XB2S81dBHyzJnrJ4i',     // ClientID
        'EMT4sX7JEr5W_dt9zGmhh5M9DvU2vB-UvhjfeFcfkiicpcPMlqFC-J2D3dOVLvg8Fg87VIUuMkIRK204'      // ClientSecret
    )*/

$apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AUsb0KnOQHVAjXm14NK_z6Jcj0R61XwMkcMETo00OfYQWHOpCRF6mfxHnoLzQd1fiasBO728i-pMnkdi',     // ClientID
            'ECcmjygeJyyPdnIrk1Vo53mgIYKeyR6eaLJl-mmY4ndrgPmMLhtEpqgcKD36eW05krVe_Me8iaPD21EG'      // ClientSecret
        )
);

$apiContext->setConfig(array('mode' => 'sandbox'));

$payer = new Payer();
$payer->setPaymentMethod('paypal');

$amount = new Amount();
$amount->setCurrency("EUR")->setTotal($paymentData->amount);
    

$transaction = new Transaction();
$transaction->setAmount($amount);

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl($returnUrl)->setCancelUrl($cancelUrl);

$payment = new Payment();
$payment->setIntent('order')->setPayer($payer)->setTransactions(array($transaction))->setRedirectUrls($redirectUrls);

try {
    $payment->create($apiContext);
    header("Location:".$payment->getApprovalLink());
}
catch (\PayPal\Exception\PayPalConnectionException $ex) {
    payment_error("error", $exception->getMessage(), $accessToken);
}

?>

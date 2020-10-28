<?php
include 'config.php';
$idpardakht=$_GET['code'];

$loginclass = new rootview();
$price=(int)$loginclass->Get_price($idpardakht);

$MerchantID = 'a9ab57b2-3f4a-11e8-a231-005056a205be';
$Amount = $price;
$Description = 'فاکتور پرداخت برای محصولات';
$CallbackURL = 'https://homeandroid.ir';


$client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

$result = $client->PaymentRequest(
    [
        'MerchantID' => $MerchantID,
        'Amount' => $Amount,
        'Description' => $Description,
        'CallbackURL' => $CallbackURL,
    ]
);
if ($result->Status == 100) {
    $loginclass->Get_order_update($result->Authority,$idpardakht);
    Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority);

} else {
    echo'ERR: '.$result->Status;
}
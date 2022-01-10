<?php

namespace App\Http\Controllers;

use Kopokopo\SDK\K2;
use App\Kopokopo;
use Illuminate\Http\Request;

class KopokopoController extends Controller
{  
    public function __construct()
    {
        $K2 = new K2($options);
        $router = new AltoRouter();
        $options = [
    'clientId' => env('K2_CLIENT_ID'),
    'clientSecret' => env('K2_CLIENT_SECRET'),
    'apiKey' => env('K2_API_KEY'),
    'baseUrl' => env('K2_BASE_URL')

                    ];
    }


// $tokens = $K2->TokenService();
// $response = $tokens->getToken();

// $access_token = $response['access_token'];

// map homepage


public function token(){

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];


    echo json_encode($response);
}

public function revoke(){
$router->map('GET', '/revoketoken', function () {
    global $K2;

    $tokens = $K2->TokenService();
    $tokenResponse = $tokens->getToken();

    $access_token = $tokenResponse['data']['accessToken'];

    $response = $tokens->revokeToken(['accessToken' => $access_token]);
    echo json_encode($response);
});
}

public function infotoken(){
$router->map('GET', '/infotoken', function () {
    global $K2;

    $tokens = $K2->TokenService();
    $tokenResponse = $tokens->getToken();

    $access_token = $tokenResponse['data']['accessToken'];

    $response = $tokens->infoToken(['accessToken' => $access_token]);
    echo json_encode($response);
});
}
public function introspectoken()
{
$router->map('GET', '/introspecttoken', function () {
    global $K2;

    $tokens = $K2->TokenService();
    $tokenResponse = $tokens->getToken();

    $access_token = $tokenResponse['data']['accessToken'];

    $response = $tokens->introspectToken(['accessToken' => $access_token]);
    echo json_encode($response);
});
}

public function subscribe()
{
$router->map('POST', '/webhook/subscribe', function () {
    global $K2;

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    // echo json_encode($response);
    // echo json_encode($response['data']);
    // echo json_encode($response['data']['accessToken']);

    $access_token = $response['data']['accessToken'];

    // echo $access_token;

    $webhooks = $K2->Webhooks();

    $options = array(
        'eventType' => $_POST['eventType'],
        'url' => $_POST['url'],
        'scope' => $_POST['scope'],
        'scopeReference' => $_POST['scope_ref'],
        'accessToken' => $access_token,
    );
    $response = $webhooks->subscribe($options);

    echo json_encode($response);
});
}

public function stk ()
{
$router->map('POST', '/stk', function () {
    global $K2;
    $stk = $K2->StkService();

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];

    $options = [
        'paymentChannel' => 'M-PESA STK Push',
        'tillNumber' => '5984843',
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'phoneNumber' => $_POST['phoneNumber'],
        'amount' => $_POST['amount'],
        'currency' => 'KES',
        'email' => 'example@example.com',
        'callbackUrl' => 'https://4773626d5d5c.ngrok.io/webhook',
        'accessToken' => $access_token,
    ];
    $response = $stk->initiateIncomingPayment($options);

    echo json_encode($response);
});
}

public function polling()
{
$router->map('POST', '/polling', function () {
    global $K2;
    $polling = $K2->PollingService();

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];

    $options = [
        'fromTime' => $_POST['from_time'],
        'toTime' => $_POST['to_time'],
        'scope' => $_POST['scope'],
        'scopeReference' => $_POST['scope_ref'],
        'callbackUrl' => 'https://8ad50a368ffa.ngrok.io/webhook',
        'accessToken' => $access_token,
    ];
    $response = $polling->pollTransactions($options);

    echo json_encode($response);
});
}

public function smsnotification()
{
$router->map('POST', '/smsnotification', function () {
    global $K2;
    $sms_notification = $K2->SmsNotificationService();

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];

    $options = [
        'message' => $_POST['message'],
        'webhookEventReference' => $_POST['webhookEventReference'],
        'callbackUrl' => 'https://8ad50a368ffa.ngrok.io/webhook',
        'accessToken' => $access_token,
    ];
    $response = $sms_notification->sendTransactionSmsNotification($options);

    echo json_encode($response);
});
}

public function merchantwalllet()
{
$router->map('POST', '/merchantwallet', function () {
    global $K2;
    $transfer = $K2->SettlementTransferService();

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];

    $options = [
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'phoneNumber' => $_POST['phoneNumber'],
        'network' => $_POST['network'],
        'accessToken' => $access_token,
    ];
    $response = $transfer->createMerchantWallet($options);

    echo json_encode($response);
});
}
public function merchantbanckaccnt()
{
$router->map('POST', '/merchantbankaccount', function () {
    global $K2;
    $transfer = $K2->SettlementTransferService();

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];

    $options = [
        'bankBranchRef' => $_POST['bankBranchRef'],
        'accountName' => $_POST['accountName'],
        'accountNumber' => $_POST['accountNumber'],
        'settlementMethod' => $_POST['settlementMethod'],
        'accessToken' => $access_token,
    ];
    $response = $transfer->createMerchantBankAccount($options);

    echo json_encode($response);
});
}

public function transfer()
{
$router->map('POST', '/transfer', function () {
    global $K2;
    $transfer = $K2->SettlementTransferService();

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];

    $options = [
        'amount' => $_POST['amount'],
        'currency' => 'KES',
        'destinationReference' => $_POST['destinationReference'],
        'destinationType' => $_POST['destinationType'],
        'callbackUrl' => 'https://4773626d5d5c.ngrok.io/webhook',
        'accessToken' => $access_token,
    ];
    $response = $transfer->settleFunds($options);

    echo json_encode($response);
});
}
public function paymobilereceipient()
{
$router->map('POST', '/paymobilerecipient', function () {
    global $K2;
    $transfer = $K2->PayService();

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];

    $options = [
        'type' => 'mobile_wallet',
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'phoneNumber' => $_POST['phoneNumber'],
        'network' => $_POST['network'],
        'accessToken' => $access_token,
    ];
    $response = $transfer->addPayRecipient($options);

    echo json_encode($response);
});
}

public function paybankreceipt()
{
$router->map('POST', '/paybankrecipient', function () {
    global $K2;
    $transfer = $K2->PayService();

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];

    $options = [
        'type' => 'bank_account',
        'bankBranchRef' => $_POST['bankBranchRef'],
        'accountName' => $_POST['accountName'],
        'accountNumber' => $_POST['accountNumber'],
        'settlementMethod' => $_POST['settlementMethod'],
        'accessToken' => $access_token,
    ];
    $response = $transfer->addPayRecipient($options);

    echo json_encode($response);
});
}
public function paytillreceipt()
{
$router->map('POST', '/paytillrecipient', function () {
    global $K2;
    $transfer = $K2->PayService();

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];

    $options = [
        'type' => 'till',
        'tillName' => $_POST['tillName'],
        'tillNumber' => $_POST['tillNumber'],
        'accessToken' => $access_token,
    ];
    $response = $transfer->addPayRecipient($options);

    echo json_encode($response);
});
}

public function paymerchantreceipt()
{
$router->map('POST', '/paymerchantrecipient', function () {
    global $K2;
    $transfer = $K2->PayService();

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];

    $options = [
        'type' => 'kopo_kopo_merchant',
        'aliasName' => $_POST['aliasName'],
        'tillNumber' => $_POST['tillNumber'],
        'accessToken' => $access_token,
    ];
    $response = $transfer->addPayRecipient($options);

    echo json_encode($response);
});
}
public function pay()
{
$router->map('POST', '/pay', function () {
    global $K2;
    $pay = $K2->PayService();

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];

    $options = [
        'destinationType' => $_POST['destinationType'],
        'destinationReference' => $_POST['destinationReference'],
        'amount' => $_POST['amount'],
        'currency' => 'KES',
        'accessToken' => $access_token,
        'callbackUrl' => 'https://4773626d5d5c.ngrok.io/webhook',
    ];
    $response = $pay->sendPay($options);

    echo json_encode($response);
});
}
public function webhook()
{
$router->map('POST', '/webhook', function () {
    global $K2;
    global $response;

    $webhooks = $K2->Webhooks();

    $json_str = file_get_contents('php://input');

    $response = $webhooks->webhookHandler($json_str, $_SERVER['HTTP_X_KOPOKOPO_SIGNATURE']);

    echo json_encode($response);
    // print("POST Details: " .$json_str);
    // print_r($json_str);
});
}
public function status()
{
$router->map('POST', '/status', function () {
    global $K2;

    $tokens = $K2->TokenService();
    $response = $tokens->getToken();

    $access_token = $response['data']['accessToken'];

    $webhooks = $K2->Webhooks();

    $options = array(
        'location' => $_POST['location'],
        'accessToken' => $access_token,
    );
    $response = $webhooks->getStatus($options);

    echo json_encode($response);
});
}
public function resourses()
{
$router->map('GET', '/webhook/resource', function () {
    global $response;
    echo $response;
    echo $response;
});

$match = $router->match();
if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
}
}
}
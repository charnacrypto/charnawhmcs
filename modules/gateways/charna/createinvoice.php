<?php
include("../../../init.php"); 
include("../../../includes/functions.php");
include("../../../includes/gatewayfunctions.php");
include("../../../includes/invoicefunctions.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$gatewaymodule = "charna";
$GATEWAY = getGatewayVariables($gatewaymodule);
if(!$GATEWAY["type"]) die("Module not activated");
require_once('library.php');

$link = $GATEWAY['daemon_host'].":".$GATEWAY['daemon_port']."/json_rpc";


function monero_payment_id(){
    if(!isset($_COOKIE['payment_id'])) { 
		$payment_id  = bin2hex(openssl_random_pseudo_bytes(8));
		setcookie('payment_id', $payment_id, time()+2700);
	} else {
		$payment_id = $_COOKIE['payment_id'];
    }
		return $payment_id;
	
}

$monero_daemon = new Charna_rpc($link);

$message = "Waiting for your payment.";
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$currency = stripslashes($_POST['currency']);
$amount_chrc = stripslashes($_POST['amount_chrc']);
$amount = stripslashes($_POST['amount']);
$payment_id = charna_payment_id();
$invoice_id = stripslashes($_POST['invoice_id']);
$array_integrated_address = $monero_daemon->make_integrated_address($payment_id);
$address = $array_integrated_address['integrated_address'];
$uri  =  "charna:$address?amount=$amount_chrc";

$secretKey = $GATEWAY['secretkey'];
$hash = md5($invoice_id . $payment_id . $amount_chrc . $secretKey);
echo " <link href='http://cdn.monerointegrations.com/style.css' rel='stylesheet'>";
echo  "<script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>";
echo "<title>Invoice</title>";
echo "
        <head>
        <!--Import Google Icon Font-->
        <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,800' rel='stylesheet'>
       
        <!--Let browser know website is optimized for mobile-->
            <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
            </head>
            <body>
            <!-- page container  -->
            <div class='page-container'>
	    <div class='alert alert-warning' id='message'>".$message."</div>;
            <!-- charna container payment box -->
            <div class='container-chrc-payment'>
            <!-- header -->
            <div class='header-chrc-payment'>
            <span class='logo-chrc'><img src='https://charnacoin.com/assets/images/charnacoin.png' /></span>
            <span class='chrc-payment-text-header'><h2>CharnaCoin Payment</h2></span>
            </div>
            <!-- end header -->
            <!-- chrc content box -->
            <div class='content-chrc-payment'>
            <div class='chrc-amount-send'>
            <span class='chrc-label'>Send:</span>
            <div class='chrc-amount-box'>".$amount_chrc."</div><div class='chrc-box'>CHRC</div>
            </div>
            <div class='chrc-address'>
            <span class='chrc-label'>To this address:</span>
            <div class='chrc-address-box'>". $array_integrated_address['integrated_address']."</div>
            </div>
            <div class='chrc-qr-code'>
            <span class='chrc-label'>Or scan QR:</span>
            <div class='chrc-qr-code-box'><img src='https://api.qrserver.com/v1/create-qr-code/? size=200x200&data=".$uri."' /></div>
            </div>
            <div class='clear'></div>
            </div>
            <!-- end content box -->
            <!-- footer chrc payment -->
            <div class='footer-chrc-payment'>
            <a href='https://charnacoin.com/' target='_blank'>About Charnacoin</a>
            </div>
            <!-- end footer chrc payment -->
            </div>
            <!-- end charna container payment box -->
            </div>
            <!-- end page container  -->
            </body>
        ";
	    

echo "<script> function verify(){ 

$.ajax({ url : 'verify.php',
	type : 'POST',
	data: { 'amount_chrc' : '".$amount_chrc."', 'payment_id' : '".$payment_id."', 'invoice_id' : '".$invoice_id."', 'amount' : '".$amount."', 'hash' : '".$hash."', 'currency' : '".$currency."'}, 
	success: function(msg) {
		console.log(msg);
		$('#message').text(msg);
		if(msg=='Payment has been received.') {
			//redirect to Paid invoice
            window.location.href = '/viewinvoice.php?id=$invoice_id';
		}
	},									
   error: function (req, status, err) {
        $('#message').text(err);
        console.log('Something went wrong', status, err);
        
    }
	
			}); 
} 
verify();
setInterval(function(){ verify()}, 5000);
</script>";
?>


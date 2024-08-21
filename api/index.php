<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

if (empty($_REQUEST['debug'])) header('content-type: application/json; charset=utf-8');

set_time_limit(20);
date_default_timezone_set('America/Sao_Paulo');

if (!empty($_REQUEST['debug'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

include __DIR__ . "/Lead.php";
include __DIR__ . "/SendMail.php";

$next = true;
$message = "Lead adicionado com sucesso!";
$status = false;

$emailRafael = "rafael@rscontabilizando.cnt.br";
$name = $_REQUEST["name"] ?? "";
$phone = $_REQUEST["phone"] ?? "";

if (strlen($name) > 7) {
    $next = false;
    $message = "Infornme um nome";
}

if (strlen($phone) > 7) {
    $next = false;
    $message = "Informe o telefone";
}


$lead = new Lead( __DIR__ . "/../leads.csv" );

$subject = "Novo Lead";
$body = "";
$body .= "Olá \r\n";
$body .= "O lead de nome {$name} e telefone {$phone} acabou de se cadastrar \r\n";
$body .= "para baixar todos ja cadastrados \r\n";
$body .= "https://legalizefacil.com/leads.csv \r\n";

if($next ) {
    $lead->save($name, $phone);
    $status = SendMail::go($emailRafael, $subject, $body );
}

echo json_encode([
    "next" => $next,
    "message" => $message,
    "payload" => [
        "status" => $status,
        "to" => $emailRafael,
        "subject" => $subject,
        "body" => $body
    ]
]);

<?php
require_once 'core/init.php';
$db = DB::getInstance();

$data = $db->query('SELECT * FROM users');

//print_r($data->results());

foreach ($data->results() as $result) {

	$url = $_SERVER['HTTP_HOST'].'/phoneOOP/confirm.php?un=' . $result->username . '&ch='.$result->confirm_hash;

    $message = '<html><body>';
    $message.= 'hello ' . $result->full_name ;
    $message.= '<p welcome to Telephone Book </p>';
    $message.= '<p>pleas Confirm Your Email by Click on the link</p>';
    $message.= '<p><a target="_blank" href="' . $url . '">Confirm Email</a></p>';
    $message.= '<p color="red">Real email</p>';
    $message.= '<p color="blue">Soory for old Emails</p>';
    $message.= '</body></html>';
    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";


    Mail::send($result->Email,'Telephone Book | Confirm Email',$message,$headers);
}
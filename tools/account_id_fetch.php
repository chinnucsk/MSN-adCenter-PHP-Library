<?php

require_once('../v7/msnadcenter.class.php');

$xmlns = 'https://adcenter.microsoft.com/api/customermanagement';
$service_url = 'https://sharedservices.adcenterapi.microsoft.com/Api';

//change these values
$app_token = 'XXXXXXXXX';
$dev_token = 'XXXXXXXXX';
$username = 'XXXXXXXXX';
$password = 'XXXXXXXXX';


$headers[] = new SoapHeader($xmlns, 'ApplicationToken', $app_token, false);
$headers[] = new SoapHeader($xmlns, 'DeveloperToken', $dev_token, false);
$headers[] = new SoapHeader($xmlns, 'UserName', $username, false);
$headers[] = new SoapHeader($xmlns, 'Password', $password, false);



$svc = $service_url . '/CustomerManagement/v7/CustomerManagementService.svc';
$client = new SoapClient($svc . '?wsdl', Array('trace' => true, 'location' => $svc));

$api = new MSNAdCenter();
$api->setUp(true, 'cli', $client, $headers);
$api->MSNCustomers = new MSNCustomers();

print_r($api->MSNCustomers->getAccountsInfo($auth['customer_id']));

?>

What is it?
===========

An easy to use PHP SOAP client for MSN AdCenter.

Who is this for?
================

Any developer or company looking to integrate with the MSN adCenter API using PHP.

What are some features?
=======================

The MSN adCenter API is filled with strange nuances that make it difficult to integrate in PHP (especially on Linux). This client library makes sure that you can stably connect and work with the adCenter API. We figure an open source project will be the best way to stay on top of new changes and continue to make this library more stable.

This library currently supports CampaignManagement and ReportingService requests. HOWEVER, it is very much a work in progress. The adCenter API is hands down the most bug ridden, conflicting documentation pile of SOAP excrement you will ever come across or attempt to integrate. There are many points where we had to trial and error the correct methods, parameters, etc because the documentation is incorrect. Hopefully, this API will give you a good starting point in PHP, but it is by no means complete at this point.

VERSION NOTE
============

This library currently supports v7 of the adCenter API. You will see a folder for v8 in the repo, but that version is not fully ready yet (in part, because MSN/Bing/Whatever still hasn't released a sandbox for v8 so all development has to be done in production).

Example Uses
============

CampaignManagement Operations
-----------------------------

```php
<?php
require('v7/msnadcenter.class.php');
$api = new MSNAdCenter();

$service_url = 'https://adcenterapi.microsoft.com/Api/Advertiser/v7/';

$headers = Array(
    new SoapHeader($this->xmlns, 'ApplicationToken', 'XXXXXXXXX', false),
    new SoapHeader($this->xmlns, 'DeveloperToken', 'XXXXXXXXX', false), //set this to whatever you set ApplicationToken to
    new SoapHeader($this->xmlns, 'UserName', 'XXXXXXXXX', false),
    new SoapHeader($this->xmlns, 'Password', 'XXXXXXXXX', false),
    new SoapHeader($this->xmlns, 'CustomerAccountId', '12345678', false),
    new SoapHeader($this->xmlns, 'CustomerId', '2345678', false)
);

$svc = $this->service_url . '/CampaignManagement/CampaignManagementService.svc';
$client = new SoapClient($svc . '?wsdl', Array('trace' => true, 'location' => $svc));

$api->setUp(true, 'cli', $client, $headers);
$api->MSNCampaigns = new MSNCampaigns();
$api->MSNAdGroups = new MSNAdGroups();
$api->MSNAds = new MSNAds();
$api->MSNKeywords = new MSNKeywords();
$api->MSNTargets = new MSNTargets();

//get campaigns
$campaigns = Array();
$campaigns = $api->MSNCampaigns->getByAccountId('Customer Account Id Here (i.e. 12345678)');

foreach ($campaigns as $campaign) {
    //get adgroups
    $adgroups = Array();
    $adgroups = $api->MSNAdGroups->getByCampaignId($campaign['Id']);

    foreach ($adgroups as $adgroup) {
        //get ads
        $ads = Array();
        $ads = $api->MSNAds->getByAdGroupId($adgroup['Id']);

        //get keywords
        $keywords = Array();
        $keywords = $api->MSNKeywords->getByAdGroupId($adgroup['Id']);
    }
}

?>
```

ReportingService Operations
-----------------------------

```php
<?php
require('v7/msnadcenter.class.php');
$api = new MSNAdCenter();

$service_url = 'https://adcenterapi.microsoft.com/Api/Advertiser/v7/';

$headers = Array(
    new SoapHeader($this->xmlns, 'ApplicationToken', 'XXXXXXXXX', false),
    new SoapHeader($this->xmlns, 'DeveloperToken', 'XXXXXXXXX', false), //set this to whatever you set ApplicationToken to
    new SoapHeader($this->xmlns, 'UserName', 'XXXXXXXXX', false),
    new SoapHeader($this->xmlns, 'Password', 'XXXXXXXXX', false),
    new SoapHeader($this->xmlns, 'CustomerAccountId', '12345678', false),
    new SoapHeader($this->xmlns, 'CustomerId', '2345678', false)
);

$svc = $this->service_url . "/Reporting/ReportingService.svc";
$client = new SOAPClient($svc . '?wsdl', array('trace' => true, 'location' => $svc));
$api->setUp(true, 'cli', $client, $headers);
$api->MSNReport = new MSNReport();

$start_date = '2012-09-20';
$end_date = '2012-09-25';

//download a report
$columns = Array(
    'TimePeriod',
    'CampaignId',
    'AdGroupId',
    'AdId',
    'KeywordId',
    'Impressions',
    'Clicks',
    'Spend',
    'AveragePosition'
);

$timeStruct = $api->MSNReport->genTimeStruct('Custom date range', Array('from' => $start_date, 'to' => $end_date));
$name = 'KeywordPerformanceReport-' . mt_rand();
$scope = Array('AccountIds' => Array('Customer Account Id Here (i.e. 12345678)'));
$report_id = $api->MSNReport->submitKeywordPerformanceReport($name, 'Daily', $scope, $timeStruct, $columns);
print "Report ID: $report_id\n";
$status = 'Pending';
$times = 0;
while ($status == 'Pending') {
    sleep(round(30 * (1 + ($times / 10))));
    $req = $api->MSNReport->getReport($report_id);
    $status = $req->ReportRequestStatus->Status;
    print "Status: " . $status . "\n";
    $times++;
    if ($times > 100) {
        die("ERROR: Report ID: $report_id is stuck in a hung pending state\n");
    }
}

if ($status == 'Success') {
    $download_url = $req->ReportRequestStatus->ReportDownloadUrl;
    print "Download URL: $download_url\n";

    //NOTE: the reports are downloaded in zip format. You will need to uncompress them to get at the XML report returned.
    //The XML report will be $report_id.xml inside the zip archive
}

?>
```

Can I help with development?
============================

Absolutely! We would love to get any developers involved in the project that want to be involved. In addition, we are always looking for great PHP developers to come aboard our team at Envoy Media Group. If you think you have what it takes, please contact us!
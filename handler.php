<?php
include 'src/ApiFacade.php';
include 'src/ApiNytimes.php';
include 'src/Exceptions/ApiNytimesException.php';

$query = isset($_GET['q']) ? $_GET['q'] : '';

if (empty($query)) {
    $return = [
        'status' => 'error',
        'data' => 'Empty query'
    ];
    echo json_encode($return);
    exit();
}


$clientNYT = new ApiNytimes('https://api.nytimes.com/', 'f938d8e859ca47a48633c20050e112f6');
$clientApi = new ApiFacade($clientNYT);
$return = $clientApi->articleSearch($query);


echo json_encode($return);
exit();



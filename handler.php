<?php
include 'src/ApiFacade.php';
include 'src/ApiNytimes.php';
include 'src/Exceptions/ApiNytimesException.php';
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 28.11.2018
 * Time: 0:35
 */
$query = $_GET['q'] ?? '';

if (empty($query)) {
    $return = [
        'status' => 'error',
        'data' => 'Empty query'
    ];
    echo json_encode($return);
    exit();
}

$memcache = new Memcache;
$memcache->connect('127.0.0.1', 11211) or die ("Could not connect");

$return = $memcache->get(mb_strtolower($query));
if ($return === false) {
    $clientNYT = new ApiNytimes('https://api.nytimes.com/', 'f938d8e859ca47a48633c20050e112f6');
    $clientApi = new ApiFacade($clientNYT);
    $return = $clientApi->articleSearch($query);
    $memcache->set(mb_strtolower($query), $return, false, 15 * 60) or die ("Ошибка при сохранении данных на сервере");
}

echo json_encode($return);
exit();



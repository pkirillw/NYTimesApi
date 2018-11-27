<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 28.11.2018
 * Time: 0:25
 */

class ApiFacade
{
    private $api;

    public function __construct(ApiNytimes $apiNytimes)
    {
        $this->api = $apiNytimes;
    }

    public function articleSearch($q)
    {
        $params = [
            'q' => $q,
            'sort' => 'newest'
        ];
       return $this->api->call('svc/search/v2/articlesearch.json', $params, 'GET');
    }

}
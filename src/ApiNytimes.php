<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 27.11.2018
 * Time: 23:41
 */

class ApiNytimes
{
    private $baseUri;
    private $apiKey;

    public function __construct($baseUri, $apiKey)
    {
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $url
     * @param array $data
     * @param string $type
     * @return array
     * @throws ApiNytimesException
     */
    public function call($url, $data, $type)
    {

        $data['api-key'] = $this->apiKey;
        $url = $this->baseUri . $url;

        if (!empty($data) && $type == 'GET') {
            $url .= '?' . http_build_query($data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);

        if (!empty($data) && $type == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $out = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $out = json_decode($out, true);
        curl_close($curl);
        if ($httpcode !== 200) {
            if (isset($out['message'])) {
                $message = $out['message'];
            } else {
                $message = 'Empty output';
            }
            throw new ApiNytimesException($message, $url, $httpcode);

        }
        return $out;
    }

    /**
     * @return mixed
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @param mixed $baseUri
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }
}
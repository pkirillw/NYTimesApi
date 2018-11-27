<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 28.11.2018
 * Time: 0:48
 */

class ApiNytimesException extends \Exception
{
    private $url;

    public function __construct($message, $url, $code = 0, Exception $previous = null)
    {
        $this->setUrl($url);
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
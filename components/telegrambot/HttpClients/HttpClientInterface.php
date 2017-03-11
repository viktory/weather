<?php

namespace app\components\telegrambot\HttpClients;

/**
 * Interface HttpClientInterface
 * @package app\components\telegrambot\HttpClients
 */
interface HttpClientInterface
{
    /**
     * @param            $url
     * @param            $method
     * @param array      $headers
     * @param array      $options
     * @param int        $timeOut
     * @param bool|false $isAsyncRequest
     * @param int        $connectTimeOut
     *
     * @return mixed
     */
    public function send(
        $url,
        $method,
        array $headers = [],
        array $options = [],
        $timeOut = 30,
        $isAsyncRequest = false,
        $connectTimeOut = 10
    );
}

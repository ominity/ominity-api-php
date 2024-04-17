<?php

namespace Ominity\Api\HttpAdapter;

interface HttpAdapterPickerInterface
{
    /**
     * @param \GuzzleHttp\ClientInterface|\Ominity\Api\HttpAdapter\HttpAdapterInterface $httpClient
     *
     * @return \Ominity\Api\HttpAdapter\HttpAdapterInterface
     */
    public function pickHttpAdapter($httpClient);
}
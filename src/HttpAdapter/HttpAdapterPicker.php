<?php

namespace Ominity\Api\HttpAdapter;

use Ominity\Api\Exceptions\UnrecognizedClientException;

class HttpAdapterPicker implements HttpAdapterPickerInterface
{
    /**
     * @param \GuzzleHttp\ClientInterface|\Ominity\Api\HttpAdapter\HttpAdapterInterface|null|\stdClass $httpClient
     *
     * @return \Ominity\Api\HttpAdapter\HttpAdapterInterface
     * @throws \Ominity\Api\Exceptions\UnrecognizedClientException
     */
    public function pickHttpAdapter($httpClient)
    {
        if (! $httpClient) {
            if ($this->guzzleIsDetected()) {
                $guzzleVersion = $this->guzzleMajorVersionNumber();

                if ($guzzleVersion && in_array($guzzleVersion, [6, 7])) {
                    return Guzzle6And7HttpAdapter::createDefault();
                }
            }

            return new CurlHttpAdapter;
        }

        if ($httpClient instanceof HttpAdapterInterface) {
            return $httpClient;
        }

        if ($httpClient instanceof \GuzzleHttp\ClientInterface) {
            return new Guzzle6And7HttpAdapter($httpClient);
        }

        throw new UnrecognizedClientException('The provided http client or adapter was not recognized.');
    }

    /**
     * @return bool
     */
    private function guzzleIsDetected()
    {
        return interface_exists('\\' . \GuzzleHttp\ClientInterface::class);
    }

    /**
     * @return int|null
     */
    private function guzzleMajorVersionNumber()
    {
        // Guzzle 7
        if (defined('\GuzzleHttp\ClientInterface::MAJOR_VERSION')) {
            return (int) \GuzzleHttp\ClientInterface::MAJOR_VERSION;
        }

        // Before Guzzle 7
        if (defined('\GuzzleHttp\ClientInterface::VERSION')) {
            return (int) \GuzzleHttp\ClientInterface::VERSION[0];
        }

        return null;
    }
}
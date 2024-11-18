<?php

namespace Ominity\Api;

use Ominity\Api\Endpoints\Cms\CmsEndpointCollection;
use Ominity\Api\Endpoints\Commerce\CommerceEndpointCollection;
use Ominity\Api\Endpoints\Modules\ModulesEndpointCollection;
use Ominity\Api\Endpoints\Settings\SettingsEndpointCollection;
use Ominity\Api\Endpoints\Users\UserEndpoint;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Exceptions\HttpAdapterDoesNotSupportDebuggingException;
use Ominity\Api\Exceptions\IncompatiblePlatform;
use Ominity\Api\HttpAdapter\HttpAdapterPicker;
use Ominity\Api\Idempotency\DefaultIdempotencyKeyGenerator;

class OminityApiClient
{
    /**
     * Version of our client.
     */
    public const CLIENT_VERSION = "1.1.28";

    /**
     * Endpoint of the remote API.
     */
    public const API_ENDPOINT = "https://api.ominity.com";

    /**
     * Version of the remote API.
     */
    public const API_VERSION = "v1";

    /**
     * HTTP Methods
     */
    public const HTTP_GET = "GET";
    public const HTTP_POST = "POST";
    public const HTTP_DELETE = "DELETE";
    public const HTTP_PATCH = "PATCH";

    /**
     * @var \Ominity\Api\HttpAdapter\HttpAdapterInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiEndpoint = self::API_ENDPOINT;

    /**
     * RESTful CMS endppoints.
     *
     * @var CmsEndpointCollection
     */
    public $cms;

    /**
     * RESTful Commerce endppoints.
     *
     * @var CommerceEndpointCollection
     */
    public $commerce;

    /**
     * RESTful Settings endppoints.
     *
     * @var SettingsEndpointCollection
     */
    public $settings;

    /**
     * RESTful Users endppoint.
     *
     * @var UserEndpoint
     */
    public $users;

    /**
     * RESTful Modules endppoints.
     *
     * @var ModulesEndpointCollection
     */
    public $modules;
    
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * True if an OAuth access token is set as API key.
     *
     * @var bool
     */
    protected $oauthAccess;

    /**
     * A unique string ensuring a request to a mutating API endpoint is processed only once.
     * This key resets to null after each request.
     *
     * @var string|null
     */
    protected $idempotencyKey = null;

    /**
     * @var \Ominity\Api\Idempotency\IdempotencyKeyGeneratorContract|null
     */
    protected $idempotencyKeyGenerator;

    /**
     * @var array
     */
    protected $versionStrings = [];

    /**
     * @var string|null
     */
    protected $language = null; // Language code for Accept-Language header

    /**
     * @param \GuzzleHttp\ClientInterface|\Ominity\Api\HttpAdapter\HttpAdapterInterface|null $httpClient
     * @param \Ominity\Api\HttpAdapter\HttpAdapterPickerInterface|null $httpAdapterPicker,
     * @param \Ominity\Api\Idempotency\IdempotencyKeyGeneratorContract $idempotencyKeyGenerator,
     * @throws \Ominity\Api\Exceptions\IncompatiblePlatform|\Ominity\Api\Exceptions\UnrecognizedClientException
     */
    public function __construct($httpClient = null, $httpAdapterPicker = null, $idempotencyKeyGenerator = null)
    {
        $httpAdapterPicker = $httpAdapterPicker ?: new HttpAdapterPicker;
        $this->httpClient = $httpAdapterPicker->pickHttpAdapter($httpClient);

        $compatibilityChecker = new CompatibilityChecker;
        $compatibilityChecker->checkCompatibility();

        $this->initializeEndpoints();
        $this->initializeVersionStrings();
        $this->initializeIdempotencyKeyGenerator($idempotencyKeyGenerator);
    }

    public function initializeEndpoints()
    {
        $this->cms = new CmsEndpointCollection($this);
        $this->commerce = new CommerceEndpointCollection($this);
        $this->settings = new SettingsEndpointCollection($this);
        $this->users = new UserEndpoint($this);
        $this->modules = new ModulesEndpointCollection($this);
    }

    protected function initializeVersionStrings()
    {
        $this->addVersionString("Ominity/" . self::CLIENT_VERSION);
        $this->addVersionString("PHP/" . phpversion());

        $httpClientVersionString = $this->httpClient->versionString();
        if ($httpClientVersionString) {
            $this->addVersionString($httpClientVersionString);
        }
    }

    /**
     * @param \Ominity\Api\Idempotency\IdempotencyKeyGeneratorContract $generator
     * @return void
     */
    protected function initializeIdempotencyKeyGenerator($generator)
    {
        $this->idempotencyKeyGenerator = $generator ? $generator : new DefaultIdempotencyKeyGenerator;
    }

    /**
     * @param string $url
     *
     * @return OminityApiClient
     */
    public function setApiEndpoint($url)
    {
        $this->apiEndpoint = rtrim(trim($url), '/');

        return $this;
    }

    /**
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    /**
     * @return array
     */
    public function getVersionStrings()
    {
        return $this->versionStrings;
    }

    /**
     * @param string $apiKey The API key, needs to be 32 characters long
     *
     * @return OminityApiClient
     * @throws ApiException
     */
    public function setApiKey($apiKey)
    {
        $apiKey = trim($apiKey);

        if (! preg_match('/^[0-9a-zA-Z]{32}$/', $apiKey)) {
            throw new ApiException("Invalid API key: '{$apiKey}'. An API key must be a 32-character alphanumeric string.");
        }

        $this->apiKey = $apiKey;
        $this->oauthAccess = false;

        return $this;
    }

    /**
     * @param string $accessToken OAuth access token, a well-formed JWT
     *
     * @return OminityApiClient
     * @throws ApiException
     */
    public function setAccessToken($accessToken)
    {
        $accessToken = trim($accessToken);

        if (! preg_match('/^[A-Za-z0-9\-_]+\.[A-Za-z0-9\-_]+\.[A-Za-z0-9\-_]+$/', $accessToken)) {
            throw new ApiException("Invalid OAuth access token: '{$accessToken}'. An access token must be a well-formed JWT.");
        }

        $this->apiKey = $accessToken;
        $this->oauthAccess = true;

        return $this;
    }

    /**
     * Returns null if no API key has been set yet.
     *
     * @return bool|null
     */
    public function usesOAuth()
    {
        return $this->oauthAccess;
    }

    /**
     * @param string $versionString
     *
     * @return OminityApiClient
     */
    public function addVersionString($versionString)
    {
        $this->versionStrings[] = str_replace([" ", "\t", "\n", "\r"], '-', $versionString);

        return $this;
    }

    /**
     * Set the language code for Accept-Language header.
     *
     * @param string $language The language code to set (e.g., "en-US").
     * @return OminityApiClient
     */
    public function setLanguage($language)
    {
        $this->language = trim($language);

        return $this;
    }

    /**
     * Get the current language code.
     *
     * @return string|null The current language code or null if not set.
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Enable debugging mode. If debugging mode is enabled, the attempted request will be included in the ApiException.
     * By default, debugging is disabled to prevent leaking sensitive request data into exception logs.
     *
     * @throws \Ominity\Api\Exceptions\HttpAdapterDoesNotSupportDebuggingException
     */
    public function enableDebugging()
    {
        if (
            ! method_exists($this->httpClient, 'supportsDebugging')
            || ! $this->httpClient->supportsDebugging()
        ) {
            throw new HttpAdapterDoesNotSupportDebuggingException(
                "Debugging is not supported by " . get_class($this->httpClient) . "."
            );
        }

        $this->httpClient->enableDebugging();
    }

    /**
     * Disable debugging mode. If debugging mode is enabled, the attempted request will be included in the ApiException.
     * By default, debugging is disabled to prevent leaking sensitive request data into exception logs.
     *
     * @throws \Ominity\Api\Exceptions\HttpAdapterDoesNotSupportDebuggingException
     */
    public function disableDebugging()
    {
        if (
            ! method_exists($this->httpClient, 'supportsDebugging')
            || ! $this->httpClient->supportsDebugging()
        ) {
            throw new HttpAdapterDoesNotSupportDebuggingException(
                "Debugging is not supported by " . get_class($this->httpClient) . "."
            );
        }

        $this->httpClient->disableDebugging();
    }

    /**
     * Set the idempotency key used on the next request. The idempotency key is a unique string ensuring a request to a
     * mutating API endpoint is processed only once. The idempotency key resets to null after each request. Using
     * the setIdempotencyKey method supersedes the IdempotencyKeyGenerator.
     *
     * @param $key
     * @return $this
     */
    public function setIdempotencyKey($key)
    {
        $this->idempotencyKey = $key;

        return $this;
    }

    /**
     * Retrieve the idempotency key. The idempotency key is a unique string ensuring a request to a
     * mutating API endpoint is processed only once. Note that the idempotency key gets reset to null after each
     * request.
     *
     * @return string|null
     */
    public function getIdempotencyKey()
    {
        return $this->idempotencyKey;
    }

    /**
     * Reset the idempotency key. Note that the idempotency key automatically resets to null after each request.
     * @return $this
     */
    public function resetIdempotencyKey()
    {
        $this->idempotencyKey = null;

        return $this;
    }

    /**
     * @param \Ominity\Api\Idempotency\IdempotencyKeyGeneratorContract $generator
     * @return \Ominity\Api\OminityApiClient
     */
    public function setIdempotencyKeyGenerator($generator)
    {
        $this->idempotencyKeyGenerator = $generator;

        return $this;
    }

    /**
     * @return \Ominity\Api\OminityApiClient
     */
    public function clearIdempotencyKeyGenerator()
    {
        $this->idempotencyKeyGenerator = null;

        return $this;
    }

    /**
     * Perform a http call. This method is used by the resource specific classes. Please use the $payments property to
     * perform operations on payments.
     *
     * @param string $httpMethod
     * @param string $apiMethod
     * @param string|null $httpBody
     * @param string $accept
     *
     * @return \stdClass
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCall($httpMethod, $apiMethod, $httpBody = null, $accept = "application/json")
    {
        $url = $this->apiEndpoint . "/" . self::API_VERSION . "/" . $apiMethod;

        return $this->performHttpCallToFullUrl($httpMethod, $url, $httpBody, $accept);
    }

    /**
     * Perform a http call to a full url. This method is used by the resource specific classes.
     *
     * @see $payments
     * @see $isuers
     *
     * @param string $httpMethod
     * @param string $url
     * @param string|null $httpBody
     * @param string $accept
     *
     * @return \stdClass|string|null
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCallToFullUrl($httpMethod, $url, $httpBody = null, $accept = "application/json")
    {
        if (empty($this->apiKey)) {
            throw new ApiException("You have not set an API key or OAuth access token. Please use setApiKey() to set the API key.");
        }

        $userAgent = implode(' ', $this->versionStrings);

        if ($this->usesOAuth()) {
            $userAgent .= " OAuth/2.0";
        }

        $headers = [
            'Accept' => $accept,
            'Authorization' => "Bearer {$this->apiKey}",
            'User-Agent' => $userAgent,
        ];

        if ($httpBody !== null) {
            $headers['Content-Type'] = "application/json";
        }

        if ($this->language) {
            $headers['Accept-Language'] = $this->language;
        }

        if (function_exists("php_uname")) {
            $headers['X-Ominity-Client-Info'] = php_uname();
        }

        $headers = $this->applyIdempotencyKey($headers, $httpMethod);

        $response = $this->httpClient->send($httpMethod, $url, $headers, $httpBody);

        $this->resetIdempotencyKey();

        return $response;
    }

    /**
     * Conditionally apply the idempotency key to the request headers
     *
     * @param array $headers
     * @param string $httpMethod
     * @return array
     */
    private function applyIdempotencyKey(array $headers, string $httpMethod)
    {
        if (! in_array($httpMethod, [self::HTTP_POST, self::HTTP_PATCH, self::HTTP_DELETE])) {
            unset($headers['Idempotency-Key']);

            return $headers;
        }

        if ($this->idempotencyKey) {
            $headers['Idempotency-Key'] = $this->idempotencyKey;

            return $headers;
        }

        if ($this->idempotencyKeyGenerator) {
            $headers['Idempotency-Key'] = $this->idempotencyKeyGenerator->generate();

            return $headers;
        }

        unset($headers['Idempotency-Key']);

        return $headers;
    }

    /**
     * Serialization can be used for caching. Of course doing so can be dangerous but some like to live dangerously.
     *
     * \serialize() should be called on the collections or object you want to cache.
     *
     * We don't need any property that can be set by the constructor, only properties that are set by setters.
     *
     * Note that the API key is not serialized, so you need to set the key again after unserializing if you want to do
     * more API calls.
     *
     * @deprecated
     * @return string[]
     */
    public function __sleep()
    {
        return ["apiEndpoint"];
    }

    /**
     * When unserializing a collection or a resource, this class should restore itself.
     *
     * Note that if you have set an HttpAdapter, this adapter is lost on wakeup and reset to the default one.
     *
     * @throws IncompatiblePlatform If suddenly unserialized on an incompatible platform.
     */
    public function __wakeup()
    {
        $this->__construct();
    }
}
<?php

namespace Tests\Ominity\Api;

use Eloquent\Liberator\Liberator;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Exceptions\HttpAdapterDoesNotSupportDebuggingException;
use Ominity\Api\Idempotency\FakeIdempotencyKeyGenerator;
use Ominity\Api\OminityApiClient;
use Tests\Ominity\TestHelpers\FakeHttpAdapter;
use Ominity\Api\HttpAdapter\CurlHttpAdapter;
use Ominity\Api\HttpAdapter\Guzzle6And7HttpAdapter;

class OminityApiClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $guzzleClient;

    /**
     * @var OminityApiClient
     */
    private $apiClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->guzzleClient = $this->createMock(Client::class);
        $this->apiClient = new OminityApiClient($this->guzzleClient);

        $this->apiClient->setApiKey('test_foobarfoobarfoobarfoobarfoobar');
    }

    public function testPerformHttpCallReturnsBodyAsObject()
    {
        $response = new Response(200, [], '{"resource": "payment"}');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);


        $parsedResponse = $this->apiClient->performHttpCall('GET', '');

        $this->assertEquals(
            (object)['resource' => 'payment'],
            $parsedResponse
        );
    }

    public function testPerformHttpCallCreatesApiExceptionCorrectly()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Error executing API call (422: Unprocessable Entity): Non-existent parameter "recurringType" for this API call. Did you mean: "sequenceType"?');
        $this->expectExceptionCode(422);

        $response = new Response(422, [], '{
            "status": 422,
            "title": "Unprocessable Entity",
            "detail": "Non-existent parameter \"recurringType\" for this API call. Did you mean: \"sequenceType\"?",
            "field": "recurringType",
            "_links": {
                "documentation": {
                    "href": "https://docs.ominity.com/guides/handling-errors",
                    "type": "text/html"
                }
            }
        }');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        try {
            $parsedResponse = $this->apiClient->performHttpCall('GET', '');
        } catch (ApiException $e) {
            $this->assertEquals('recurringType', $e->getField());
            $this->assertEquals('https://docs.ominity.com/guides/handling-errors', $e->getDocumentationUrl());
            $this->assertEquals($response, $e->getResponse());

            throw $e;
        }
    }

    public function testPerformHttpCallCreatesApiExceptionWithoutFieldAndDocumentationUrl()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Error executing API call (422: Unprocessable Entity): Non-existent parameter "recurringType" for this API call. Did you mean: "sequenceType"?');
        $this->expectExceptionCode(422);

        $response = new Response(422, [], '{
            "status": 422,
            "title": "Unprocessable Entity",
            "detail": "Non-existent parameter \"recurringType\" for this API call. Did you mean: \"sequenceType\"?"
        }');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        try {
            $parsedResponse = $this->apiClient->performHttpCall('GET', '');
        } catch (ApiException $e) {
            $this->assertNull($e->getField());
            $this->assertNull($e->getDocumentationUrl());
            $this->assertEquals($response, $e->getResponse());

            throw $e;
        }
    }

    public function testCanBeSerializedAndUnserialized()
    {
        $this->apiClient->setApiEndpoint("https://myominityproxy.local");
        $serialized = \serialize($this->apiClient);

        $this->assertStringNotContainsString('test_foobarfoobarfoobarfoobarfoobar', $serialized, "API key should not be in serialized data or it will end up in caches.");

        /** @var OminityApiClient $client_copy */
        $client_copy = Liberator::liberate(unserialize($serialized));

        $this->assertEmpty($client_copy->apiKey, "API key should not have been remembered");
        $this->assertInstanceOf(Guzzle6And7HttpAdapter::class, $client_copy->httpClient, "A Guzzle client should have been set.");
        $this->assertNull($client_copy->usesOAuth());
        $this->assertEquals("https://myominityproxy.local", $client_copy->getApiEndpoint(), "The API endpoint should be remembered");

        $this->assertNotEmpty($client_copy->customerPayments);
        $this->assertNotEmpty($client_copy->payments);
        $this->assertNotEmpty($client_copy->methods);
        // no need to assert them all.
    }

    public function testResponseBodyCanBeReadMultipleTimesIfMiddlewareReadsItFirst()
    {
        $response = new Response(200, [], '{"resource": "payment"}');

        // Before the OminityApiClient gets the response, some middleware reads the body first.
        $bodyAsReadFromMiddleware = (string) $response->getBody();

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($response);

        $parsedResponse = $this->apiClient->performHttpCall('GET', '');

        $this->assertEquals(
            '{"resource": "payment"}',
            $bodyAsReadFromMiddleware
        );

        $this->assertEquals(
            (object)['resource' => 'payment'],
            $parsedResponse
        );
    }

    public function testEnablingDebuggingThrowsAnExceptionIfHttpAdapterDoesNotSupportIt()
    {
        $this->expectException(HttpAdapterDoesNotSupportDebuggingException::class);
        $client = new OminityApiClient(new CurlHttpAdapter);

        $client->enableDebugging();
    }

    public function testDisablingDebuggingThrowsAnExceptionIfHttpAdapterDoesNotSupportIt()
    {
        $this->expectException(HttpAdapterDoesNotSupportDebuggingException::class);
        $client = new OminityApiClient(new CurlHttpAdapter);

        $client->disableDebugging();
    }

    /**
     * This test verifies that our request headers are correctly sent to the API.
     * If these are broken, it could be that some payments do not work.
     *
     * @throws ApiException
     */
    public function testCorrectRequestHeaders()
    {
        $response = new Response(200, [], '{"resource": "payment"}');
        $fakeAdapter = new FakeHttpAdapter($response);

        $apiClient = new OminityApiClient($fakeAdapter);
        $apiClient->setApiKey('test_foobarfoobarfoobarfoobarfoobar');

        $apiClient->performHttpCallToFullUrl('GET', '', '');

        $usedHeaders = $fakeAdapter->getUsedHeaders();

        # these change through environments
        # just make sure its existing
        $this->assertArrayHasKey('User-Agent', $usedHeaders);
        $this->assertArrayHasKey('X-Ominity-Client-Info', $usedHeaders);

        # these should be exactly the expected values
        $this->assertEquals('Bearer test_foobarfoobarfoobarfoobarfoobar', $usedHeaders['Authorization']);
        $this->assertEquals('application/json', $usedHeaders['Accept']);
        $this->assertEquals('application/json', $usedHeaders['Content-Type']);
    }

    /**
     * This test verifies that we do not add a Content-Type request header
     * if we do not send a BODY (skipping argument).
     * In this case it has to be skipped.
     *
     * @throws ApiException
     * @throws \Ominity\Api\Exceptions\IncompatiblePlatform
     * @throws \Ominity\Api\Exceptions\UnrecognizedClientException
     */
    public function testNoContentTypeWithoutProvidedBody()
    {
        $response = new Response(200, [], '{"resource": "payment"}');
        $fakeAdapter = new FakeHttpAdapter($response);

        $apiClient = new OminityApiClient($fakeAdapter);
        $apiClient->setApiKey('test_foobarfoobarfoobarfoobarfoobar');

        $apiClient->performHttpCallToFullUrl('GET', '');

        $this->assertEquals(false, isset($fakeAdapter->getUsedHeaders()['Content-Type']));
    }

    public function testIfNoIdempotencyKeyIsSetNoReferenceIsIncludedInTheRequestHeaders()
    {
        $response = new Response(200, [], '{"resource": "payment"}');
        $fakeAdapter = new FakeHttpAdapter($response);

        $apiClient = new OminityApiClient($fakeAdapter);
        $apiClient->setApiKey('test_foobarfoobarfoobarfoobarfoobar');

        // ... Not setting an idempotency key here

        $apiClient->performHttpCallToFullUrl('GET', '');

        $this->assertFalse(isset($fakeAdapter->getUsedHeaders()['Idempotency-Key']));
    }

    public function testIdempotencyKeyIsUsedOnMutatingRequests()
    {
        $this->assertIdempotencyKeyIsUsedForMethod('POST');
        $this->assertIdempotencyKeyIsUsedForMethod('PATCH');
        $this->assertIdempotencyKeyIsUsedForMethod('DELETE');
    }

    public function testIdempotencyKeyIsNotUsedOnGetRequests()
    {
        $response = new Response(200, [], '{"resource": "payment"}');
        $fakeAdapter = new FakeHttpAdapter($response);

        $apiClient = new OminityApiClient($fakeAdapter);
        $apiClient->setApiKey('test_foobarfoobarfoobarfoobarfoobar');
        $apiClient->setIdempotencyKey('idempotentFooBar');

        $apiClient->performHttpCallToFullUrl('GET', '');

        $this->assertFalse(isset($fakeAdapter->getUsedHeaders()['Idempotency-Key']));
    }

    public function testIdempotencyKeyResetsAfterEachRequest()
    {
        $response = new Response(200, [], '{"resource": "payment"}');
        $fakeAdapter = new FakeHttpAdapter($response);

        $apiClient = new OminityApiClient($fakeAdapter);
        $apiClient->setApiKey('test_foobarfoobarfoobarfoobarfoobar');
        $apiClient->setIdempotencyKey('idempotentFooBar');
        $this->assertEquals('idempotentFooBar', $apiClient->getIdempotencyKey());

        $apiClient->performHttpCallToFullUrl('POST', '');

        $this->assertNull($apiClient->getIdempotencyKey());
    }

    public function testItUsesTheIdempotencyKeyGenerator()
    {
        $response = new Response(200, [], '{"resource": "payment"}');
        $fakeAdapter = new FakeHttpAdapter($response);
        $fakeIdempotencyKeyGenerator = new FakeIdempotencyKeyGenerator;
        $fakeIdempotencyKeyGenerator->setFakeKey('fake-idempotency-key');

        $apiClient = new OminityApiClient($fakeAdapter, null, $fakeIdempotencyKeyGenerator);
        $apiClient->setApiKey('test_foobarfoobarfoobarfoobarfoobar');
        $this->assertNull($apiClient->getIdempotencyKey());

        $apiClient->performHttpCallToFullUrl('POST', '');

        $this->assertEquals('fake-idempotency-key', $fakeAdapter->getUsedHeaders()['Idempotency-Key']);
        $this->assertNull($apiClient->getIdempotencyKey());
    }

    /**
     * @param $httpMethod
     * @return void
     * @throws \Ominity\Api\Exceptions\ApiException
     * @throws \Ominity\Api\Exceptions\IncompatiblePlatform
     * @throws \Ominity\Api\Exceptions\UnrecognizedClientException
     */
    private function assertIdempotencyKeyIsUsedForMethod($httpMethod)
    {
        $response = new Response(200, [], '{"resource": "payment"}');
        $fakeAdapter = new FakeHttpAdapter($response);

        $apiClient = new OminityApiClient($fakeAdapter);
        $apiClient->setApiKey('test_foobarfoobarfoobarfoobarfoobar');
        $apiClient->setIdempotencyKey('idempotentFooBar');

        $apiClient->performHttpCallToFullUrl($httpMethod, '');

        $this->assertTrue(isset($fakeAdapter->getUsedHeaders()['Idempotency-Key']));
        $this->assertEquals('idempotentFooBar', $fakeAdapter->getUsedHeaders()['Idempotency-Key']);
    }
}
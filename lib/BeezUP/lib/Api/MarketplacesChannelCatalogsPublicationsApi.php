<?php
/**
 * MarketplacesChannelCatalogsPublicationsApi
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * BeezUP API
 *
 * # The REST API of BeezUP system ## Overview The REST APIs provide programmatic access to read and write BeezUP data.  Basically, with this API you will be able to do everything like you were with your browser on https://go.beezup.com !  The main features are: - Register and manage your account - Create and manage and share your stores with your friends/co-workers. - Import your product catalog and schedule the auto importation - Search the channels your want to use - Configure your channels for your catalogs to export your product information:     - cost and general settings     - category and columns mappings     - your will be able to create and manage your custom column     - put in place exlusion filters based on simple conditions on your product data     - override product values     - get product vision for a channel catalog scope - Analyze and optimize your performance of your catalogs on all yours channels with different type of reportings by day, channel, category and by product. - Automatize your optimisation by using rules! - And of course... Manage your orders harvested from all your marketplaces:     - Synchronize your orders in an uniformized way     - Get the available actions and update the order status - ...and more!  ## Authentication credentials The public API with the base path **_/v2/public** have been put in place to give you an entry point to our system for the user registration, login and lost password. The public API does not require any credentials. We give you the some public list of values and public channels for our public commercial web site [www.beezup.com](http://www.beezup.com).  The user API with the base path **_/v2/user** requires a token which is available on this page: https://go.beezup.com/Account/MyAccount  ## Things to keep in mind ### API Rate Limits - The BeezUP REST API is limited to 100 calls/minute.  ### Media type The default media type for requests and responses is application/json. Where noted, some operations support other content types. If no additional content type is mentioned for a specific operation, then the media type is application/json.  ### Required content type The required and default encoding for the request and responses is UTF8.  ### Required date time format All our date time are formatted in ISO 8601 format: 2014-06-24T16:25:00Z.  ### Base URL The Base URL of the BeezUP API Order Management REST API conforms to the following template.  https://api.beezup.com  All URLs returned by the BeezUP API are relative to this base URL, and all requests to the REST API must use this base URL template.  You can test our API on https://api-docs.beezup.com/swagger-ui\\ You can contact us on [gitter, #BeezUP/API](https://gitter.im/BeezUP/API)
 *
 * OpenAPI spec version: 2.0
 * Contact: help@beezup.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.0-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Swagger\Client\ApiException;
use Swagger\Client\Configuration;
use Swagger\Client\HeaderSelector;
use Swagger\Client\ObjectSerializer;

/**
 * MarketplacesChannelCatalogsPublicationsApi Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class MarketplacesChannelCatalogsPublicationsApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation getPublications
     *
     * Fetch the publication history for an account, sorted by descending start date
     *
     * @param  string $marketplace_technical_code Marketplace Technical Code to query (required) (required)
     * @param  int $account_id Account Id to query (required) (required)
     * @param  string $channel_catalog_id Channel Catalog Id by which to filter (optional) (optional)
     * @param  int $count Amount of entries to fetch (optional, default set to 10) (optional, default to 10)
     * @param  string[] $publication_types Publication types by which to filter (optional) (optional)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Swagger\Client\Model\AccountPublications
     */
    public function getPublications($marketplace_technical_code, $account_id, $channel_catalog_id = null, $count = '10', $publication_types = null)
    {
        list($response) = $this->getPublicationsWithHttpInfo($marketplace_technical_code, $account_id, $channel_catalog_id, $count, $publication_types);
        return $response;
    }

    /**
     * Operation getPublicationsWithHttpInfo
     *
     * Fetch the publication history for an account, sorted by descending start date
     *
     * @param  string $marketplace_technical_code Marketplace Technical Code to query (required) (required)
     * @param  int $account_id Account Id to query (required) (required)
     * @param  string $channel_catalog_id Channel Catalog Id by which to filter (optional) (optional)
     * @param  int $count Amount of entries to fetch (optional, default set to 10) (optional, default to 10)
     * @param  string[] $publication_types Publication types by which to filter (optional) (optional)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Swagger\Client\Model\AccountPublications, HTTP status code, HTTP response headers (array of strings)
     */
    public function getPublicationsWithHttpInfo($marketplace_technical_code, $account_id, $channel_catalog_id = null, $count = '10', $publication_types = null)
    {
        $returnType = '\Swagger\Client\Model\AccountPublications';
        $request = $this->getPublicationsRequest($marketplace_technical_code, $account_id, $channel_catalog_id, $count, $publication_types);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Swagger\Client\Model\AccountPublications',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Swagger\Client\Model\BeezUPCommonErrorResponseMessage',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation getPublicationsAsync
     *
     * Fetch the publication history for an account, sorted by descending start date
     *
     * @param  string $marketplace_technical_code Marketplace Technical Code to query (required) (required)
     * @param  int $account_id Account Id to query (required) (required)
     * @param  string $channel_catalog_id Channel Catalog Id by which to filter (optional) (optional)
     * @param  int $count Amount of entries to fetch (optional, default set to 10) (optional, default to 10)
     * @param  string[] $publication_types Publication types by which to filter (optional) (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getPublicationsAsync($marketplace_technical_code, $account_id, $channel_catalog_id = null, $count = '10', $publication_types = null)
    {
        return $this->getPublicationsAsyncWithHttpInfo($marketplace_technical_code, $account_id, $channel_catalog_id, $count, $publication_types)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation getPublicationsAsyncWithHttpInfo
     *
     * Fetch the publication history for an account, sorted by descending start date
     *
     * @param  string $marketplace_technical_code Marketplace Technical Code to query (required) (required)
     * @param  int $account_id Account Id to query (required) (required)
     * @param  string $channel_catalog_id Channel Catalog Id by which to filter (optional) (optional)
     * @param  int $count Amount of entries to fetch (optional, default set to 10) (optional, default to 10)
     * @param  string[] $publication_types Publication types by which to filter (optional) (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getPublicationsAsyncWithHttpInfo($marketplace_technical_code, $account_id, $channel_catalog_id = null, $count = '10', $publication_types = null)
    {
        $returnType = '\Swagger\Client\Model\AccountPublications';
        $request = $this->getPublicationsRequest($marketplace_technical_code, $account_id, $channel_catalog_id, $count, $publication_types);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'getPublications'
     *
     * @param  string $marketplace_technical_code Marketplace Technical Code to query (required) (required)
     * @param  int $account_id Account Id to query (required) (required)
     * @param  string $channel_catalog_id Channel Catalog Id by which to filter (optional) (optional)
     * @param  int $count Amount of entries to fetch (optional, default set to 10) (optional, default to 10)
     * @param  string[] $publication_types Publication types by which to filter (optional) (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getPublicationsRequest($marketplace_technical_code, $account_id, $channel_catalog_id = null, $count = '10', $publication_types = null)
    {
        // verify the required parameter 'marketplace_technical_code' is set
        if ($marketplace_technical_code === null || (is_array($marketplace_technical_code) && count($marketplace_technical_code) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $marketplace_technical_code when calling getPublications'
            );
        }
        // verify the required parameter 'account_id' is set
        if ($account_id === null || (is_array($account_id) && count($account_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $account_id when calling getPublications'
            );
        }
        if ($count !== null && $count > 100) {
            throw new \InvalidArgumentException('invalid value for "$count" when calling MarketplacesChannelCatalogsPublicationsApi.getPublications, must be smaller than or equal to 100.');
        }
        if ($count !== null && $count < 10) {
            throw new \InvalidArgumentException('invalid value for "$count" when calling MarketplacesChannelCatalogsPublicationsApi.getPublications, must be bigger than or equal to 10.');
        }


        $resourcePath = '/user/marketplaces/channelcatalogs/publications/{marketplaceTechnicalCode}/{accountId}/history';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($channel_catalog_id !== null) {
            $queryParams['channelCatalogId'] = ObjectSerializer::toQueryValue($channel_catalog_id);
        }
        // query params
        if ($count !== null) {
            $queryParams['count'] = ObjectSerializer::toQueryValue($count);
        }
        // query params
        if (is_array($publication_types)) {
            $publication_types = ObjectSerializer::serializeCollection($publication_types, 'csv', true);
        }
        if ($publication_types !== null) {
            $queryParams['publicationTypes'] = ObjectSerializer::toQueryValue($publication_types);
        }

        // path params
        if ($marketplace_technical_code !== null) {
            $resourcePath = str_replace(
                '{' . 'marketplaceTechnicalCode' . '}',
                ObjectSerializer::toPathValue($marketplace_technical_code),
                $resourcePath
            );
        }
        // path params
        if ($account_id !== null) {
            $resourcePath = str_replace(
                '{' . 'accountId' . '}',
                ObjectSerializer::toPathValue($account_id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                ['application/json']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKeyWithPrefix('Ocp-Apim-Subscription-Key');
        if ($apiKey !== null) {
            $headers['Ocp-Apim-Subscription-Key'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);
        return new Request(
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}

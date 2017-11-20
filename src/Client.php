<?php 

namespace rajathans\Shiprocket;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException as HttpClientException;
use GuzzleHttp\Psr7\Response;

use ReflectionClass;

class Client
{
	private $access_token;
    private $email;
    private $password;
	private $use_sandbox;
	private $version = 'v1';
    private $rate_limit = null;
    private $httpClient;

    /**
     * Creates a new client.
     *
     * @param    array    $config
     */
    public function __construct($config = [])
    {
		$this->configure($config);
        $this->httpClient = new HttpClient;
    }

    /**
     * Gets authorization header value.
     *
     * @return   string
     */
    private function getAuthorizationHeader()
    {
        if ($this->access_token) {
            return 'Bearer ' . $this->access_token;
        }
    }

    /**
     * Gets HttpClient config for verb and parameters.
     *
     * @param    string   $verb
     * @param    array    $parameters
     *
     * @return   array
     */
    private function getConfigForVerbAndParameters($verb, $parameters = [])
    {
        $config = [
            'headers' => $this->getHeaders()
        ];

        if (!empty($parameters)) {
            if (strtolower($verb) == 'get') {
                $config['query'] = $parameters;
            } else {
                $config['json'] = $parameters;
            }
        }

        return $config;
    }

    /**
     * Gets headers for request.
     *
     * @return   array
     */
    public function getHeaders()
    {
        return [
            'Authorization' => trim($this->getAuthorizationHeader())
        ];
    }

    /**
     * Builds url from path.
     *
     * @param    string   $path
     *
     * @return   string   Url
     */
    public function getUrlFromPath($path)
    {
        $path = ltrim($path, '/');

        $host = 'https://'.($this->use_sandbox ? 'krmct000.kartrocket.com/' : 'apiv2.shiprocket.in/');

        return $host.($this->version ? '/' .$this->version : '').'/'.$path;
    }

    /**
     * Handles http client exceptions.
     *
     * @param    HttpClientException $e
     *
     * @return   void
     * @throws   Exception
     */
    private function handleRequestException(HttpClientException $e)
    {
        if ($response = $e->getResponse()) {
            $exception = new Exception($response->getReasonPhrase(), $response->getStatusCode(), $e);
            $exception->setBody(json_decode($response->getBody()));

            throw $exception;
        }

        throw new Exception($e->getMessage(), 500, $e);
    }

    /**
     * Parses configuration.
     *
     * @param    array    $config
     *
     * @return   array    $config
     */
    private function configure($config = [])
    {
        $this->email 		= $config['email'];
        $this->password 	= $config['password'];
		$this->use_sandbox  = $config['use_sandbox'];
    }

    /**
     * Attempts to pull rate limit headers from response and add to client.
     *
     * @param    Response $response
     *
     * @return   void
     */
    private function parseRateLimitFromResponse(Response $response)
    {
        $rateLimitHeaders = array_filter([
            $response->getHeader('X-Rate-Limit-Limit'),
            $response->getHeader('X-Rate-Limit-Remaining'),
            $response->getHeader('X-Rate-Limit-Reset')
        ]);

        if (count($rateLimitHeaders) == 3) {
            $rateLimitClass = new ReflectionClass(RateLimit::class);
            $this->rate_limit = $rateLimitClass->newInstanceArgs($rateLimitHeaders);
        }
    }

    /**
     * Makes a request to the Shiprocket API and returns the response.
     *
     * @param    string   $verb       The Http verb to use
     * @param    string   $path       The path of the APi after the domain
     * @param    array    $parameters Parameters
     *
     * @return   stdClass             The JSON response from the request
     * @throws   Exception
     */
    protected function request($verb, $path, $parameters = [])
    {
        $client = $this->httpClient;
        $url = $this->getUrlFromPath($path);
        $verb = strtolower($verb);
        $config = $this->getConfigForVerbAndParameters($verb, $parameters);

        try {
            $response = $client->$verb($url, $config);
        } catch (HttpClientException $e) {
            $this->handleRequestException($e);
        }

        $this->parseRateLimitFromResponse($response);

        return json_decode($response->getBody());
    }

    /**
     * Sets Http Client.
     *
     * @param    HttpClient  $client
     *
     * @return   Client
     */
    public function setHttpClient(HttpClient $client)
    {
		$this->httpClient = $client;
		
        return $this;
    }
}

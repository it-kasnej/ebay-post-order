<?php

namespace kasnej\PostOrder;

use kasnej\PostOrder\Exception\ClientException;
use kasnej\PostOrder\Exception\ServerException;

class Client
{

    /**
     * @var string
     */
    private $baseUrl = 'https://api.ebay.com/post-order/v2/';
    /**
     * @var string
     */
    private $authorization;

    /**
     * @var string
     */
    private $marketplaceid;
    /**
     * @var HttpClient
     */
    private $client;


    /**
     * @param HttpClient $client HTTP client implementation
     * @param string $authorization The authorization token
     * @param string $marketplaceid The market place id (EBAY-US, EBAY-UK, EBAY-DE)
     * @param string $baseUrl Overrides the default baseUrl if needed
     */
    public function __construct(
        HttpClient $client,
        $authorization,
        $marketplaceid,
        $baseUrl = null
    ) {
        $this->client = $client;
        $this->$authorization = $authorization;
        $this->marketplaceid = $marketplaceid;

        if (null !== $baseUrl) {
            $this->baseUrl = $baseUrl;
        }

    }


    /**
     * @param $caseId
     * @return array
     * @throws ServerException
     */
    public function getContactId($caseId)
    {
        dump(sprintf('casemanagement/%s', $caseId));
        dump($this->send(HttpClient::GET, sprintf('casemanagement/%s', $caseId)));
    }


    /**
     * @param string $method
     * @param string $uri
     * @param array $body
     * @return array
     * @throws ServerException
     */
    protected function send($method = 'GET', $uri)
    {
        $headers = array(
            'Authorization: TOKEN '.$this->authorization.'',
            'X-EBAY-C-MARKETPLACE-ID: '.$this->marketplaceid,
            'Content-Type: application/json',
            'Accept: application/json'
        );
        $uri = $this->baseUrl.$uri;
 dump($uri);
        try {
            $responseJson = $this->client->send($method, $uri, $headers);
        } catch (\Exception $e) {
            throw new ServerException($e->getMessage());
        }
dump($responseJson);
        $responseArray = json_decode($responseJson, true);

        return $responseArray;
    }


}

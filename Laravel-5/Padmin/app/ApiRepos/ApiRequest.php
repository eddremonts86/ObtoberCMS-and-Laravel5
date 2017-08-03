<?php
/**
 * Created by PhpStorm.
 * User: edd
 * Date: 14-04-17
 * Time: 18:20
 */

namespace lvadmin\ApiRepos;
use GuzzleHttp\Client;

class ApiRequest {
  protected $client;
  public function __construct(Client $client) {
    $this->client = $client;
  }
  public function getUrl($url){
    $response = $this->client->request('GET', "{$url}");
    $Post = json_decode($response->getBody()->getContents());
    return $Post;
  }
}
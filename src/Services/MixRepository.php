<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MixRepository
{
    public function __construct(private HttpClientInterface $httpClient, private CacheInterface $cache)
    {
    }
    public function findAll(): array
    {
        return $this->cache->get('mixes_data', function (CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter(5);
            $response = $this->httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
            return $response->toArray();
        });
    }
}

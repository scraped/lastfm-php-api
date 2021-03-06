<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\LastFm\Client;

use Core23\LastFm\Connection\ConnectionInterface;
use Core23\LastFm\Exception\ApiException;
use Core23\LastFm\Exception\NotFoundException;
use Core23\LastFm\Session\SessionInterface;

final class ApiClient implements ApiClientInterface
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $sharedSecret;

    /**
     * @param ConnectionInterface $connection
     * @param string              $apiKey
     * @param string              $sharedSecret
     */
    public function __construct(ConnectionInterface $connection, string $apiKey, string $sharedSecret)
    {
        $this->connection   = $connection;
        $this->apiKey       = $apiKey;
        $this->sharedSecret = $sharedSecret;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getSharedSecret(): string
    {
        return $this->sharedSecret;
    }

    /**
     * {@inheritdoc}
     */
    public function signedCall(string $method, array $params = [], SessionInterface $session = null, $requestMethod = 'GET'): array
    {
        // Call parameter
        $callParams = [
            'method'  => $method,
            'api_key' => $this->apiKey,
        ];

        // Add session key
        if (null !== $session) {
            $callParams['sk'] = $session->getKey();
        }

        $params = array_merge($callParams, $params);
        $params = $this->filterNull($params);
        $params = $this->encodeUTF8($params);

        // Sign parameter
        $params['api_sig'] = $this->signParams($params);

        return $this->call($method, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function unsignedCall(string $method, array $params = [], string $requestMethod = 'GET'): array
    {
        // Call parameter
        $callParameter = [
            'method'  => $method,
            'api_key' => $this->apiKey,
        ];

        $params = array_merge($callParameter, $params);
        $params = $this->filterNull($params);
        $params = $this->encodeUTF8($params);

        return $this->call($method, $params);
    }

    /**
     * Filter null values.
     *
     * @param array $object
     *
     * @return array
     */
    private function filterNull(array $object): array
    {
        return array_filter($object, static function ($val) {
            return null !== $val;
        });
    }

    /**
     * Converts any string or array of strings to UTF8.
     *
     * @param mixed|mixed[] $object a String or an array
     *
     * @return mixed|mixed[] UTF8-string or array
     */
    private function encodeUTF8($object)
    {
        if (\is_array($object)) {
            return array_map([$this, 'encodeUTF8'], $object);
        }

        return mb_convert_encoding((string) $object, 'UTF-8', 'auto');
    }

    /**
     * @param array $params
     *
     * @return string
     */
    private function signParams(array $params): string
    {
        ksort($params);

        $signature = '';
        foreach ($params as $name => $value) {
            $signature .= $name.$value;
        }
        $signature .= $this->sharedSecret;

        return md5($signature);
    }

    /**
     * @param string $method
     * @param array  $params
     *
     * @return array
     */
    private function call(string $method, array $params): array
    {
        try {
            return $this->connection->call($method, $params);
        } catch (ApiException $e) {
            if (6 === (int) $e->getCode()) {
                throw new NotFoundException('No entity was found for your request.', $e->getCode(), $e);
            }

            throw $e;
        }
    }
}

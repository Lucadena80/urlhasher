<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use App\Service\FileHasher;
/*
 * Author: Luca De Nardis <lucadena80@gmail.com>
 */

class FileDownloader
{
    private $client;
    private $hasher;

    public function __construct(HttpClientInterface $client, FileHasher $hasher)
    {
        $this->client = $client;
        $this->hasher = $hasher;
    }

    /**
     * Downloads file from given url and writes it into given Object.
     *
     * @param string    $url The url from wich the download happens
     * @param object    $file The object where the data is written
     *
     * @throws \ClientExceptionInterface When the site drops an error code.
     * @throws \TransportExceptionInterface When a network error occours.
     * @throws \ExceptionInterface if other kind of errors happen.
     */
    public function downloadFile($url, $file)
    {
        try {
            $response = $this->client->request(
                'GET',
                $url
            );
            $file->setContents($this->hasher->fileHasher($response->getContent()));
            $file->setHttpCode($response->getStatusCode());
        } catch (ClientExceptionInterface $e) {
            $file->setHttpCode($response->getStatusCode());
            $file->setErrorDescription($e->getMessage());
        } catch (TransportExceptionInterface | ExceptionInterface $e) {
            $file->setHttpCode(0);
            $file->setErrorDescription($e->getMessage());
        }
    }
}

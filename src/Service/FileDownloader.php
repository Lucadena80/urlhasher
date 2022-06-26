<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Author: Luca De Nardis <lucadena80@gmail.com>
 */
class FileDownloader
{
     private $client;

     public function __construct(HttpClientInterface $client)
     {
          $this->client = $client;
     }

     /**
      * Downloads file from given url and writes it into given Object.
      *
      * @param string    $url The url from wich the download happens
      * @param object    $file The object where the data is written
      *
      * @throws \exception When a network error of any kind occours
      */
     public function downloadFile($url, $file)
     {
          try {
               $response = $this->client->request(
                    'GET',
                    $url
               );
               $file->setContents(hash("md5", $response->getContent()));
               $file->setHttpCode($response->getStatusCode());
               return $file;
          } catch (\Exception $e) {
               $file->setHttpCode(0);
               $file->setErrorDescription($e->getMessage());
          }
     }
}

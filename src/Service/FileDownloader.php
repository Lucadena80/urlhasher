<?php declare(strict_types=1);

namespace App\Service;

use app\FileClass;

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

     public function downloadFile(String $url, FileClass $file)
     {
          try {
               $response = $this->client->request(
                    'GET',
                    $url
               );
               $file->contents = (hash("md5", $response->getContent()));
               $file->httpCode = $response->getStatusCode();
               return $file;
          } catch (\Exception $e) {
               $file->httpCode = 0;
               $file->errorDescription = $e->getMessage();
          }
     }
}

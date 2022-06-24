<?php

namespace App;

use App\FileClass;

/**
 * Author: Luca De Nardis <lucadena80@gmail.com>
 */
class FileDownloader
{

     public function downloadFile($url, $file)
     {

          $curlSession = curl_init();
          curl_setopt($curlSession, CURLOPT_URL, $url);
          curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

          $file->contents = (hash("md5", curl_exec($curlSession)));
          $file->errorCode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
          $file->errorDescription = $file->statusDescription($file->errorCode);

          curl_close($curlSession);

          return $file;
     }
}

<?php

declare(strict_types=1);

namespace App\Service;


/*
 * Author: Luca De Nardis <lucadena80@gmail.com>
 */

class FileHasher
{
    
     const HASH_ALGORITHM = "md5";
    /**
     * Hashes input and redurns string.
     *
     * @param string    $content The url from wich the download happens
     * @return string   The Hashed content
     *
     */
    public function fileHasher($content)
    {
     return hash(SELF::HASH_ALGORITHM, $content);
    }
}

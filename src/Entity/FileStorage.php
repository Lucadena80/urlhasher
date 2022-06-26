<?php

namespace App\Entity;

/**
 * Author: Luca De Nardis <lucadena80@gmail.com>
 */
class FileStorage
{
    /**
    * @var string
    */
    private $contents;

    /**
    * @var int
    */
    private $httpCode;

    /**
    * @var string
    */
    private $errorDescription;

    /**
     * Getter for the hashed content of the file object.
     *
     * @return string   $contents The hashed content of the file object
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
    * Setter for the hashed content of the file object.
    *
    * @param string   $Contents The hashed content of the file object
    */
    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    /**
     * Getter for the http status code of the request saved in the file object.
     *
     * @return string   $httpCode The http status code of the request in the file object
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
    * Setter for the http status code of the request saved in the file object.
    *
    * @param string   $httpCode The http status code of the request in the file object
    */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;
    }

    /**
     * Getter for the http error description of the request saved in the file object.
     *
     * @return string   $errorDescription The http error description of the request saved in the file object.
     */
    public function getErrorDescription()
    {
        return $this->errorDescription;
    }

    /**
    * Setter for the http error description of the request saved in the file object.
    *
    * @param string   $errorDescription The http error description of the request saved in the file object.
    */
    public function setErrorDescription($errorDescription)
    {
        $this->errorDescription = $errorDescription;
    }
}

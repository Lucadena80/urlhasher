<?php declare(strict_types=1);

use App\Entity\FileStorage;
use PHPUnit\Framework\TestCase;

final class FileDownloaderTest extends TestCase
{
     public function testSetContents_validValue_successful() 
     {
         $file = new FileStorage;
         $value = 'ec21cdeeaba2f63dd49bfde46f79c4e1';
         $file->setContents($value);
         $this->assertEquals($value, $file->getContents());
     }

     public function testSetHttpCode_validValue_successful() 
     {
         $file = new FileStorage;
         $value = '200';
         $file->setHttpCode($value);
         $this->assertEquals($value, $file->getHttpCode());
     }

     public function testsetErrorDescription_validValue_successful() 
     {
         $file = new FileStorage;
         $value = 'HTTP/1.1 404 Not Found returned for "http://speed.transip.nl/random-10mb.bin';
         $file->setErrorDescription($value);
         $this->assertEquals($value, $file->getErrorDescription());
     }
}
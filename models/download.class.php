<?php

class Download
{
    public $fileDesc;
    public $fileName;

    public function __construct($fileDesc, $fileName)
    {
        $this->fileDesc = $fileDesc;
        $this->fileName = $fileName;
    }
}

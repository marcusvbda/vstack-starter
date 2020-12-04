<?php

namespace App\Logging;

use \Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class GuzzleLog extends RotatingFileHandler
{
    public $filenameFormat;

    protected function write(array $record): void
    {
        if ($path = @$record["extra"]["folder"])
            $this->setPath($path);

        parent::write($record);
    }

    protected function setPath($path)
    {
        $path = "guzzle/$path/";
        $this->setFilenameFormat($path . 'sent-{date}', 'Y-m-d');
    }
}

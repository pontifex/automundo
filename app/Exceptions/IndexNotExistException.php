<?php

namespace App\Exceptions;

class IndexNotExistException extends \RuntimeException
{
    protected $message = 'Index does not exist';
}

<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

class FileNotFoundException extends \Exception
{
    public function __construct(string $path, ?\Throwable $previous = null)
    {
        parent::__construct(message: sprintf("A file not found on path %s", $path), previous: $previous);
    }
}
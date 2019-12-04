<?php

namespace App\Exception;

use Throwable;

/**
 * Class NotFoundException
 * @package App\Exception
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class PermissionDeniedException extends \Exception
{
    /**
     * PermissionDeniedException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Permission denied", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

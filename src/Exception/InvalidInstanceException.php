<?php
/**
 * Created by PhpStorm.
 * User: GM1702816
 * Date: 2019-04-30
 * Time: 오전 11:45
 */

namespace Gabia\LaravelDto\Exception;

class InvalidInstanceException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message,400);
    }

}
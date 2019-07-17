<?php
/**
 * Created by PhpStorm.
 * User: GM1702816
 * Date: 2019-04-30
 * Time: 오전 11:45
 */

namespace Gabia\LaravelDto\Exception;

class InvalidMapperTypeException extends \Exception
{
    public function __construct()
    {
        parent::__construct('This mapper type is an type that does not support the reflection.',400);
    }

}
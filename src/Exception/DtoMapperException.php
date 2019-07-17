<?php
/**
 * Created by PhpStorm.
 * User: GM1702816
 * Date: 2019-04-30
 * Time: 오후 1:06
 */

namespace Gabia\LaravelDto\Exception;


class DtoMapperException extends \Exception
{

    /**
     * DtoMapperException constructor.
     * @param string $mapper_name
     */
    public function __construct(string $mapper_name)
    {
        parent::__construct("$mapper_name mapper internal error", 500);
    }
}
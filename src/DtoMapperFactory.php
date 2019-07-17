<?php
/**
 * Created by PhpStorm.
 * User: GM1702816
 * Date: 2019-04-09
 * Time: 오후 6:29
 */

namespace Gabia\LaravelDto;


use Gabia\LaravelDto\Dto\LaravelDto;
use Gabia\LaravelDto\DtoMapper\DtoMapper;
use Gabia\LaravelDto\DtoMapper\JsonDtoMapper;
use Gabia\LaravelDto\Exception\InvalidInstanceException;
use Gabia\LaravelDto\Exception\InvalidMapperTypeException;

class DtoMapperFactory
{
    /**
     * @param $instance
     * @return DtoMapper|null
     */
    public static function getMapper($instance): ?DtoMapper
    {
        $mapper = null;
        
        if ($instance instanceof LaravelDto) {
            $mapper = new JsonDtoMapper();
        }

        return $mapper;
    }

    /**
     * @param $type
     * @return DtoMapper|null
     * @throws InvalidMapperTypeException
     */
    public static function getMapperByType($type): ?DtoMapper
    {
        $mapper = null;

        switch ($type) {
            case 'jsonmapper':
                $mapper = new JsonDtoMapper();
                break;
            default:
                throw new InvalidMapperTypeException();
                break;
        }

        return $mapper;
    }
}
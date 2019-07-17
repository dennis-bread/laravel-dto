<?php
/**
 * Created by PhpStorm.
 * User: GM1702816
 * Date: 2019-04-09
 * Time: 오후 5:51
 */

namespace Gabia\LaravelDto\DtoMapper;


use Gabia\LaravelDto\Dto\LaravelDto;
use Gabia\LaravelDto\Exception\DtoMapperException;
use Gabia\LaravelDto\Exception\InvalidInstanceException;
use Illuminate\Http\Request;
use JsonMapper;

class JsonDtoMapper implements DtoMapper
{

    /**
     * create DTO Instance
     *
     * @param $instance
     * @param mixed $data
     * @return mixed
     * @throws DtoMapperException
     */
    public function createDto($instance, $data)
    {
        try {
            if ($data instanceof Request) {
                $data = $data->all();
            }

            $mapper = new JsonMapper();
            $mapper->bExceptionOnMissingData = true;
            $mapper->bEnforceMapType = false;
            $dto = $data ? $mapper->map($data, $instance) : $instance;
            return $dto;
        } catch (\JsonMapper_Exception $e) {
            throw new DtoMapperException('jsonmapper');
        }
    }

    /**
     * to array DTO Instance
     *
     * @param $instance
     * @return array
     * @throws InvalidInstanceException
     */
    public function toArray($instance): array
    {
        try {
            $reflection_class = new \ReflectionClass($instance);

            $array = [];
            $properties = $reflection_class->getProperties();
            foreach ($properties as $property) {
                $property->setAccessible(true);

                $value = $property->getValue($instance);

                $array[$property->name] = $this->jsonMapperToArray($value);
            }

            return $array;
        } catch (\ReflectionException $e) {
            throw new InvalidInstanceException('This instance is an instance that does not support the reflection.');
        }
    }

    /**
     * @param $value
     * @return array
     * @throws InvalidInstanceException
     */
    private function jsonMapperToArray($value)
    {
        if (is_array($value)) {
            $array = [];

            foreach ($value as $row) {
                $array[] = $this->jsonMapperToArray($row);
            }

            return $array;
        } else if ($value instanceof LaravelDto) {
            return $this->toArray($value);
        } else {
            return $value;
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: GM1702816
 * Date: 2019-04-15
 * Time: 오후 5:10
 */

namespace Gabia\LaravelDto;


use Gabia\LaravelDto\Exception\InvalidInstanceException;

class DtoService
{
    /**
     * @param $class_name
     * @param $data
     * @param string $mapper_type
     * @return mixed
     * @throws Exception\InvalidMapperTypeException
     */
    public function createDto($class_name, $data, $mapper_type = 'jsonmapper')
    {
        $dto_instance = new $class_name();

        $dto_mapper = DtoMapperFactory::getMapper($dto_instance);

        if (!$dto_mapper) {
            $dto_mapper = DtoMapperFactory::getMapperByType($mapper_type);
        }

        if ($dto_mapper) {
            $dto_instance = $dto_mapper->createDto($dto_instance, $data);
        }

        return $dto_instance;
    }

    /**
     * @param $mixed dto instance or array
     * @return mixed
     * @throws InvalidInstanceException
     */
    public function toArray($mixed)
    {
        if (is_array($mixed)) {
            $array = [];

            foreach ($mixed as $row) {
                $array[] = $this->toArray($row);
            }

            return $array;
        } else if ($mixed instanceof \DateTime) {
            $date_time = $mixed;
            return $date_time->format('Y-m-d H:i:s');
        } else if (is_object($mixed)) {
            return $this->objectToArray($mixed);
        } else {
            return $mixed;
        }
    }

    /**
     * @param $dto_instance
     * @return array
     * @throws InvalidInstanceException
     */
    private function objectToArray($dto_instance)
    {
        try {
            $reflection_class = new \ReflectionClass($dto_instance);

            $array = [];
            $properties = $reflection_class->getProperties();
            foreach ($properties as $property) {
                $property->setAccessible(true);

                $value = $property->getValue($dto_instance);

                $array[$property->name] = $this->toArray($value);
            }

            return $array;
        } catch (\ReflectionException $e) {
            throw new InvalidInstanceException('This instance is an instance that does not support the reflection.');
        }
    }

}
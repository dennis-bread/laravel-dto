<?php
/**
 * Created by PhpStorm.
 * User: GM1702816
 * Date: 2019-04-09
 * Time: 오후 2:00
 */

namespace Gabia\LaravelDto\DtoMapper;


interface DtoMapper
{
    /**
     * create DTO Instance
     *
     * @param $instance
     * @param mixed $data
     * @return mixed
     */
    public function createDto($instance, $data);

    /**
     * to array DTO Instance
     *
     * @param $instance
     * @return array
     */
    public function toArray($instance): array;
}
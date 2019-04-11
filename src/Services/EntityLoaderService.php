<?php


namespace JeroenFrenken\Chat\Services;


class EntityLoaderService
{

    public static function loadEntity($entity, $data)
    {
        $entity = new $entity();
        foreach ($data as $key => $value) {
            $entity->{"set{$key}"}($value);
        }
        return $entity;
    }

}

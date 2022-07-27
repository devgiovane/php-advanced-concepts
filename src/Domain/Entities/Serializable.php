<?php


namespace Study\Domain\Entities;


interface Serializable
{
    /**
     * @return array
     */
    public function toArray(): array;
}
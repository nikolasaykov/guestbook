<?php

namespace Guestbook\Model;

class EntitiesCollection implements \IteratorAggregate
{
    /**
     * @var array|Entity[]
     */
    protected array $entities;

    /**
     * @param Entity ...$entities
     */
    public function __construct(Entity ...$entities) {
        $this->entities = $entities;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->entities);
    }
}
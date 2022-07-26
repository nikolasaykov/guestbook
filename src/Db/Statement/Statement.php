<?php

namespace Guestbook\Db\Statement;

abstract class Statement
{
    protected string $tableName;

    /**
     * @return string
     */
    abstract public function baseSql(): string;

}
<?php

namespace Guestbook\Test\Db\Statement;

class SelectStatementTest extends \PHPUnit\Framework\TestCase
{
    public function testBaseSql(): void {
        $statement = new \Guestbook\Db\Statement\SelectStatement(
            'user',
            ['name', 'other']
        );

        $this->assertEquals('SELECT name,other FROM user', $statement->baseSql());
    }

    public function testCreateWhereClause(): void {
        $statement = new \Guestbook\Db\Statement\SelectStatement(
            'user',
            ['name', 'other'],
        );
        $statement->addCriteria('id', '!=', 1);
        $statement->addCriteria('score', '>', 11);

        $this->assertEquals(' WHERE id != :id AND score > :score', $statement->createWhereClause());
        $this->assertEquals(['id' => 1, 'score' => 11], $statement->getFieldsAndValues());
    }

    public function testCreateClause(): void {
        $statement = new \Guestbook\Db\Statement\SelectStatement(
            'user',
            ['name', 'other'],
            'id',
            'desc',
            5,
            3
        );
        $this->assertEquals(' ORDER BY id desc LIMIT 5 OFFSET 3', $statement->createFilterClause());
    }

}
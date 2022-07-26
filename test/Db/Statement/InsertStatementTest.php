<?php
namespace Guestbook\Test\Db\Statement;

class InsertStatementTest extends \PHPUnit\Framework\TestCase
{

    public function testBaseSql(): void {
        $statement = new \Guestbook\Db\Statement\InsertStatement(
            'user',
            ['name' => 'foo', 'other'=> 'bar']
        );

        $this->assertEquals('INSERT INTO user (name,other)', $statement->baseSql());
    }

    public function testGetFieldsAndValues(): void {
        $fieldsValues = ['name' => 'foo', 'other'=> 'bar'];
        $statement = new \Guestbook\Db\Statement\InsertStatement(
            'user',
            $fieldsValues
        );

        $this->assertEquals($fieldsValues, $statement->getFieldsAndValues());
    }

    public function testCreateValuesClause(): void {
        $fieldsValues = ['name' => 'foo', 'other'=> 'bar'];
        $statement = new \Guestbook\Db\Statement\InsertStatement(
            'user',
            $fieldsValues
        );
        $this->assertEquals(' VALUES (:name,:other)', $statement->createValuesClause());
    }
}
<?php

namespace Guestbook\Test\Db;

use Guestbook\Db\DbException;
use Guestbook\Db\MySQLPdoDb;
use PHPUnit\Framework\TestCase;

class MySQLPdoDbTest extends TestCase
{

    public function testInsertSuccess(): void {
        $db = new MySQLPdoDb(
            'localhost',
            3306,
            'user',
            'password',
            'guestbook'
        );

        $connection = $this->getMockBuilder(\PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stm = $this->getMockBuilder(\PDOStatement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stm->expects($this->once())
            ->method('execute')
            ->with(['name' => 'foo', 'other'=> 'bar'])
            ->willReturn(true);

        $connection->expects($this->once())
            ->method('prepare')
            ->with('INSERT INTO user (name,other)  VALUES (:name,:other)')
            ->willReturn($stm);

        $connection->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(3);

        $db->setConnection($connection);

        $insert = new \Guestbook\Db\Statement\InsertStatement(
            'user',
            ['name' => 'foo', 'other'=> 'bar']
        );
        try {
            $this->assertEquals(3, $db->insert($insert));
        } catch (DbException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testInsertErrorExecute(): void {
        $this->expectException(DbException::class);
        $db = new MySQLPdoDb(
            'localhost',
            3306,
            'user',
            'password',
            'guestbook'
        );

        $connection = $this->getMockBuilder(\PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stm = $this->getMockBuilder(\PDOStatement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stm->expects($this->once())
            ->method('execute')
            ->with(['name' => 'foo', 'other'=> 'bar'])
            ->willThrowException(new \PDOException("Error on execute"));

        $connection->expects($this->once())
            ->method('prepare')
            ->with('INSERT INTO user (name,other)  VALUES (:name,:other)')
            ->willReturn($stm);

        $db->setConnection($connection);

        $insert = new \Guestbook\Db\Statement\InsertStatement(
            'user',
            ['name' => 'foo', 'other'=> 'bar']
        );
        $db->insert($insert);
    }

    public function testInsertErrorPrepare(): void {
        $this->expectException(DbException::class);
        $db = new MySQLPdoDb(
            'localhost',
            3306,
            'user',
            'password',
            'guestbook'
        );

        $connection = $this->getMockBuilder(\PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $connection->expects($this->once())
            ->method('prepare')
            ->with('INSERT INTO user (name,other)  VALUES (:name,:other)')
            ->willThrowException(new \PDOException("Error on prepare"));

        $db->setConnection($connection);

        $insert = new \Guestbook\Db\Statement\InsertStatement(
            'user',
            ['name' => 'foo', 'other'=> 'bar']
        );
        $db->insert($insert);
    }

    public function testSelectSuccess(): void {
        $db = new MySQLPdoDb(
            'localhost',
            3306,
            'user',
            'password',
            'guestbook'
        );

        $connection = $this->getMockBuilder(\PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stm = $this->getMockBuilder(\PDOStatement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stm->expects($this->once())
            ->method('execute')
            ->with(['id' => 1, 'score'=> 11])
            ->willReturn(true);

        $stm->expects($this->once())
            ->method('fetchAll')
            ->with(\PDO::FETCH_CLASS)
            ->willReturn(['name'=>'foo', 'other'=> 'bar']);

        $connection->expects($this->once())
            ->method('prepare')
            ->with('SELECT name,other FROM user  WHERE id != :id AND score > :score ')
            ->willReturn($stm);

        $db->setConnection($connection);

        $select = new \Guestbook\Db\Statement\SelectStatement(
            'user',
            ['name', 'other'],
        );
        $select->addCriteria('id', '!=', 1);
        $select->addCriteria('score', '>', 11);

        try {
            $this->assertEquals(['name'=>'foo', 'other'=> 'bar'], $db->select($select));
        } catch (DbException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testSelectErrorExecute(): void {
        $this->expectException(DbException::class);
        $db = new MySQLPdoDb(
            'localhost',
            3306,
            'user',
            'password',
            'guestbook'
        );
        $connection = $this->getMockBuilder(\PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stm = $this->getMockBuilder(\PDOStatement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stm->expects($this->once())
            ->method('execute')
            ->with(['id' => 1, 'score'=> 11])
            ->willThrowException(new \PDOException("Error on execute"));

        $connection->expects($this->once())
            ->method('prepare')
            ->with('SELECT name,other FROM user  WHERE id != :id AND score > :score ')
            ->willReturn($stm);

        $db->setConnection($connection);

        $select = new \Guestbook\Db\Statement\SelectStatement(
            'user',
            ['name', 'other'],
        );
        $select->addCriteria('id', '!=', 1);
        $select->addCriteria('score', '>', 11);

        $db->select($select);
    }

    public function testSelectErrorPrepare(): void
    {
        $this->expectException(DbException::class);
        $db = new MySQLPdoDb(
            'localhost',
            3306,
            'user',
            'password',
            'guestbook'
        );
        $connection = $this->getMockBuilder(\PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $connection->expects($this->once())
            ->method('prepare')
            ->with('SELECT name,other FROM user  WHERE id != :id AND score > :score ')
            ->willThrowException(new \PDOException("Error on execute"));

        $db->setConnection($connection);

        $select = new \Guestbook\Db\Statement\SelectStatement(
            'user',
            ['name', 'other'],
        );
        $select->addCriteria('id', '!=', 1);
        $select->addCriteria('score', '>', 11);

        $db->select($select);
    }

}
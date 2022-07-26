<?php

namespace Guestbook\Test\Model\Comment;

use Guestbook\Db\Db;
use Guestbook\Db\DbException;
use Guestbook\Model\Comment\CommentRepository;
use PHPUnit\Framework\TestCase;

class CommentRepositoryTest extends TestCase
{
    public function testCreateSuccess(): void {
        $nowString = date('Y-m-d H:i:s');
        $data = ['guest' => 'my name', 'message' => 'hello', 'created' => $nowString];
        $mockDb = $this->getMockBuilder(Db::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fieldsValues = ['name' => 'foo', 'other'=> 'bar'];
        $statement = new \Guestbook\Db\Statement\InsertStatement(
            'comment',
            $data
        );

        $mockDb->expects($this->once())
            ->method('insert')
            ->with($this->equalTo($statement))
            ->willReturn(3);

        $repository = new CommentRepository($mockDb);
        try {
            $comment = $repository->create($data);
            $this->assertEquals(3, $comment->getId());
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testFetchAll(): void {
        $mockDb = $this->getMockBuilder(Db::class)
            ->disableOriginalConstructor()
            ->getMock();

        $statement = new \Guestbook\Db\Statement\SelectStatement(
            'comment',
            ['*'],
            'id',
            'desc'
        );

        $mockDb->expects($this->once())
            ->method('select')
            ->with($this->equalTo($statement))
            ->willReturn([['message' => 'hello', 'guest' => 'my name', 'created' => date('Y-m-d H:i:s')]]);

        $repository = new CommentRepository($mockDb);
        try {
            $result = $repository->fetchAll('id', 'desc');
            $this->assertNotEmpty($result);
            $this->assertEquals(1, $result->getIterator()->count());
            $this->assertEquals('hello', $result->getIterator()->current()->getData()['message']);
        } catch (DbException $e) {
            $this->fail($e->getMessage());
        }

    }

}
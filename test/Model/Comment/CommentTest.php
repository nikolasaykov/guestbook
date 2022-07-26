<?php

namespace Guestbook\Test\Model\Comment;

use Guestbook\Model\Comment\Comment;
use Guestbook\Model\EntityException;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testSetDataError(): void {
        $this->expectException(EntityException::class);
        $comment = new Comment();
        $comment->setData(['id' => 1, 'guest' => 'my name', 'message' => 'hello', 'created' => 'invalid']);
    }

    public function testGetData(): void {
        $comment = new Comment();
        $nowString = date('Y-m-d H:i:s');
        try {
            $comment->setData(['id' => 1, 'guest' => 'my name', 'message' => 'hello', 'created' => $nowString]);
            $this->assertEquals(
                ['guest' => 'my name', 'message' => 'hello', 'created' => $nowString,],
                $comment->getData()
            );
        } catch (EntityException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testGetGetInputFields(): void {
        $comment = new Comment();
        $this->assertEquals(['guest', 'message'], $comment->getInputFields());
    }

}
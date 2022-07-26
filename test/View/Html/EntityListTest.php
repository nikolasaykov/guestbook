<?php

namespace Guestbook\Test\View\Html;

use Guestbook\Model\Comment\Comment;
use Guestbook\Model\EntitiesCollection;
use Guestbook\Model\EntityException;
use Guestbook\View\Html\EntityList;
use PHPUnit\Framework\TestCase;

class EntityListTest extends TestCase
{
    public function testRender(): void {
        $nowString = date('Y-m-d H:i:s');
        $data = ['guest' => 'my name', 'message' => 'hello', 'created' => $nowString];
        $expectedHtml = '<div><div>'.
            '<div><b>guest:</b></div><div>'.$data['guest'].'</div>'.
            '<div><b>message:</b></div><div>'.$data['message'].'</div>'.
            '<div><b>created:</b></div><div>'.$nowString.'</div>'.
            '</div><br></div>';

        $comment = new Comment();
        try {
            $comment->setData($data);
        } catch (EntityException $e) {
            $this->fail($e->getMessage());
        }
        $comments = new EntitiesCollection($comment);
        $commentsList = new EntityList();

        $this->assertEquals($expectedHtml, $commentsList->render($comments));

    }

}
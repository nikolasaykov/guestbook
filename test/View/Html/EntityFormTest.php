<?php

namespace Guestbook\Test\View\Html;

use Guestbook\Model\Comment\Comment;
use Guestbook\View\Html\EntityForm;
use PHPUnit\Framework\TestCase;

class EntityFormTest extends TestCase
{

    public function testRender(): void {
        $expectedHtml = '<form action="index.php" method="post">'.
            '<label for="guest">guest: </label><input type="text" name="guest" id="guest"><br>'.
            '<label for="message">message: </label><input type="text" name="message" id="message"><br>'.
            '<input type="submit" value="Post"></form>';

        $form = new EntityForm();
        $this->assertEquals($expectedHtml, $form->render(new Comment(), 'index.php'));
    }

}
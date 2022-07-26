<?php

namespace Guestbook\Test\View\Html;

use Guestbook\View\Html\Pagination;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    public function testRender(): void {
        $expectedHtml = '<div>'.
            '<span>Pages:</span><a href="index.php?page=1"><b>1</b></a>&nbsp;<a href="index.php?page=2">2</a>&nbsp;'.
            '</div>';
        $pagination = new Pagination();
        $this->assertEquals(
            $expectedHtml,
            $pagination->render(10, 5, 1, 'index.php')
        );
    }

}
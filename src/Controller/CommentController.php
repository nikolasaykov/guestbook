<?php

namespace Guestbook\Controller;

use Guestbook\Db\DbException;
use Guestbook\Model\Comment\CommentRepository;

class CommentController extends BaseController
{
    /**
     * @var int For list rendering
     */
    private int $entriesPerPage = 1;

    /**
     * @var CommentRepository
     */
    private CommentRepository $repository;

    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): void
    {
        try {
            $currentPage = 1;
            if ($this->getParam('page')) {
                $currentPage = $this->getParam('page');
            }

            $comments = $this->repository->fetchAll(
                'id',
                'DESC',
                $this->entriesPerPage,
                $this->entriesPerPage * ($currentPage - 1)
            );

            $commentsList = new \Guestbook\View\Html\EntityList();
            $comment = new \Guestbook\Model\Comment\Comment();
            $commentForm = new \Guestbook\View\Html\EntityForm();
            $pagination = new \Guestbook\View\Html\Pagination();

            print $commentsList->render($comments);
            print $commentForm->render($comment, 'index.php');
            print $pagination->render(
                $this->repository->entitiesCount(),
                $this->entriesPerPage, $currentPage, 'index.php'
            );
        } catch (\Guestbook\Db\DbException $dbe) {
            print_r($dbe->getMessage());
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function add(): void
    {
        try {
            if ($this->getParam('guest') && $this->getParam('message')) {
                $data = [
                    'created' => date('Y-m-d H:i:s'),
                    'guest' => $this->getParam('guest'),
                    'message' => $this->getParam('message')
                ];
                $this->repository->create($data);
            }
        } catch (\Guestbook\Db\DbException $dbe) {
            print_r($dbe->getMessage());
        } catch (\Guestbook\Model\EntityException $ee) {
            print_r($ee->getMessage());
        }
    }
}
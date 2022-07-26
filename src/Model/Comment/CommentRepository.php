<?php

namespace Guestbook\Model\Comment;

use Guestbook\Db\DbException;
use Guestbook\Db\Statement\InsertStatement;
use Guestbook\Db\Statement\SelectStatement;
use Guestbook\Model\EntitiesCollection;
use Guestbook\Model\Entity;
use Guestbook\Model\EntityException;
use Guestbook\Model\EntityRepository;

class CommentRepository extends EntityRepository
{
    protected string $dbTableName = 'comment';

    /**
     * @throws \Guestbook\Model\EntityException
     * @throws DbException
     */
    public function create(array $data): Entity
    {
        $statement = new InsertStatement($this->dbTableName, $data);
        $id = $this->db->insert($statement);
        $data['id'] = $id;
        $comment = new Comment();
        $comment->setData($data);
        return $comment;
    }

    /**
     * @throws DbException
     */
    public function fetchAll(string $orderBy, string $orderDirection, int $limit = 0, int $offset = 0): EntitiesCollection
    {
        $entities = array();
        $select = new SelectStatement($this->dbTableName, ['*'], $orderBy, $orderDirection, $limit, $offset);
        $result = $this->db->select($select);
        foreach ($result as $data) {
            try {
                $comment = new Comment();
                $comment->setData((array)$data);
                $entities[] = $comment;
            } catch (EntityException $e) {
                // ignore
            }
        }

        return new EntitiesCollection(...$entities);
    }
}
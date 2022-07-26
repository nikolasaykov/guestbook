<?php

namespace Guestbook\Model;

use Guestbook\Db\Db;
use Guestbook\Db\DbException;
use Guestbook\Db\Statement\SelectStatement;

abstract class EntityRepository
{
    protected Db $db;

    protected string $dbTableName;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    /**
     * @param array $data
     * @return Entity
     * @throws DbException
     */
    abstract public function create(array $data): Entity;

    /**
     * @param string $orderBy
     * @param string $orderDirection
     * @param int $limit
     * @param int $offset
     * @return EntitiesCollection
     * @throws DbException
     */
    abstract public function fetchAll(
        string $orderBy,
        string $orderDirection,
        int    $limit = 0,
        int    $offset = 0
    ): EntitiesCollection;

    /**
     * @return int
     */
    public function entitiesCount(): int
    {
        try {
            $countStatement = new SelectStatement($this->dbTableName, ['*']);
            $result = $this->db->select($countStatement);
            return count($result);
        } catch (DbException) {
            return 0;
        }
    }
}
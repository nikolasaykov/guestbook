<?php

namespace Guestbook\Db;

use Guestbook\Db\Statement\InsertStatement;
use Guestbook\Db\Statement\SelectStatement;

class MySQLPdoDb extends Db
{
    private ?\PDO $connection;

    function insert(InsertStatement $statement): int
    {
        $this->validate();
        $prepValues = $statement->createValuesClause(Db::ADAPTER_EXTENSION_PDO);
        try {
            $stm = $this->connection->prepare(sprintf('%s %s', $statement->baseSql(), $prepValues));
            if ($stm === false || $stm->execute($statement->getFieldsAndValues()) === false) {
                throw new \PDOException("Can not prepare or execute Statement");
            }
            return $this->connection->lastInsertId();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    /**
     * @param SelectStatement $statement
     * @return array
     * @throws DbException
     */
    function select(SelectStatement $statement): array
    {
        $this->validate();
        $prepWhere = $statement->createWhereClause(Db::ADAPTER_EXTENSION_PDO);
        $prepFilter = $statement->createFilterClause();

        try {
            $stm = $this->connection->prepare(sprintf('%s %s %s', $statement->baseSql(), $prepWhere, $prepFilter));
            if ($stm === false || $stm->execute($statement->getFieldsAndValues()) === false) {
                throw new \PDOException("Can not prepare or execute Statement");
            }
            return $stm->fetchAll(\PDO::FETCH_CLASS);
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function migrate(string $query): void
    {
        $this->validate();
        $this->connection->exec($query);
    }

    public function init(): void
    {
        if (!isset($this->connection)) {
            $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s', $this->host, $this->port, $this->dbName);
            $this->connection = new \PDO($dsn, $this->user, $this->password);
        }
    }

    /**
     * For mocking and testing.
     * @param \PDO $connection
     * @return void
     */
    public function setConnection(\PDO $connection): void {
        $this->connection = $connection;
    }

    /**
     * @return void
     * @throws DbException
     */
    private function validate(): void {
        if (!isset($this->connection)) {
            throw new DbException("Connection not set. Use init()");
        }
    }
}
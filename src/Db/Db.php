<?php

namespace Guestbook\Db;

use Guestbook\Db\Statement\InsertStatement;
use Guestbook\Db\Statement\SelectStatement;

abstract class Db
{
    /**
     * @var string
     */
    protected string $host;
    /**
     * @var int
     */
    protected int $port;
    /**
     * @var string
     */
    protected string $user;
    /**
     * @var string
     */
    protected string $password;

    /**
     * @var string
     */
    protected string $dbName;

    const ADAPTER_EXTENSION_PDO = 'MySQL_PDO';
    /**
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $password
     * @param string $dbName
     */

    public function __construct(
        string $host,
        int $port,
        string $user,
        string $password,
        string $dbName
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->dbName = $dbName;
    }

    /**
     * @return void
     * @throws DbException
     */
    abstract public function init(): void;

    /**
     * @param InsertStatement $statement
     * @return int
     * @throws DbException
     */
    abstract function insert(InsertStatement $statement): int;

    /**
     * @param SelectStatement $statement
     * @return array
     * @throws DbException
     */
    abstract public function select(SelectStatement $statement): array;

    /**
     * @param string $query
     * @return void
     * @throws DbException
     */
    abstract public function migrate(string $query): void;

}
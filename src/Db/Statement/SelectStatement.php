<?php

namespace Guestbook\Db\Statement;

use Guestbook\Db\Db;

class SelectStatement extends Statement
{

    /**
     * @var array
     */
    protected array $fields;

    /**
     * @var array
     */
    protected array $fieldsAndValues;

    /**
     * @var array
     */
    protected array $criteria;

    /**
     * @var string
     */
    protected string $orderBy;

    /**
     * @var string
     */
    protected string $orderDirection;

    /**
     * @var int
     */
    protected int $limit;

    /**
     * @var int
     */
    protected int $offset;

    public function __construct(
        string $tableName,
        array  $fields,
        string $orderBy = '',
        string $orderDirection = '',
        int    $limit = 0,
        int    $offset = 0
    )
    {
        $this->tableName = $tableName;
        $this->fields = $fields;
        $this->orderBy = $orderBy;
        $this->orderDirection = $orderDirection;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->criteria = array();
    }

    public function baseSql(): string
    {
        $selectFieldsString = implode(',', $this->fields);
        return sprintf('SELECT %s FROM %s', $selectFieldsString, $this->tableName);
    }

    /**
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @return void
     */
    public function addCriteria(string $field, string $operator, mixed $value): void
    {
        $this->criteria[] = [
            'field' => $field,
            'operator' => $operator,
            'value' => $value
        ];
    }

    public function getFieldsAndValues(): array
    {
        return $this->fieldsAndValues;
    }

    public function createWhereClause(string $extension = Db::ADAPTER_EXTENSION_PDO): string
    {
        $fieldsAndValues = array();
        $where = '';
        if ($extension == Db::ADAPTER_EXTENSION_PDO) {
            // works only with pdo for now
            if (!empty($this->criteria)) {
                $where .= ' WHERE ';
            }
            foreach ($this->criteria as $i => $criteria) {
                $where .= sprintf('%s %s :%s', $criteria['field'], $criteria['operator'], $criteria['field']);
                if ($i < count($this->criteria) - 1) {
                    $where .= ' AND ';
                }
                $fieldsAndValues[$criteria['field']] = $criteria['value'];
            }
            $this->fieldsAndValues = $fieldsAndValues;
        }

        return $where;
    }

    public function createFilterClause(): string {
        $filterClause = '';
        if (!empty($this->orderBy)) {
            $filterClause .= ' ORDER BY ' . $this->orderBy;
            if (!empty($this->orderDirection) && in_array(strtolower($this->orderDirection), ['asc', 'desc'])) {
                $filterClause .= ' ' .$this->orderDirection;
            }
        }

        if ($this->limit > 0) {
            $filterClause .= ' LIMIT ' . $this->limit;
            if ($this->offset >= 0) {
                $filterClause .= ' OFFSET ' . $this->offset;
            }
        }

        return $filterClause;
    }

}
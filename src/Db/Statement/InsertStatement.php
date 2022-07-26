<?php

namespace Guestbook\Db\Statement;

use Guestbook\Db\Db;

class InsertStatement extends Statement
{
    /**
     * @var array
     */
    protected array $fieldsAndValues;

    public function __construct(string $tableName, array $fieldsAndValues) {
        $this->tableName = $tableName;
        $this->fieldsAndValues = $fieldsAndValues;
    }

    public function baseSql(): string
    {
        $insertFieldsString = implode(',', array_keys($this->fieldsAndValues));
        return sprintf('INSERT INTO %s (%s)', $this->tableName, $insertFieldsString);
    }

    public function createValuesClause(string $extension = Db::ADAPTER_EXTENSION_PDO): string {
        $valuesClause = '';
        if ($extension == Db::ADAPTER_EXTENSION_PDO) {
            $prepFields = array_keys($this->fieldsAndValues);
            foreach ($prepFields as $i => $field) {
                $prepFields[$i] = ':' . $field;
            }
            $valuesClause = implode(',', $prepFields);
            if (!empty($valuesClause)) {
                $valuesClause = ' VALUES (' . $valuesClause . ')';
            }
        }

        return $valuesClause;
    }

    public function getFieldsAndValues(): array {
        return $this->fieldsAndValues;
    }
}
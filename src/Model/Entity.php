<?php

namespace Guestbook\Model;

abstract class Entity
{
    /**
     * @var array Table fields names
     */
    protected array $dataFields;

    /**
     * @var array Fields to be set from outside
     */
    protected array $inputFields;

    /**
     * @var int|mixed Primary key
     */
    protected int $id;


    /**
     * @var array Table data fields except 'id'
     */
    protected array $data;

    /**
     * Validate entities values before storing
     * @param $data
     * @throws EntityException
     * @return void
     */
    abstract protected function validate($data): void;

    /**
     * Init an entity with data
     * @param array $data
     * @throws EntityException
     * @return void
     */
    public function setData(array $data): void {
        $this->validate($data);
        foreach ($data as $key => $value) {
            if ($key == 'id') {
                $this->id = $value;
                unset($data['id']);
            } else if (!in_array($key, $this->dataFields)) {
                unset($data[$key]);
            }
        }
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getInputFields(): array
    {
        return $this->inputFields;
    }

    /**
     * To see if entry exists
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

}
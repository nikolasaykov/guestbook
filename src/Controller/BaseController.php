<?php

namespace Guestbook\Controller;

abstract class BaseController
{
    protected array $params = array();

    /**
     * @param string $key
     * @return void
     */
    public function getParam(string $key) {
        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }
        return null;
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function addParam(string $key, mixed $value): void {
        $this->params[$key] = $value;
    }

}
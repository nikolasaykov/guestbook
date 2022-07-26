<?php

namespace Guestbook\Model\Comment;

use Guestbook\Model\Entity;
use Guestbook\Model\EntityException;

class Comment extends Entity
{
    protected array $dataFields = ['guest', 'message', 'created'];

    protected array $inputFields = ['guest', 'message'];

    protected function validate($data): void
    {
        if (!array_key_exists('created', $data)) {
          throw new EntityException('Missing created date time field');
        } else {
            $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $data['created']);
           if (!($datetime && $datetime->format('Y-m-d H:i:s') === $data['created'])) {
               throw new EntityException('Invalid created date time field');
           }
        }

        if (!array_key_exists('message', $data) || empty($data['message'])) {
            throw new EntityException('Missing message field');
        } else if (!is_string($data['message'])) {
            throw new EntityException('Invalid message field');
        }

        if (!array_key_exists('guest', $data) || empty($data['guest'])) {
            throw new EntityException('Missing guest field');
        } else if (!is_string($data['guest']) || strlen($data['guest']) > 50) {
            throw new EntityException('Invalid guest field');
        }
    }
}
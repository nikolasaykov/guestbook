<?php

namespace Guestbook\View\Html;

use Guestbook\Model\Entity;

class EntityForm
{
    /**
     * @param Entity $entity
     * @param string $uri
     * @return string
     */
    public function render(Entity $entity, string $uri): string {
        $view = '<form action="' . $uri .'" method="post">';
        foreach ($entity->getInputFields() as $field) {
            $view .= '<label for="'. $field .'">'. $field. ': </label>';
            $view .= '<input type="text" name="'. $field .'" id="'. $field .'">';
            $view .= '<br>';
        }
        $view .= '<input type="submit" value="Post">';
        $view .= '</form>';

        return $view;
    }

}
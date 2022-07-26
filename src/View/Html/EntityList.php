<?php

namespace Guestbook\View\Html;

use Guestbook\Model\EntitiesCollection;

class EntityList
{
    /**
     * @param EntitiesCollection $collection
     * @return string
     */
    public function render(EntitiesCollection $collection): string {
        $view = '<div>';
        foreach ($collection as $entity) {
            $view .= '<div>';
            foreach ($entity->getData() as $key => $value) {
                $view .= '<div><b>' . $key . ':</b></div>';
                $view .= '<div>' . $value . '</div>';
            }
            $view .= '</div><br>';
        }
        $view .= '</div>';

        return $view;
    }

}
<?php

namespace Guestbook\View\Html;

class Pagination
{
    /**
     * @param int $entries
     * @param int $entriesPerPage
     * @param int $currentPage
     * @param string $uri
     * @return string
     */
    public function render(int $entries, int $entriesPerPage, int $currentPage, string $uri): string {
        $pages = ceil($entries/$entriesPerPage);
        $view = '<div><span>Pages:</span>';
        for ($i = 1; $i <= $pages; $i++) {
            if ($i == $currentPage) {
                $view .= '<a href="' . $uri . '?page='. $i. '"><b>' . $i . '</b></a>&nbsp;';
            } else {
                $view .= '<a href="' . $uri . '?page='. $i. '">' . $i . '</a>&nbsp;';
            }
        }
        $view .= '</div>';
        return $view;
    }

}
<?php
/**
* pagination.php
* Generates pagination
*
* @author Vishal Ravi Shankar <vshankar@mail.sfsu.edu> * 
*/

class Pagination
{

    public function __construct()
    {

    }

    /**
    * finds offset
    * @param int $page
    * @param int $limit
    * @return int offset
    */
    public function offset($page, $limit)
    {
        if (! ctype_digit((string)$page) || ! ctype_digit((string)$limit))
        {
            return 0;
        }
        return ($page - 1) * $limit;
    }

    /**
    * generates html
    * @param int $page
    * @param int $total_pages
    * @return string $html
    */
    public function html($page, $total_pages)
    {
        if(
            ! ctype_digit( (string)$page )
            || ! ctype_digit( (string)$total_pages )
            || $page > $total_pages
        ){
            return false;
        }

        $html = '<nav><ul class="pager">';

        // no 'prev' for first page
        if ($page > 1)
        {
            $html .= '<li><a href="?page='.($page - 1).'" rel="previous">Previous</a></li>';
        }

        // no 'next' for last page
        if ($page < $total_pages)
        {
            $html .= '<li><a href="?page='.($page + 1).'" rel="next">Next</a>';
        }

        $html .= '</ul></nav>';

        return $html;
    }

}
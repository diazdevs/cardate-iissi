<?php

/**
 * Slices an array by limit and current page
 */
class Paginator {

    public $page;
    public $limit;
    public $elements;

    public function __construct($elements, $limit=0){
        $this->elements = $elements;
        $this->limit = $limit;

        if (isset($_GET['page']) && is_numeric($_GET['page'])){
            $this->page = $_GET['page'];
        } else {
            $this->page = 1;
        }
        
    }

    public function getCurrentPage(){
        return array_slice($this->elements, ($this->page - 1)*$this->limit, ($this->page - 1)*$this->limit + $this->limit);
    }
}
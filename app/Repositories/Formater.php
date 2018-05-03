<?php

namespace App\Repositories;
 
class Formater 
{
	protected $queryBuilder;

	protected $offset;

	protected $limit;

    public function __construct($queryBuilder) {

    	$this->queryBuilder = $queryBuilder;
    }

    public function withPagination()
    {
    	$this->offset = \Request::get("cursor")['offset'];
    	$this->limit = \Request::get("cursor")['limit'];
    }


    public function get()
    {
    	return $this->queryBuilder
    		->offset($this->offset)
    		->limit($this->limit)->get();
    }
}

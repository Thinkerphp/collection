<?php

namespace Thinkerphp\Collection;


class Collection{

    protected $items = array();


    public function __construct(Array $items = array()){
        $this->items = $items;
    }

    public static function make($items){
        if (is_null($items)) return new static;
        if ($items instanceof Collection) return $items;
        return new static(is_array($items) ? $items : array($items));
    }

    public function each(Closure $callback){
        array_map($callback, $this->items);
        return $this;
    }

    public function map(Closure $callback){
        return new static(array_map($callback, $this->items));
    }

    public function filter(Closure $callback){
        return new static(array_filter($this->items, $callback));
    }

    public function sort(Closure $callback){
        uasort($this->items, $callback);
        return $this;
    }

    public function forget($key){
        unset($this->items[$key]);
    }

    public function pop(){
        return array_pop($this->items);
    }

}

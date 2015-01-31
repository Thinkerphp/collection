<?php

namespace Thinkerphp;

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

    public function each(\Closure $callback){
        array_map($callback, $this->items);
        return $this;
    }

    public function map(\Closure $callback){
        return new static(array_map($callback, $this->items, array_keys($this->items)));
    }

    public function filter(\Closure $callback){
        return new static(array_filter($this->items, $callback));
    }

    public function sort(\Closure $callback){
        usort($this->items, $callback);
        return $this;
    }

    public function forget($key){
        unset($this->items[$key]);
    }

    public function pop(){
        return array_pop($this->items);
    }

    public function sum($callback = null){

        if (is_null($callback))
        {
            return array_sum($this->items);
        }

        if(is_callable($callback)){
            $sum = 0;

            $this->each(function($value) use ($callback, &$sum){
                $sum += $callback($value);
            });

            return $sum;
        }

        return null;      
    }

    public function count(){
        return count($this->items);
    }

    public function toArray(){
        return $this->items;
    }

    public function toJson(){
        return json_encode($this->items);
    }

}

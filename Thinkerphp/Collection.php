<?php

namespace Thinkerphp;

use \Closure;
use \Countable;
use \ArrayAccess;

class Collection implements Countable, ArrayAccess{

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
        return new static(array_map($callback, $this->items, array_keys($this->items)));
    }

    public function first(){
        reset($this->items);
        return current($this->items);
    }

    public function filter(Closure $callback){
        return new static(array_filter($this->items, $callback));
    }

    public function sort(Closure $callback){
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

    public function reverse(){
        return new static(array_reverse($this->items));
    }   

    public function shuffle(){
        shuffle($this->items);
        return $this;
    } 

    public function paginate($page, $perPage){
        return new static(array_slice($this->items, ($page - 1) * $perPage, $perPage));
    }

    public function count(){
        return count($this->items);
    }

    public function isEmpty(){
        return count($this->items) === 0;
    }   

    public function all(){
        return $this->items;
    } 

    public function get($key, $default = null){
        if($this->offsetExists($key)){
            return $this->offsetGet($key);
        }
        return $default;
    }

    public function offsetExists($key){
        return array_key_exists($key, $this->items);
    }    

    public function offsetGet($key){
        return $this->items[$key];
    }   

    public function offsetSet($key, $value){
        if (is_null($key)){
            $this->items[] = $value;
        }else{
            $this->items[$key] = $value;
        }
    }    

    public function offsetUnset($key){
        unset($this->items[$key]);
    }     

    public function toArray(){
        return $this->items;
    }

    public function toJson(){
        return json_encode($this->items);
    }

    public function jsonSerialize(){
        return $this->toArray();
    }    

    public function __toString(){
        return $this->toJson();
    }

}

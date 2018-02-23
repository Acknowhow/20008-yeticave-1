<?php
class ArrayValue {
    public function __construct($key, $arr)
    {
        $this->key = $key;
        $this->arr = $arr;
        $this->value = [];
    }
    private function retrieve()
    {
        $this->value = $this->arr[$this->key] ?
            $this->arr[$this->key] : 'undefined';
        return $this->value;
    }

    public function get()
    {
        if(empty($this -> value)) {
            $this->value = $this->retrieve();
        }
        return $this->value;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: mtg
 * Date: 2017/12/12
 * Time: 14:46
 */
class ChocolateBoiler{//巧克力锅炉
    
    private $empty;
    private $boiled;
    private static  $instance;
    
    private function __construct(){
        $this->empty = true;
        $this->boiled = false;
    }

    public static function getInstance(){
        if (static::$instance == null){
            static::$instance = new static();
        }

        return static::$instance;
    }
    public function isEmpty(){
        return $this->empty;
    }
    
    function fill () {
        if ($this->isEmpty()){
            $this->empty = false;
        }
    }

    public function isBoiled(){
        return $this->boiled;
    }

    public function drain(){ //排出
        if (!$this->isEmpty() && isBoiled()){
            $this->empty = true;
        }
    }

    public function boil(){ //煮沸

        if (!$this->isEmpty() && !$this->isBoiled())
            $this->boiled = true;
    }
    
}
$temp = ChocolateBoiler::getInstance();
<?php
abstract class Pizza{}
class CheesePizza extends Pizza {}
class PepperonPizza extends Pizza{}
class VeggiePizza extends Pizza{}
//简单工厂
class SimplePizzaFactory {

    protected  $pizza;

    public function createPizza(String $type){
        switch ($type){
            case 'cheese':
                $this->pizza = new CheesePizza;
                break;
            case 'pepperoni':
                $this->pizza = new PepperonPizza;
                break;
            case 'veggie':
                $this->pizza = new VeggiePizza;
                break;
            default:
                echo 'pizza not exsit';
        }
        if ($this->pizza instanceof Pizza){
            return $this->pizza;
        }else{
            return 'pizza not exsit';
        }
    }
}

class PizzaStore{

    protected  $factory;

    public function __construct(SimplePizzaFactory $factory){
        $this->factory = $factory;
    }

    public function orderPizza($type){
       $pizza =  $this->factory->createPizza($type);
       $pizza->prepare();
       //披萨的一系列操作
    }
}
<?php

//抽象工厂模式
interface PizzaIngredientFactory{ //披萨原料工厂接口
    function createDough(); //面团
    function createSauce(); //酱料
    function createCheese(); //芝士
    function createVeggies(); //蔬菜
    function createPepperoni(); //腊肠
    function createClam(); //蛤蜊
}

class NYPizzaIngredientFactory implements PizzaIngredientFactory{
    public function createDough(){
        return new ThinCrustDough();
    }

    public function createSauce(){
        return new MarinaraSauce();
    }

    public function createCheese(){
        return new Reggianocheese();
    }

    public function createVeggies(){
        return [new Garlic(), new Onion(), new Mushroom(), new RedPepper() ];
    }

    public function createPepperoni(){
        return new SlicedPepperoni();
    }

    public function createClam(){
        return new FreshClams();
    }
    
}

abstract class Pizza{

    protected $name;
    protected $dough;//面团
    protected $sauce;//酱料
    protected $veggies;
    protected $cheese;
    protected $pepperoni;
    protected $clam;


    abstract  function prepare();

    function bake(){
        echo 'bake';
        echo "</br>";
    }

    function cut(){
        echo 'cut';
        echo "</br>";
    }
    function box(){
        echo 'box';
        echo "</br>";
    }
    public function setName(String $name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }
}

class CheesePizza extends  Pizza{ //每个芝士的子类只有原料不同
    protected $ingredientFactory;

    function __construct (PizzaIngredientFactory $ingredientFactory)
    {
        $this->ingredientFactory = $ingredientFactory;
    }
    public function prepare(){
        $this->dough = $this->ingredientFactory->createDough() ;
        $this->sauce = $this->ingredientFactory->createSauce() ;
        $this->veggies = $this->ingredientFactory->createVeggies() ;
        $this->cheese = $this->ingredientFactory->createCheese() ;
        $this->pepperoni = $this->ingredientFactory->createPepperoni() ;
        $this->clam = $this->ingredientFactory->createClam() ;
    }
}


abstract class  PizzaStore{

    protected  $pizza;

    public function orderPizza(String $type){

        $this->pizza = $this->createPizza($type);

        $this->pizza->prepare();
        $this->pizza->bake();
        $this->pizza->cut();

        $this->pizza->box();
        return $this->pizza;
    }

    public abstract function createPizza(String $type);//工厂方法
}

class NYPizzaStore extends  PizzaStore {

    public function createPizza(String $type){
        $ingredientFactory = new NYPizzaIngredientFactory();
        switch ($type){
            case 'cheese':
                $this->pizza = new CheesePizza($ingredientFactory);
                break;
            case 'pepperoni':
                $this->pizza = new  PepperonPizza($ingredientFactory);
                break;
            case 'veggie':
                $this->pizza = new VeggiePizza($ingredientFactory);
                break;
            default:
                echo 'pizza not exsit';
        }
        return $this->pizza;
    }
}

<?php
abstract class Pizza{

    protected $name;
    protected $dough;//面团
    protected $sauce;//酱料
    protected $toppings;//配料

     function prepare(){
         echo "prepare";
         echo "</br>";
         array_map(function($topping){
         echo "add {$topping}";
         },$this->toppings);
     }

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
}

class  NYStyleCheesePizza extends Pizza {
    public function __construct(){
        $this->name = 'NYStyleCheesePizza';
        $this->dough = 'thin crust dough';
        $this->sauce = 'marinara sauce';
        $this->toppings[] = 'grated reggiano cheese' ;

    }
}
class  NYStylePepperonPizza extends Pizza{}
class  NYStyleVeggiePizza extends Pizza{}

//工厂方法
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
        switch ($type){
            case 'cheese':
                $this->pizza = new  NYStyleCheesePizza;
                break;
            case 'pepperoni':
                $this->pizza = new  NYStylePepperonPizza;
                break;
            case 'veggie':
                $this->pizza = new  NYStyleVeggiePizza();
                break;
            default:
                echo 'pizza not exsit';
        }
        return $this->pizza;
    }
}

$pizzaStore = new NYPizzaStore();
$pizza = $pizzaStore->orderPizza('cheese');
dump($pizza);
exit;
<?php
abstract class Beverage{ //饮料父类

    protected  $description = "Unknown Beverage   ";

    public function getDescription(){
        return $this->description;
    }

    public  abstract function cost();

}

abstract  class  CondimentDecorator extends  Beverage{//调料装饰者父类

    protected $beverage;

    public function __construct(Beverage $beverage){
        $this->beverage = $beverage;
    }

    public  function getDescription(){

            return $this->beverage->getDescription().$this->description;
    }

}

class Espresso extends Beverage{ // 浓缩咖啡

    public function __construct(){
        $this->description = 'espresso   ';
    }
    public function cost(){
        return 1.99;
    }
}

class HouseBlend extends Beverage { // 日常咖啡

    public function __construct(){
        $this->description = 'house blend coffee   ';
    }

    public function cost(){
        return 0.89;
    }
 }

 class Mocha extends  CondimentDecorator{ // 摩卡调料

    protected $description = "mocha  ";

    public function cost(){
        return $this->beverage->cost()+0.20;
    }
}

class Whip extends  CondimentDecorator{ // 泡沫调料

    protected $description = "whip   ";

    public function cost(){
        return $this->beverage->cost()+0.10;
    }
}

$beverage = new Espresso();
$beverage = new Mocha($beverage);
$beverage = new Whip($beverage);

echo $beverage->cost();
echo "</br>";
echo $beverage->getDescription();

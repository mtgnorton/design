<?php

interface FlyBehavior{
    public function fly();
}

interface QuackBehavior{
    public function quack();
}

class FlyWithWings implements  FlyBehavior{
    public function fly(){
        echo "fly with wings";
        echo "</br>";
    }
}

class FlyNoWay implements FlyBehavior{
    public function fly(){
        echo 'cant fly';
        echo "</br>";
    }
}


class HasQuack implements QuackBehavior{
    public function quack(){
        echo "quack";
        echo "</br>";
    }
}
class MuteQuack implements QuackBehavior{
    public function quack(){
        echo "silence";
        echo "</br>";
    }
}

abstract  class Duck{

    protected  $flyBehavior;
    protected  $quackBehavior;

    public abstract function display();

    public function __construct(FlyBehavior $flyBehavior,QuackBehavior $quackBehavior){
        $this->flyBehavior = $flyBehavior;
        $this->quackBehavior = $quackBehavior;
    }

    public function setFlyBehavior(FlyBehavior $flyBehavior){

        $this->flyBehavior = $flyBehavior;

    }

    public function setQuackBehavior(QuackBehavior $quackBehavior){
        $this->quackBehavior = $quackBehavior;
    }

    public function performFly(){
        $this->flyBehavior->fly();
    }

    public function performQuack(){
        $this->quackBehavior->quack();
    }
    public function swim(){
        echo "all ducks can swim";
        echo "</br>";
    }
}

class  BlackDuck extends Duck{

    public function display(){
        echo "im a black duck";
        echo "</br>";
    }

}

$duck = new BlackDuck(new FlyWithWings,new HasQuack);

$duck->performFly();
$duck->performQuack();
$duck->display();
$duck->setFlyBehavior(new FlyNoWay);
$duck->performFly();

/*输出
 *  fly with wings
    quack
    im a black duck
    cant fly
*/

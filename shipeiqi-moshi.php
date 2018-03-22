<?php

interface Duck{ //目标接口
    function quack();
    function fly();
}

class MallardDuck implements Duck{
    public function quack(){
        echo "Quack";
        echo "</br>";
    }

    public function fly(){
        echo "i`m flying";
        echo "</br>";
    }
}

interface Turkey{//被适配者
    function gobble();
    function fly();
}

class WildTurkey implements Turkey{
    function gobble()
    {
        echo 'Gobble gobble';
        echo "</br>";
    }
    public function fly(){
        echo 'i`m flying a short distance';
        echo "</br>";
    }
}

class TurkeyAdapter implements Duck{ //适配器

    protected $turkey;

    public function __construct(Turkey $turkey){
        $this->turkey = $turkey;

    }

    public function fly(){
        for ($i = 0; $i<5; $i++){
            $this->turkey->fly();
        }
    }
    public function quack(){
        $this->turkey->gobble();
    }
}

     function testDuck(Duck $duck){ //客户
        $duck->quack();
        $duck->fly();
    }

    $turkey = new WildTurkey();
     $duck = new MallardDuck();

     testDuck($duck);
     $turkeyAdapter = new TurkeyAdapter($turkey);
     testDuck($turkeyAdapter);
<?php
//demo1
abstract class CaffeineBeverage
{
    final function prepareRecipe()
    {
        $this->boilWater();
        $this->brew();
        $this->pourInCup();
        if ($this->customerWantsCondiments())
            $this->addCondiments();
    }

    abstract function brew();

    abstract function addCondiments();

    public function boilWater()
    {
        echo 'boiling water';
        echo "</br>";
    }

    public function pourInCup()
    {
        echo 'pouring into cup';
        echo "</br>";
    }

    public function customerWantsCondiments()
    { //钩子
        return true;
    }
}

class Tea extends CaffeineBeverage
{
    public function brew()
    { //冲泡
        echo "steeping the tea";//浸泡茶
        echo "</br>";
    }

    public function addCondiments()
    {//加调料
        echo 'adding lemon';
        echo "</br>";
    }
}

class Coffee extends CaffeineBeverage
{
    public function brew()
    {
        echo 'dripping coffee through filter';//冲泡咖啡粉
        echo "</br>";
    }

    public function addCondiments()
    {
        echo 'adding sugar and Milk';
    }

    public function customerWantsCondiments($type)
    {
        if ($type == true)
            return true;
        return false;
    }

}

//demo2

class  Sort {

    public function toSort(Array $arr){
        $dest = [];
        $this->mergeSort($arr,$dest,0,count($arr),0);
    }


}
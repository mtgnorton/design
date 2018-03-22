<?php

class GumbalMachine {
    private  $soldOutState;
    private  $noQuarterState;
    private  $hasQuarterState;
    private  $soldState;
    private  $winnerState;

    private $state;
    private $count = 0;

    public function __construct($count){
        $this->soldOutState = new SoldOutState($this);
        $this->noQuarterState = new NoQuarterState($this);
        $this->hasQuarterState = new HasQuarterState($this);
        $this->soldState = new SoldState($this);
        $this->winnerState = new WinnerState($this);

        $this->count = $count;
        $this->state = $this->soldOutState;
        if ($count>0){
            $this->state =$this->noQuarterState;
        }
    }
    public function insetQuarter(){
        $this->state->insertQuarter();
    }
    public function ejectQuarter(){
        $this->state->ejectQuarter();
    }
    public function turnCrank(){
        $this->state->turnCrank();
        $this->state->dispence();
    }

    public function setState(State $state){
        $this->state = $state;
    }

    public function releaseBall(){
        if ($this->count != 0){
            $this->count -- ;
        }
    }

    /**
     * @return SoldState
     */
    public function getSoldState(): SoldState
    {
        return $this->soldState;
    }

    /**
     * @return HasQuarterState
     */
    public function getHasQuarterState(): HasQuarterState
    {
        return $this->hasQuarterState;
    }

    /**
     * @return NoQuarterState
     */
    public function getNoQuarterState(): NoQuarterState
    {
        return $this->noQuarterState;
    }

    /**
     * @return SoldOutState
     */
    public function getSoldOutState(): SoldOutState
    {
        return $this->soldOutState;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return mixed
     */
    public function getWinnerState()
    {
        return $this->winnerState;
    }


}

interface state{


    public  function insertQuarter();
    public  function ejectQuarter();
    public  function turnCrank();
    public  function dispence();

}


class NoQuarterState implements state{

    protected $gumbalMachine;

    public function __construct($gumbalMachine){
        $this->gumbalMachine = $gumbalMachine;
    }
    public function insertQuarter(){
        echo "放入钱成功";
        $this->gumbalMachine->setState($this->gumbalMachine->getHasQuarterState());
    }
    public function ejectQuarter(){
        echo "你没有放入过钱,无法退款";
    }
    public function turnCrank(){
        echo "没有钱,转动曲轴没有用";
    }
    public function dispence(){
        echo "请先放入钱";
    }
}

class HasQuarterState implements state{
    protected $gumbalMachine;
    protected $randomWinner;
    public function __construct($gumbalMachine){
        $this->gumbalMachine = $gumbalMachine;
        $this->randomWinner = mt_rand(1,10);
    }
    public function insertQuarter(){
        echo "你不能再次放入钱";
        $this->gumbalMachine->setState($this->gumbalMachine->getNoQuarterState());
    }
    public function ejectQuarter(){
        echo "退钱成功";
    }
    public function turnCrank(){
        echo "转动曲轴";
        if ($this->randomWinner == 10 && $this->gumbalMachine->getCount>1){
            $this->gumbalMachine->setState($this->gumbalMachine->getWinnerState());
        }else{
            $this->gumbalMachine->setState($this->gumbalMachine->getSoldState());

        }

    }
    public function dispence(){
        echo "没有糖果出来";
    }
}

class SoldState implements state{
    protected $gumbalMachine;

    public function __construct($gumbalMachine){
        $this->gumbalMachine = $gumbalMachine;
    }
    public function insertQuarter(){
        echo "有一个糖果正在售出,无法放入钱";
        $this->gumbalMachine->setState($this->gumbalMachine->getHasQuarterState());
    }
    public function ejectQuarter(){
        echo "糖果正在售出,无法退钱";
    }
    public function turnCrank(){
        echo "你已经转动曲轴了,不能再次转动";
    }
    public function dispence(){
     $this->gumbalMachine->releaseBall();
     if ($this->gumbalMachine->getCount()>0){
         $this->gumbalMachine->setState($this->gumbalMachine->getNoQuarterState());
     }else{
        echo "没有糖果了";
        $this->gumbalMachine->setState($this->gumbalMachine->getSoldOutState());
     }
    }
}


class SoldOutState implements state{
    protected $gumbalMachine;

    public function __construct($gumbalMachine){
        $this->gumbalMachine = $gumbalMachine;
    }
    public function insertQuarter(){
        echo "已经没有糖果了";
    }
    public function ejectQuarter(){
        echo "你没有放入过钱,无法退款";
    }
    public function turnCrank(){
        echo "没有钱,转动曲轴没有用";
    }
    public function dispence(){
        echo "请先放入钱";
    }


}
class WinnerState implements state
{
    protected $gumbalMachine;

    public function __construct($gumbalMachine)
    {
        $this->gumbalMachine = $gumbalMachine;
    }

    public function insertQuarter(){
        echo "有一个糖果正在售出,无法放入钱";
        $this->gumbalMachine->setState($this->gumbalMachine->getHasQuarterState());
    }
    public function ejectQuarter(){
        echo "糖果正在售出,无法退钱";
    }
    public function turnCrank(){
        echo "你已经转动曲轴了,不能再次转动";
    }

    public function dispence()
    {
        echo "你赢了这个游戏,你将获得两个糖果";
        $this->gumbalMachine->releaseBall();
        if ($this->gumbalMachine->getCount()==0){
            $this->gumbalMachine->setState($this->gumbalMachine->getSoldOutState());
        }else{
            $this->gumbalMachine->releaseBall();
            if ($this->gumbalMachine->getCount()>0){
                $this->gumbalMachine->setState($this->gumbalMachine->getNoQuarterState());
            }else{
                echo "没有糖果了";
                $this->gumbalMachine->setState($this->gumbalMachine->getSoldOutState());
            }
        }
    }
}

$gumbalMachine = new GumbalMachine(5);
$gumbalMachine->insetQuarter();
$gumbalMachine->turnCrank();

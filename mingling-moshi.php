<?php

interface Command{
    function execute();
    function undo();
}

class Light{

    protected $position;

    public function __construct(String $position){
        $this->position = $position;
    }
    public function off(){
        echo '关闭电灯';
        echo "</br>";
    }
    public function on(){
        echo '打开电灯';
        echo "</br>";
    }

}
class CeilingFan{
    const  HIGH =3;
    const LOW = 1;
    const OFF = 0;
    protected $position ;
    protected $speed;
    public function __construct(String $position){
        $this->position = $position;
    }
    public function high(){
        $this->speed = self::HIGH;
        echo "当前速度为{$this->speed}";
        echo "</br>";
    }
    public function low(){
        $this->speed = self::LOW;
        echo "当前速度为{$this->speed}";
        echo "</br>";

    }
    public function off(){
        $this->speed = self::OFF;
        echo "当前风扇关闭";
        echo "</br>";

    }
    public function getSpeed(){
        return $this->speed;
    }

}

class CeilingFanHighCommand implements Command{
    protected $ceilingFan;
    protected $prevSpeed;

    public function __construct(CeilingFan $ceilingFan){
        $this->ceilingFan = $ceilingFan;
    }

    public function execute(){
        $this->prevSpeed = $this->ceilingFan->getSpeed();
        $this->ceilingFan->high();
    }
    public function undo(){
        switch ($this->prevSpeed){
            case CeilingFan::HIGH :
                $this->ceilingFan->high();
                break;
            case CeilingFan::LOW :
                $this->ceilingFan->low();
                break;
            default :
                $this->ceilingFan->off();
        }
    }
}
class CeilingFanLowCommand implements Command{
    protected $ceilingFan;
    protected $prevSpeed;

    public function __construct(CeilingFan $ceilingFan){
        $this->ceilingFan = $ceilingFan;
    }

    public function execute(){
        $this->prevSpeed = $this->ceilingFan->getSpeed();
        $this->ceilingFan->low();
    }
    public function undo(){
        switch ($this->prevSpeed){
            case CeilingFan::HIGH :
                $this->ceilingFan->high();
                break;
            case CeilingFan::LOW :
                $this->ceilingFan->low();
                break;
            default :
                $this->ceilingFan->off();
        }
    }
}
class CeilingFanOffCommand implements Command{
    protected $ceilingFan;
    protected $prevSpeed;

    public function __construct(CeilingFan $ceilingFan){
        $this->ceilingFan = $ceilingFan;
    }

    public function execute(){
        $this->prevSpeed = $this->ceilingFan->getSpeed();
        $this->ceilingFan->off();
    }
    public function undo(){
        switch ($this->prevSpeed){
            case CeilingFan::HIGH :
                $this->ceilingFan->high();
                break;
            case CeilingFan::LOW :
                $this->ceilingFan->low();
                break;
            default :
                $this->ceilingFan->off();
        }
    }
}

class LightOnCommond implements Command{
    protected $light;

    public function __construct(Light $light){
        $this->light = $light;
    }
    function execute()
    {
        $this->light->on();

    }
    public function undo(){
        $this->light->off();
    }
}
class LightoffCommond implements Command{
    protected $light;

    public function __construct(Light $light){
        $this->light = $light;
    }
    function execute()
    {
        $this->light->off();

    }
    public function undo(){
        $this->light->on();
    }
}


//class SimpleRemoteControl{
//    protected $slot;
//
//    public function setCommand(Command $command){
//        $this->slot = $command;
//    }
//
//    public function buttonWasPressed(){
//        $this->slot->execute();
//}
//}
class NoCommand implements Command {
    public function execute(){
        echo "no command";
        echo "</br>";
    }
    public function undo(){
        
    }
};

class MacroCommand implements Command{
    protected $commands;

    public function __construct(Array $commands){
        $this->commands = $commands;
    }
    public function execute(){
        foreach ($this->commands as $command){
            $command->execute();
        }
    }
    public function undo(){
        foreach ($this->commands as $command) {
            $command->undo();
        }
    }
}
class RemoteControl{

    protected $onCommands;
    protected $offCommands;
    protected $undoCommand;

    public function __construct(){
        $noCommand = new NoCommand();
        for ($i=0 ;$i< 7;$i++){
            $this->onCommands[$i] = $noCommand;
            $this->offCommands[$i] = $noCommand;
        }
        $this->undoCommand = $noCommand;
    }
    public function setCommand(int $slot, Command $onCommand, Command $offCommand){
        $this->onCommands[$slot] = $onCommand;
        $this->offCommands[$slot] = $offCommand;
    }

    public function onButtonWasPushed(int $slot){

        $this->onCommands[$slot]->execute();
        $this->undoCommand = $this->onCommands[$slot];
    }

    public function offButtonWasPushed(int $slot){
        $this->offCommands[$slot]->execute();
        $this->undoCommand = $this->offCommands[$slot];

    }
    public function undoButtonWasPushed(){
        $this->undoCommand->undo();
    }
}


class RemoteControlTest{
    public function __construct(){
        $remote = new RemoteControl();//女招待
        $light = new Light('Living Room');//厨师
        $lightOn = new LightOnCommond($light);//订单
        $lightOff = new LightOffCommond($light);//订单
        $ceilFan = new CeilingFan('Living Room');
        $ceilFanHigh = new CeilingFanHighCommand($ceilFan);
        $ceilFanLow = new CeilingFanLowCommand($ceilFan);
        $ceilFanOff = new CeilingFanOffCommand($ceilFan);
        $remote->setCommand(0,$lightOn,$lightOff);//放到柜台
        $remote->setCommand(1,$ceilFanHigh,$ceilFanOff);
        $remote->setCommand(2,$ceilFanLow,$ceilFanOff);
//        $remote->onButtonWasPushed(0);//喊厨师
//        $remote->offButtonWasPushed(0);//喊厨师
//        $remote->undoButtonWasPushed();
//        $remote->onButtonWasPushed(1);
//        $remote->onButtonWasPushed(2);
//        $remote->undoButtonWasPushed();

        $macroCommandOn = new MacroCommand([$ceilFanHigh,$lightOn]);

        $macroCommandOff =new MacroCommand([$ceilFanOff,$lightOff]);

        $remote->setCommand(3,$macroCommandOn,$macroCommandOff);
        $remote->onButtonWasPushed(3);//喊厨师
        $remote->undoButtonWasPushed();
//        $remote->offButtonWasPushed(3);//喊厨师
    }
}

new RemoteControlTest();
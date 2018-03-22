<?php
class Amplifier{}
class Tuner{}
class HomeTheaterFacade{

    protected $amplifier; //扩音器
    protected $tuner; //调音器
    protected $dvdPlayer;
    protected $cdPlayer;
    protected $theaterLights;
    protected $screen;
    protected $popper; //音响

    public function __construct(Amplifier $amplifier,Tuner $tuner){
        $this->amplifier = $amplifier;
        $this->tuner = $tuner;
    }

    public function watchMovie(){
        //对组合对象的一系列操作
   }
    public function endMovie(){
        //对组合对象的一系列操作

    }

}
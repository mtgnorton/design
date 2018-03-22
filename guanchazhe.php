<?php
interface Subject{

    public function registerObserver(Observer $observer);

    public function removeObserver(Observer $observer);

    public function notifyObservers();

}
interface Observer{

    public function update($temperature,$humidity,$pressure);//温度,湿度,压力

    public function getName();

}
interface DisplayElement{

    public function dispaly();

}


class CurrentConditonsDisplay implements Observer,DisplayElement{

    private $subject;
    private $temperature;
    private $name = "currentCondition";

    function __construct(Subject $subject)
    {
        $this->subject = $subject;
        $this->subject->registerObserver($this);

    }
    public function getName(){
        return $this->name;
    }

    public function update($temperature,$humidity,$pressure){
        $this->temperature = $temperature;
        $this->dispaly();
    }

    public function dispaly(){
        echo "current temperature is {$this->temperature}";
        echo "</br>";
    }
}
class HumidityDisplay implements Observer,DisplayElement{

    private $subject;
    private $humidity;
    private $name = "humidity";

    function __construct(Subject $subject)
    {
        $this->subject = $subject;
        $this->subject->registerObserver($this);

    }
    public function getName(){
        return $this->name;
    }

    public function update($temperature,$humidity,$pressure){
        $this->humidity = $humidity;
        $this->dispaly();
    }

    public function dispaly(){
        echo "current humidity is {$this->humidity}";
        echo "</br>";
    }
}


class WeatherData implements Subject{

    private  $observers = [];
    private  $temperature;
    private  $humidity;
    private  $pressure;

    public function registerObserver(Observer $observer){
      if (!isset($this->observers[$observer->getName()]))
      $this->observers[$observer->getName()] = $observer;
    }

    public function removeObserver(Observer $observer){
        if (isset( $this->observers[$observer->getName()]))
            unset( $this->observers[$observer->getName()]);
    }

    public function notifyObservers()
    {
      array_map(function($observer){
        $observer->update(
         $this->temperature,
         $this->humidity,
         $this->pressure
        );
      },$this->observers);
    }

    public function setMeasurements($temperature,$humidity,$pressure){
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->pressure = $pressure;
        $this->notifyObservers();
    }

}
$weatherData = new WeatherData();
$currentDisplay = new CurrentConditonsDisplay($weatherData);
$currentDisplay = new HumidityDisplay($weatherData);
$weatherData->setMeasurements('100','111','2222');
$weatherData->setMeasurements('sss','fff','ddd');
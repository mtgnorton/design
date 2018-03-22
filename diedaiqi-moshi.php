<?php
class MenuItem {
    protected $name;
    protected $description;
    protected $vegetarian; //是否是素食
    protected $price;

    public function __construct($name,$descripton,$vegetarian,$price){
        $this->name = $name;
        $this->description = $descripton;
        $this->vegetarian = $vegetarian;
        $this->price = $price;
    }
    public function getName(){
        return $this->name;
    }
    public function getDescription(){
        return $this->getDescription();
    }
    public function isVegetarian(){
        return $this->vegetarian;
    }
    public function getPrice(){
        return $this->price;
    }
}

interface Menu{
    function createIterator();
}

class  PancakeHouseMenu implements Menu{
    protected $menuItems;

    public function __construct(){
        $this->menuItems = [];
        $this->addItems('waffles','waffles,with your choice of...',true,3.49);
        $this->addItems('waffles111','1111waffles,with your choice of...',false,3.49);
    }
    public function addItems($name,$descripton,$vegetarian,$price){
        $menuItem = new MenuItem($name,$descripton,$vegetarian,$price);
        array_push($this->menuItems,$menuItem);
    }
    public function getMenuItems(){
        return $this->menuItems;
    }
    public function createIterator() : PancakeHouseInterator{
        return new PancakeHouseInterator($this->menuItems);
    }
}

class DinerMenu implements Menu{
    protected $menuItems;

    public function __construct(){
        $this->menuItems = '';
        $this->addItems('hotdog','a hot dog,with your choice of...',false,2.49);
        $this->addItems('hotdog111','1111a hot dog,with your choice of...',false,2.49);
    }
    public function addItems($name,$descripton,$vegetarian,$price){
        $menuItem = new MenuItem($name,$descripton,$vegetarian,$price);
        $this->menuItems .='-'.serialize($menuItem);
    }
    public function createIterator() : DinerMenuInterator{
        return new DinerMenuInterator($this->menuItems);
    }

}

interface DinerIterator {
    function hasNext();
    function next();
}

class PancakeHouseInterator implements DinerIterator{

    protected $menuItems;
    protected $position = 0;
    public function __construct(Array $menuItems){
        $this->menuItems = $menuItems;
    }
    public function next()
    {
         $item = $this->menuItems[$this->position];
         $this->position++;
         return $item;

    }
    public function hasNext(){

        if (isset($this->menuItems[$this->position]) && $this->menuItems[$this->position]){
            return true;
        }
        return false;
    }
}

class DinerMenuInterator implements DinerIterator{

    protected $menuItems;
    protected $position = 0;
    public function __construct(String $menuItems){
        $this->menuItems = $menuItems;
    }
    public function next()
    {

    }
    public function hasNext(){

    }
}
class Waitress{
    protected $pancakeHouseMenu;
    protected $dinerMenu;

    public function __construct(Menu $pancakeHouseMenu, Menu $dinerMenu){
        $this->pancakeHouseMenu = $pancakeHouseMenu;
        $this->dinerMenu = $dinerMenu;
    }
    public function printMenu(){
        $pancakeIterator = $this->pancakeHouseMenu->createIterator();

        while($pancakeIterator->hasNext()){
            echo $pancakeIterator->next()->getName();
            echo "</br>";
        }
    }
}

$waitress = new Waitress(new PancakeHouseMenu(),new DinerMenu());
$waitress->printMenu();
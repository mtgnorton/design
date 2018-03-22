<?php
class  UnsupportedOprationException extends Exception{

}

abstract class MenuComponent{
    public function add(MenuComponent $menuComponent){
        throw new UnsupportedOprationException();
    }
    public function remove(int $i){
        throw new UnsupportedOprationException();
    }

    public function getChild(int $i) : MenuComponent{
        throw new UnsupportedOprationException();
    }

    public function getName() : String{
        throw new UnsupportedOprationException();
    }
       public function getDescription() : String{
        throw new UnsupportedOprationException();
    }
    public function getPrice() : float{
        throw new UnsupportedOprationException();
    }
    public function isVegetarian() :bool { //是否是素食
        throw new UnsupportedOprationException();
    }

    public function print(){
        throw new UnsupportedOprationException();
    }

}

class MenuItem  extends MenuComponent {
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
    public function getName() :String{
        return $this->name;
    }
    public function getDescription() :String{
        return $this->description;
    }
    public function isVegetarian() : bool {
        return $this->vegetarian;
    }
    public function getPrice() : float {
        return $this->price;
    }
    public function print(){
        echo '名称:'.$this->getName().'价格'.$this->getPrice().'素食:'.$this->isVegetarian().'描述:'.$this->getDescription();
        echo "</br>";
    }

}

class Menu extends MenuComponent{
    protected $menuComponents;
    protected $name;
    protected $description;

    public function __construct($name,$description){
        $this->name = $name;
        $this->description = $description;
        $this->menuComponents = [];
    }

    public function add(MenuComponent $menuComponent){
        array_push($this->menuComponents,$menuComponent);
    }
    public function remove(int $i){
        unset($this->menuComponents[$i]);
    }

    public function getChild(int $i) : MenuComponent{
        return $this->menuComponents[$i];
    }

    public function getName() : string {
        return $this->name;
    }
    public function getDescription() :string {
        return $this->description;
    }
    public function print(){
        echo '名称:'.$this->getName().'描述:'.$this->getDescription();
        echo "</br>";
        foreach ($this->menuComponents as $item) {//如果菜单的容器是不一样的,如数组,对象等,则这里需要迭代器模式.
            $item->print();
        }
    }

}


class Waitress{
    protected $allMenus;
    public function __construct(MenuComponent $allMenus){
        $this->allMenus = $allMenus;
    }
    public function printMenu(){
        $this->allMenus->print();
    }
}

$dinnerMenu = new Menu('dinner menu','dinner');
$dessertMenu = new Menu('dessert Menu','dessert of course');
$allMenus = new Menu('all menus','all menus combined');
$allMenus->add($dinnerMenu);
$dinnerMenu->add(new MenuItem('pasta','Spaghetti with Marinara Sauce',true,3.89));
$dinnerMenu->add($dessertMenu);
$dessertMenu->add(new MenuItem('Apple Pie','Apple pie with a flakey cruse',true,1.59));

(new Waitress($allMenus))->printMenu();
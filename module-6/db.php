class Car {
    public $color;
    public $brand;

    public function describe() {
        return "This car is a " . $this->brand . " and it is " . $this->color;
    }
}
<?php
// declare(strict_types=1);
/**
 * PHP LEARNING FILE
 * Topics: Variables & Types, Control Flow, Functions, Classes & OOP
 */

echo "=== 1. VARIABLES & TYPES ===\n\n";

// Variables (all start with $)
$name = "John";
$age = 25;
$price = 19.99;
$isActive = true;
$tasks = null;

echo "Name: $name" . " euy\n";
printf("Name: %s\n", $name);

// echo "String: $name\n";
// echo "Integer: $age\n";
// echo "Float: $price\n";
// echo "Boolean: " . ($isActive ? "true" : "false") . "\n";
// echo "Null: " . ($tasks === null ? "null" : "has value") . "\n\n";

// // Arrays (indexed)
// $colors = ["red", "green", "blue"];
// echo "First color: " . $colors[0] . "\n";
// echo "All colors: " . implode(", ", $colors) . "\n\n";

// // Arrays (associative - like JS objects)
// $person = [
//     'name' => 'Jane',
//     'age' => 30,
//     'city' => 'New York'
// ];
// echo "Person name: " . $person['name'] . "\n";
// echo "Person age: " . $person['age'] . "\n\n";

// // Type checking
// $value = "123";
// echo "Type of \$value: " . gettype($value) . "\n";  // "string"
// echo "Is numeric? " . (is_numeric($value) ? "yes" : "no") . "\n";
// echo "Is array? " . (is_array($colors) ? "yes" : "no") . "\n\n";

// // Type casting
// $stringNum = "42";
// $intNum = (int)$stringNum;  // Cast to int
// echo "Cast '42' to int: $intNum\n\n";

// // Type hints (PHP 7+) - used in functions and classes
// function add(int $a, int $b): int {
//     return $a + $b;
// }
// echo "add(5, 3) = " . add(5, 3) . "\n\n";

// echo "=== 2. CONTROL FLOW ===\n\n";

// // IF / ELSE
// $score = 85;
// if ($score >= 90) {
//     echo "Grade: A\n";
// } elseif ($score >= 80) {
//     echo "Grade: B\n";
// } else {
//     echo "Grade: C\n";
// }
// echo "\n";

// // SWITCH
// $day = "Monday";
// switch ($day) {
//     case "Monday":
//     case "Tuesday":
//         echo "Weekday: $day\n";
//         break;
//     case "Saturday":
//     case "Sunday":
//         echo "Weekend: $day\n";
//         break;
//     default:
//         echo "Unknown day\n";
// }
// echo "\n";

// FOR loop
echo "For loop (0-4): \n";
for ($i=0;$i<5;$i++){
    echo "$i \n";
};

// // FOREACH loop (array iteration)
// $fruits = ["apple", "banana", "cherry"];
// echo "Foreach array: ";
// foreach ($fruits as $fruit) {
//     echo "$fruit ";
// }
// echo "\n\n";

// // FOREACH with key => value
// $person = ["name" => "Bob", "age" => 28, "job" => "Developer"];
// echo "Foreach associative array:\n";
// foreach ($person as $key => $value) {
//     echo "  $key: $value\n";
// }
// echo "\n";

// // WHILE loop
// $count = 0;
// echo "While loop: ";
// while ($count < 3) {
//     echo "$count ";
//     $count++;
// }
// echo "\n";

// // Ternary operator (short if/else)
// $status = $age >= 18 ? "Adult" : "Minor";
// echo "Ternary: $status\n";

// // Null coalescing (?? operator)
// $username = null;
// $display = $username ?? "Guest";
// echo "Null coalescing: $display\n\n";

// echo "=== 3. FUNCTIONS ===\n\n";

// // Basic function
// function greet($name) {
//     return "Hello, $name!";
// }
// echo greet("Alice") . "\n";

// // Function with default parameter
// function introduce($name, $age = 25) {
//     return "$name is $age years old";
// }
// echo introduce("Bob") . "\n";
// echo introduce("Charlie", 35) . "\n";

// // Function with multiple returns (type hint)
// function divide(float $a, float $b): ?float {
//     if ($b === 0) {
//         return null;  // Nullable return type
//     }
//     return $a / $b;
// }
// echo "divide(10, 2) = " . divide(10, 2) . "\n";
// echo "divide(10, 0) = " . (divide(10, 0) ?? "null") . "\n\n";

// function functionA(int $intInput,string $stringInput){
//     echo "ieu int: " . $intInput . " ieu string: " . $stringInput;
// };

// functionA(88,"test")

// // Variadic parameters (variable arguments)
// function sum(...$numbers) {
//     $total = 0;
//     foreach ($numbers as $num) {
//         $total += $num;
//     }
//     return $total;
// }
// echo "sum(1, 2, 3, 4, 5) = " . sum(1, 2, 3, 4, 5) . "\n";

// // Arrow function (PHP 7.4+)
// $multiply = fn($x, $y) => $x * $y;
// echo "Arrow fn multiply(4, 5) = " . $multiply(4, 5) . "\n\n";

// echo "=== 4. CLASSES & OOP ===\n\n";

// // Basic class
// class Car {
//     // Properties
//     public $brand;
//     public $color;
//     private $speed = 0;  // Private property

//     // Constructor
//     public function __construct($brand, $color) {
//         $this->brand = $brand;
//         $this->color = $color;
//     }

//     // Public method
//     public function accelerate($amount) {
//         $this->speed += $amount;
//         return "Speed increased to {$this->speed} km/h";
//     }

//     // Private method
//     private function checkEngine() {
//         return "Engine OK";
//     }

//     // Getter
//     public function getSpeed() {
//         return $this->speed;
//     }

//     // Static method (doesn't need an instance)
//     public static function honk() {
//         return "Beep beep!";
//     }
// }

// // Create instance
// $myCar = new Car("Toyota", "Blue");
// echo "Car: " . $myCar->brand . " - " . $myCar->color . "\n";
// echo $myCar->accelerate(50) . "\n";
// echo "Current speed: " . $myCar->getSpeed() . "\n";
// echo Car::honk() . "\n\n";

// // Inheritance
// class ElectricCar extends Car {
//     public $batteryPercentage = 100;

//     public function charge($amount) {
//         $this->batteryPercentage = min(100, $this->batteryPercentage + $amount);
//         return "Battery charged to {$this->batteryPercentage}%";
//     }
// }

// $tesla = new ElectricCar("Tesla", "Red");
// echo $tesla->accelerate(100) . "\n";
// echo $tesla->charge(50) . "\n";
// echo "Battery: {$tesla->batteryPercentage}%\n\n";

// // Interface (contract for classes)
// interface Animal {
//     public function speak();
//     public function move();
// }

// class Dog implements Animal {
//     public function speak() {
//         return "Woof!";
//     }

//     public function move() {
//         return "Running on four legs";
//     }
// }

// $dog = new Dog();
// echo $dog->speak() . "\n";
// echo $dog->move() . "\n\n";

// // Traits (code reuse without inheritance)
// trait Logger {
//     public function log($message) {
//         echo "[LOG] $message\n";
//     }
// }

// class Application {
//     use Logger;
// }

// $app = new Application();
// $app->log("Application started");
// echo "\n";

// // Property type hints (PHP 7.4+)
// class User {
//     public string $username;
//     public int $id;
//     public array $roles = [];

//     public function __construct(string $username, int $id) {
//         $this->username = $username;
//         $this->id = $id;
//     }
// }

// $user = new User("john_doe", 1);
// echo "User: {$user->username} (ID: {$user->id})\n";
// $user->roles = ["admin", "user"];
// echo "Roles: " . implode(", ", $user->roles) . "\n";

// echo "\n=== DONE ===\n";
?>

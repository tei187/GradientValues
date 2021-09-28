# GradietnValues CLASS
## Ultimate gradient generator you always wanted.
---

Gradient is a PHP class used to generate a decimal-step-based RGBa gradient data, based on defined stops.
Especially usefull with intensification displays (like ticks per hour, visits per day, etc.)

## Features

- Use any RGB markup syntax *(ex. `128,31,187,50%`, `#fcad`, etc.)*
- Return entire result table or just specific percent of the gradient
- Export resulting gradient in different formats ***[not done yet]***
- Use predefined gradients, like *heatmap*, *black body*, etc ***[not done yet]***

## How to use?
Example testing script:
```php
require("./gradient.php");

$test = new GradientValues(); 
$test->assignValues( [
    "15,31,64", 
    "128,0,50,34%", 
    "187,187, 187,41%", 
    "255,55,111,0.54"
]);

echo "<div style='padding: 20px; background-color: #c7e3ff; display: flex;'>";
foreach($test->range as $k => $v) {
    echo "<div style='display: inline-flex; flex-grow: 1; height: 100px; background-color: {$test->result($k)}'></div>";
}
echo "</div>";
```
## Requirements
- PHP >= 7.3

## Author
- [tei187](mailto:bonk.piotr@gmail.com)
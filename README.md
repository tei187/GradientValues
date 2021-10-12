# GradientValues CLASS
## Ultimate gradient generator you always wanted.
### (supplemented with RangeBasedPercentage class)
---

Gradient is a PHP class used to generate a decimal-step-based RGBa gradient data, based on defined stops.
Especially usefull with intensification displays (like ticks per hour, visits per day, etc.)
Additionally supplied with RangeBasedPercentage to find percentage-relative of a value between given range.

## Features

- Use any RGB markup syntax *(ex. `128,31,187,50%`, `#fcad`, etc.)*
- Return entire result table or just specific percent of the gradient
- Export resulting gradient in different formats ***[not done yet]***
- Use predefined gradients, like *heatmap*, *black body*, etc ***[partially done]***

## How to use?
### Creating gradient from RGB(a) values
```php
$var = new GradientValues();  // initiate object
$var->setValues(["#000", "#fff"]); // set values for gradient

echo $var->renderBar(); // render gradient

echo $var->result(51); // returns rgba(rrr,ggg,bbb,a) string

echo $var->renderCell(85); // return echoable HTML object filled with color equivalent to 85th step of the gradient
```
### Creating gradient from default gradients
```php
$var = new GradientValues();  // initiate object
$var->setValues("heatmap"); // set values from preset gradient
echo $var->renderBar();
```
Default gradients are (2021/10/12): `heatmap`, `rgb`, `red`, `green`, `blue`, `b/w`, `gray`, `orange`, `violet`, `lime`, `cyan`, `magenta`, `yellow`, `aqua`, `blue-gray`, `bb`, `opb`, `ovb`, `r/g`.

## Requirements
- PHP >= 7.3

## Author
- [tei187](mailto:bonk.piotr@gmail.com)

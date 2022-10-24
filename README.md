# IntensificationGradient
## Ultimate gradient generator you may need after all.
---

IntensificationGradient is a PHP class used to generate a decimal-step-based RGBa gradient data arrays, based on defined stops.
Especially usefull with intensification displays (like ticks per hour, visits per day, etc.) or compositions based on gradient range of limiting colors (brand guides, etc.).
Works nicely when supplied with [RangeBasedPercentage](https://github.com/tei187/range-based-percentage) in order to find percentage-relative of a value between given range.

## Features
- Use any RGB markup syntax *(ex. `128,31,187,50%`, `#fcad`, etc.)
- Return entire result table or just specific percent of the gradient
- Export resulting gradient in JSON format in RGB(a) or HEX transcription
- Use predefined gradients, like *heatmap*, *blackbody*, etc ***[partially done]***

## How to use?
### Creating gradient from RGB(a) values
```php
$var = new tei187\IntensificationGradient\Generator;  // initiate object
$var->setValues(["#000", "#fff"]); // set values for gradient

echo $var->renderBar(); // renders gradient (requires CSS class assignment for proper display)

echo $var->result(51); // returns rgba(rrr,ggg,bbb,a) string for 51st step

echo $var->renderCell(85); // return echoable HTML object filled with color equivalent to 85th step of the gradient
```

### Creating gradient from predefined presets
```php
$var = new tei187\IntensificationGradient\Generator;  // initiate object
$var->setValues("heatmap"); // set values from preset gradient
echo $var->renderBar();
```
Default gradients are (2021/10/12): `heatmap`, `blackbody`, `rgb`, `red`, `green`, `blue`, `b/w`, `gray`, `orange`, `violet`, `lime`, `cyan`, `magenta`, `yellow`, `aqua`, `blue-gray`, `bb`, `opb`, `ovb`, `nvg`, `color-temp`, `rastafari`, `argon-blue`, `r/g`, `facebook`, `google`, `instagram`, `lyft`, `twitch`, `skype`.

### Reverting gradient
Typed in the gradient from the opposite direction? Or maybe just need to switch it for some reason at some point? No problem, use the 'invert' method.
```php
$var = new tei187\IntensificationGradient\Generator;  // initiate object
$var->setValues(["#f00", "#00f"]); // set values for gradient, from red to blue
$var->invert(); // reverts the gradient, from blue to red
```

### Exporting to JSON
It is also possible to export the resulting gradient range to JSON format.
```php
$var = new tei187\IntensificationGradient\Generator;  // initiate object
$var->setValues(["#f00", "#00f"]); // set values for gradient, from red to blue
return $var->returnJSON();
```

### Generating preview page
There is also a possibility to render an entire HTML page for the outcome of Gradient range.
```php
use tei187\IntensificationGradient\Generator as Generator;
use tei187\IntensificationGradient\HtmlPreview as HtmlPreview;
$gen = new Generator("opb"); // create Generator object
$prev = new HtmlPreview("Testing", $gen->returnArray(true)); // pass to HtmlPreview
echo $prev->buildPage();
```

### Default gradients
List of default preset gradients:

![List of default gradients](https://xowergs.wirt16.bhlink.pl/stuff/IntensificationGradient_defaults.jpg)


## Requirements
- PHP >= 7.3

## Author
- [tei187](mailto:bonk.piotr@gmail.com)

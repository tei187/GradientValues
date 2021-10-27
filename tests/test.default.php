<html>
<head>
  <title>IntensificationGradient - default gradients</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
  <style>
        html {
            background-color: #333844;
            display: flex;
        }
        body {
            margin: 5vw auto;
            padding: 2.5vw;
            border: 1px solid rgba(0,0,0,.1);
            background-color: #fff;
            border-radius: 1em;
            box-shadow: 0 0 25px #090a0c;
            height: min-content;
            max-width: 750px;
            width: 100%;
        }
        hr.section {
            border-top: 2px dotted #0001;
            margin: 2em auto;
            width: calc(100% - 40px);
        }
        hr {
            border: none;
            margin-top: 2em;
            border-top: 2px dashed #0004;
        }
        h1, h2, h3, h4 {
            font-family: Montserrat;
            border-bottom: 1px dotted rgba(0,0,0,.2);
            padding-bottom: .25em;
        }
        h1 {
            border-bottom: 4px solid #0002;
            font-size: 2.5rem;
            padding-bottom: 1rem;
            margin-bottom: 1.5em;
        }
        pre {
            line-height: 1em;
            color: #000a;
        }
        code > pre {
            letter-spacing: .05em;
            line-height: 1rem;
            border-width: medium;
            border: solid #bbb;
            border-top: dotted #bbb;
            border-left: dashed #bbb;
            border-radius: 2em;
            background-color: #eee;
            padding: 1em;
            font-weight: 100;
            color: black;
            font-size: 1.2em;
        }
        details {
            padding: 0 20px 20px 20px;
            margin-top: 2em;
        }
        details > summary {
            font-family: system-ui;
        }
        .containment {
            padding: 20px; 
            background-color: #fcfcfc; 
            box-shadow: 0px 3px 25px rgba(0,0,0,.1);
            display: flex;
        }
        .step { 
            display: inline-flex; 
            flex-grow: 1; 
            height: 100px; 
            justify-content: center; 
            align-items: center;
            width: 1px;
        } 
        .step > span { 
            mix-blend-mode: difference;
            color: #fff;
            font-size: x-large;
            font-family: monospace;
            letter-spacing: .05em;
        }
        </style>
</head>
<body>

<?php
    require("../src/Generator.php");

// CONFIG
    $test = new tei187\IntensificationGradient\Generator; 

//
//  TEST 1 - render full gradient
//
    echo "<h1>IntensificationGradient</h1>";
    echo "<h2>Pre-defined gradients</h2>";

?>
<code><pre>
<&quest;php

    $var = new tei187\IntensificationGradient\Generator;
    $var->setValues("name");
    $var->renderBar();

&quest;>
</pre></code>

<h3 style='padding-top: 3em'>Basic:</h3>
<ul>
<?
    echo "<li><h4>heatmap</h4>".$test->setValues("heatmap")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>color-temp</h4>".$test->setValues("color-temp")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>rgb</h4>".$test->setValues("rgb")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>red</h4>".$test->setValues("red")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>green</h4>".$test->setValues("green")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>blue</h4>".$test->setValues("blue")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>cyan</h4>".$test->setValues("cyan")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>magenta</h4>".$test->setValues("magenta")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>yellow</h4>".$test->setValues("yellow")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>black</h4>".$test->setValues("black")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    ?>
</ul>
<h3 style='padding-top: 3em'>Off-color:</h3>
<ul>
<?
    echo "<li><h4>gray</h4>".$test->setValues("gray")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>beige</h4>".$test->setValues("beige")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>orange</h4>".$test->setValues("orange")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>lime</h4>".$test->setValues("lime")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>aqua</h4>".$test->setValues("aqua")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>violet</h4>".$test->setValues("violet")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>blue-gray</h4>".$test->setValues("blue-gray")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>bb</h4>".$test->setValues(["fff", '37915b'])->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        
?>
</ul>
<h3 style='padding-top: 3em'>Intense:</h3>
<ul>
<?php
    echo "<li><h4>blackbody</h4>".$test->setValues("blackbody")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>opb</h4>".$test->setValues("opb")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>ovb</h4>".$test->setValues("ovb")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>r/g</h4>".$test->setValues("r/g")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>rastafari</h4>".$test->setValues("rastafari")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>argon-blue</h4>".$test->setValues("argon-blue")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>nvg</h4>".$test->setValues("nvg")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
?>
</ul>
<h3 style='padding-top: 3em'>Brands:</h3>
<ul>
<?php
    echo "<li><h4>facebook</h4>".$test->setValues("facebook")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>google</h4>".$test->setValues("google")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>instagram</h4>".$test->setValues("instagram")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>lyft</h4>".$test->setValues("lyft")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>twitch</h4>".$test->setValues("twitch")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
    echo "<li><h4>skype</h4>".$test->setValues("skype")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
?>
</ul>
</body></html>
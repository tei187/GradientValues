<html>
<head>
  <title>GradientValues class</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
        html {
            background-color: #333844;
        }
        body {
            margin: 5vw;
            padding: 2.5vw;
            border: 1px solid rgba(0,0,0,.1);
            background-color: #fff;
            border-radius: 1em;
            box-shadow: 0 0 25px #090a0c;
            height: min-content;
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
            font-family: system-ui;
            border-bottom: 1px dotted rgba(0,0,0,.2);
            padding-bottom: .25em;
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
    require("../GradientValues.class.php");

// CONFIG
    $test = new GradientValues(); 

//
//  TEST 1 - render full gradient
//
    echo "<h2>Pre-defined gradients</h2>";

?>
<code><pre>
<&quest;php

    $var = new GradientValues();
    $var->assignValues("name");
    $var->renderBar();

&quest;>
</pre></code>

<h3 style='padding-top: 3em'>Default:</h3>
<ul>
<?
        echo "<li><h4>heatmap</h4>".$test->assignValues("heatmap")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>rgb</h4>".$test->assignValues("rgb")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>red</h4>".$test->assignValues("red")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>green</h4>".$test->assignValues("green")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>blue</h4>".$test->assignValues("blue")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>b/w</h4>".$test->assignValues("b/w")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>gray</h4>".$test->assignValues("gray")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
?>
</ul>
<h3 style='padding-top: 3em'>Mixed:</h3>
<ul>
<?
        echo "<li><h4>orange</h4>".$test->assignValues("orange")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>violet</h4>".$test->assignValues("violet")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>lime</h4>".$test->assignValues("lime")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>cyan</h4>".$test->assignValues("cyan")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>magenta</h4>".$test->assignValues("magenta")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>yellow</h4>".$test->assignValues("yellow")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>aqua</h4>".$test->assignValues("aqua")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>blue-gray</h4>".$test->assignValues("blue-gray")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>bb</h4>".$test->assignValues(["fff", '37915b'])->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        
?>
</ul>
<h3 style='padding-top: 3em'>Complex:</h3>
<ul>
<?php
        echo "<li><h4>opb</h4>".$test->assignValues("opb")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>ovb</h4>".$test->assignValues("ovb")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
        echo "<li><h4>r/g</h4>".$test->assignValues("r/g")->renderBar(['class' => 'containment'], ['class' => 'step'])."</li>";
?>
</ul>

</body></html>
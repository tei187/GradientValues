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
        h2 {
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
    $test1 = new GradientValues(); 
    $test1->setValues(["15,31,64", "128,0,50,34%", "187,187, 187,41%", "255,55,111,0.54"]);

    $test2 = new GradientValues();
    $test2->setValues('heatmap');
    
    $test3 = new GradientValues();
    $test3->setValues(['003', '9000ff', 'ffde00']);

//
//  TEST 1 - render full gradient
//
    echo "<h2>TEST #1 - full gradient</h2>";

?>
<code><pre>
<&quest;php

    $var = new GradientValues();
    $var->setValues(["#000", "#fff"]);
    $var->renderBar();

&quest;>
</pre></code>
<?
        
        echo "<details><summary>Input</summary>";
        echo "<pre>";print_r($test1->getValues());echo "</pre>";
        echo "</details>";
        // rendering gradient
        echo $test1->renderBar(['class' => 'containment'], ['class' => 'step']);

    echo "<hr class='section'>";

        echo "<details><summary>Input</summary>";
        echo "<pre>";print_r($test2->getValues());echo "</pre>";
        echo "</details>";
        // rendering gradient
        echo $test2->renderBar(['class' => 'containment'], ['class' => 'step']);

    echo "<hr class='section'>";

        echo "<details><summary>Input</summary>";
        echo "<pre>";print_r($test3->getValues());echo "</pre>";
        echo "</details>";
        // rendering gradient
        echo $test3->renderBar(['class' => 'containment'], ['class' => 'step']);
//
    echo "<br><hr><br>";
//

//
//  TEST 2 - render specific percent
//
    echo "<h2>TEST #2 - pick blocks</h2>";
?>
<code><pre>
<&quest;php

    $var = new GradientValues();
    $var->setValues(["#000", "#fff"]);
    $var->renderCell($percent);
    
&quest;>
</pre></code>
<?
        // assigning picks
        $picks = [0, 9, 25, 61, 86, 100];
        // rendering picks
        echo "<div class='containment'>";
        foreach($picks as $pick) {
            echo $test1->renderCell($pick, "div", " class='step'", "<span>{$pick}%</span>");
        }
        echo "</div>";

    echo "<hr class='section'>";
    
        // assigning picks
        $picksRGB = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
        // rendering picks
        echo "<div class='containment'>";
        foreach($picksRGB as $pick) {
            echo $test2->renderCell($pick, "div", " class='step'", "<span>{$pick}%</span>");
        }
        echo "</div>";

    echo "<hr class='section'>";

        // assigning picks
        $picksRGB = [0, 33, 66, 100];
        // rendering picks
        echo "<div class='containment'>";
        foreach($picksRGB as $pick) {
            echo $test3->renderCell($pick, "div", " class='step'", "<span>{$pick}%</span>");
        }
        echo "</div>";
?>

</body></html>
<html>
<head>
  <title>GradientValues class</title>
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
        h1, h2 {
            font-family: Montserrat;
        }
        h1 {
            border-bottom: 4px solid #0002;
            font-size: 2.5rem;
            padding-bottom: 1rem;
            margin-bottom: 1.5em;
        }
        h2 {
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
    require("../src/Generator.php");

// CONFIG
    $test1 = new tei187\IntensificationGradient\Generator; 
    $test1->setValues(["15,31,64", "128,0,50,34%", "187,187, 187,41%", "255,55,111,0.54"]);

    $test2 = new tei187\IntensificationGradient\Generator; 
    $test2->setValues('heatmap');
    
    $test3 = new tei187\IntensificationGradient\Generator; 
    $test3->setValues(['003', '9000ff', 'ffde00']);

    echo "<h1>GradientValues : class</h1>";
//
//  TEST 1 - render full gradient
//
    echo "<h2>TEST #1 - full gradient</h2>";

?>
<code><pre>
<&quest;php

    $var = new tei187\GradientValues;
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

    $var = new tei187\GradientValues;
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
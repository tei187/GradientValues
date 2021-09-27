<html>
<head>
  <title>A Meaningful Page Title</title>
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
        } 
        .step > p { 
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
    require("./gradient.php");

// CONFIG
    $test = new GradientValues(); 
    $test->assignValues(["15,31,64", "128,0,50,34%", "187,187, 187,41%", "255,55,111,0.54"]);

    $test2 = new GradientValues();
    //$test2->assignValues(["000", "00f", "0ff", "0f0", "ff0", "f00", "fff"]);
    $test2->assignValues('heatmap');
    
    $test3 = new GradientValues();
    $test3->assignValues(['003', '9000ff', 'ffde00']);

//
//  TEST 1 - render full gradient
//

    echo "<h2>TEST #1 - full gradient</h2>";
    // rendering input array
    echo "<details><summary>Input</summary>";
    echo "<pre>";print_r($test->valuesRGB);echo "</pre>";
    echo "</details>";
    // rendering gradient
    echo "<div class='containment'>";
    foreach($test->range as $k => $v) {
        echo "<div class='step' style='background-color: {$test->result($k)}'></div>";
    }
    echo "</div>";

    echo "<hr class='section'>";

    echo "<details><summary>Input</summary>";
    echo "<pre>";print_r($test2->valuesRGB);echo "</pre>";
    echo "</details>";
    // rendering gradient
    echo "<div class='containment'>";
    foreach($test2->range as $k => $v) {
        echo "<div class='step' style='background-color: {$test2->result($k)}'></div>";
    }
    echo "</div>";

    echo "<hr class='section'>";

    echo "<details><summary>Input</summary>";
    echo "<pre>";print_r($test3->valuesRGB);echo "</pre>";
    echo "</details>";
    // rendering gradient
    echo "<div class='containment'>";
    foreach($test3->range as $k => $v) {
        echo "<div class='step' style='background-color: {$test3->result($k)}'></div>";
    }
    echo "</div>";
//
    echo "<br><hr><br>";
//

//
//  TEST 2 - render specific percent
//
    // assigning picks
    $picks = [0, 9, 25, 61, 86, 100];
    echo "<h2>TEST #2 - pick blocks</h2>";

    // rendering picks
    echo "<div class='containment'>";
    foreach($picks as $pick) {
        echo "<div class='step' style='width: 100px; background-color: {$test->result($pick)}'><p>{$pick}%</p></div>";
    }
    echo "</div>";

    echo "<hr class='section'>";
    
    $picksRGB = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
    echo "<div class='containment'>";
    foreach($picksRGB as $pick) {
        echo "<div class='step' style='width: 100px; background-color: {$test2->result($pick)}'><p>{$pick}%</p></div>";
    }
    echo "</div>";

    echo "<hr class='section'>";


    $picksRGB = [0, 33, 66, 100];
    echo "<div class='containment'>";
    foreach($picksRGB as $pick) {
        echo "<div class='step' style='width: 100px; background-color: {$test3->result($pick)}'><p>{$pick}%</p></div>";
    }
    echo "</div>";
?>

</body></html>
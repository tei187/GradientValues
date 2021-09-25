<?php

    require("./gradient.php");
    
    $test = new GradientValues(); 
    $test->assignValues(["15,31,64", "128,0,50,34%", "187,187, 187,41%", "255,55,111,0.54"]);
    
    echo "<pre>";print_r($test->valuesRGB);echo "</pre>";
    // rendering gradient
    echo "<div style='padding: 20px; background-color: #c7e3ff; display: flex;'>";
    foreach($test->range as $k => $v) {
        echo "<div style='display: inline-flex; flex-grow: 1; height: 100px; background-color: {$test->result($k)}'></div>";
    }
    echo "</div>";

?>
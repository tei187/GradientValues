<?php

    require_once("../src/Generator.php");
    require_once("../src/HtmlPreview.php");

    use tei187\IntensificationGradient\Generator as Generator;
    use tei187\IntensificationGradient\HtmlPreview as HtmlPreview;

    $gen = new Generator("opb");

    $prev = new HtmlPreview("Testing", $gen->returnArray(false));
    echo $prev->buildPage();

?>
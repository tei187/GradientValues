<?php

    require_once("../src/Generator.php");
    require_once("../src/HtmlPreview.php");

    use tei187\IntensificationGradient\Generator as Generator;
    use tei187\IntensificationGradient\HtmlPreview as HtmlPreview;

    $gen = new Generator("rgb");

    $prev = new HtmlPreview("Testing", $gen->returnArray(true));
    echo $prev->buildPage();

?>
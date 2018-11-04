<?php

include(__DIR__ . "/../vendor/autoload.php");
$json = file_get_contents(__DIR__.'/simple_xlsx.json');

$data = json_decode($json, true);

use IshyEvandro\XlsPatternGenerator\XlsPatternGenerator;


$processor = new XlsPatternGenerator($data);
$processor->process();
$processor->save(__DIR__.'/../tmp/simple.xlsx');
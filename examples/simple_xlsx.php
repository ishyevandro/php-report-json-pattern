<?php

include(__DIR__ . "/../vendor/autoload.php");
use IshyEvandro\XlsPatternGenerator\XlsPatternGenerator;

$json = file_get_contents(__DIR__.'/simple_xlsx.json');
$data = json_decode($json, true);

$processor = new XlsPatternGenerator($data);
$processor->process();
$processor->save(__DIR__.'/../tmp/simple.xlsx');
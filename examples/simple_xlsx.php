<?php

include(__DIR__ . "/../vendor/autoload.php");
use IshyEvandro\XlsPatternGenerator\XlsPatternGenerator;

$json = file_get_contents(__DIR__.'/simple_xlsx.json');
$data = json_decode($json, true);

$processor = new XlsPatternGenerator($data);
if ($processor->process()) {
    $processor->save(__DIR__.'/../tmp/simple.xlsx');
    echo "success";
} else {
    echo "something gona wrong!" . $processor->getErrorMessage();
}

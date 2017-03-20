<?php
# hack for symfony 3.x and phpunit 6
# more info https://gist.github.com/jeroenvdgulik/c693d3f37b76efb66a55a2b50944c499
$loader = require(__DIR__  . '/../app/autoload.php'); // or whatever path your autoload.php is in
$convert = [
    '\PHPUnit_Framework_TestCase' => '\PHPUnit\Framework\TestCase',
    '\PHPUnit_Util_Test' => '\PHPUnit\Util\Test',
    '\PHPUnit_Framework_Constraint' => '\PHPUnit\Framework\Constraint\Constraint',
    '\PHPUnit_Framework_Assert' => '\PHPUnit\Framework\Assert',
    '\PHPUnit_Framework_Constraint_IsEqual' => '\PHPUnit\Framework\Constraint\IsEqual',
    '\PHPUnit_Framework_Constraint_ExceptionMessage' => '\PHPUnit\Framework\Constraint\ExceptionMessage',
];

foreach ($convert as $oldClass => $newClass) {
    if (!class_exists($oldClass) && class_exists($newClass)) {
        class_alias($newClass, $oldClass);
    }
}
return $loader;

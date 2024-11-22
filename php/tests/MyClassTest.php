<?php

use PHPUnit\Framework\TestCase;
use App\MyClass;

class MyClassTest extends TestCase
{

    public function testAddition()
    {

        $myClass = new MyClass();
        $this->assertEquals(4, $myClass->add(2, 2));
    }
}

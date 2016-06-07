<?php


namespace PhLea\approximation;


class NewtonRaphsonApproximatiorTest extends \PHPUnit_Framework_TestCase
{
    
    public function testApproximateFunction() {
        $function = function($x) {
            return pow($x, 2) - 2;
        };

        $derivative = function($x) {
            return 2 * $x;
        };
        $tolerance = 0.0000000001;

        $approximator = new NewtonRaphsonApproximatior();
        $solution = $approximator->approximateFunction($function, $derivative, 1, $tolerance);
        $this->assertEquals(sqrt(2), $solution, $tolerance);
    }
}
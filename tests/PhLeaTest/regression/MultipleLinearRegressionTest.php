<?php

namespace PhLea\regression;

use PhLea\linearAlgebra\Mat;
use PhLea\linearAlgebra\Vector;

class MultipleLinearRegressionTest extends \PHPUnit_Framework_TestCase
{
    public function testMultipleLinearRegression()
    {
        $A = new Mat(2, 4,
            \SplFixedArray::fromArray(
                array(
                    1, 5,
                    2, 7,
                    4, 8,
                    6, 14
                ))
        );
        $b = new Vector(4, \SplFixedArray::fromArray(array(1, 2, 3, 4)));
        $a = new Vector(2, \SplFixedArray::fromArray(array(3, 6)));
        $linearRegression = new MultipleLinearRegression();
        $linearRegression->fit($A, $b);
        $this->assertEquals(
            new Mat(1, 1, \SplFixedArray::fromArray(array(2.0110701107011062))),
            $linearRegression->predict($a)
        );
        $this->assertEquals(
            new Mat(1, 2, \SplFixedArray::fromArray(array(0.40467404674046836, 0.13284132841328355))),
            $linearRegression->getCoefficients()
        );
    }
}
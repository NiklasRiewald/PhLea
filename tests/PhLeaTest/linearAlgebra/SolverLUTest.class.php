<?php


namespace PhLea\linearAlgebra;


class SolverLUTest extends \PHPUnit_Framework_TestCase
{
    public function testSolve()
    {
        $mat = new Mat(4, 4, \SplFixedArray::fromArray(array(
            4, -5, 3, 0,
            -1, -3, -11, 11,
            4, 2, 2, 1,
            2, 0, -3, -2
        )));
        $solver = LinearAlgebraFactory::getInstanceOfSolverLU($mat);
        $x = $solver->solve(new Vector(4, \SplFixedArray::fromArray(array(
            2,
            -4,
            5,
            0.5
        ))));
        $expectedX = new Vector(4, \SplFixedArray::fromArray(array(
            0.83906931652932648,
            0.45201163354338358,
            0.30126030053320407,
            0.13717886572952018
        )));
        $this->assertEquals($expectedX, $x);
    }
}
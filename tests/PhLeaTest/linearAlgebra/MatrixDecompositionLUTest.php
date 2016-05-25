<?php


namespace PhLea\linearAlgebra;


class MatrixDecompositionLUTest extends \PHPUnit_Framework_TestCase
{
    public function testDecomposeIntoLU()
    {
        $mat = new Mat(3, 3, \SplFixedArray::fromArray(array(
            8, 6, -2,
            1, 7, -4,
            3, 5, 3
        )));

        $factory = new LinearAlgebraFactory();
        $decomposition = $factory->getInstanceOfMatrixDecompositionLU();
        $decomposition->decompose($mat);

        $matExpected = new Mat(3, 3, \SplFixedArray::fromArray(array(
            8, 6, -2,
            0.125, 6.25, -3.75,
            0.375, 0.44, 5.4000000000000004
        )));

        $this->assertEquals($matExpected, $mat);
    }
}
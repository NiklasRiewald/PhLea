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

        $permutationMatrixExpected = new Mat(3, 3, \SplFixedArray::fromArray(array(
            1, 0, 0,
            0, 1, 0,
            0, 0, 1
        )));

        $this->assertEquals($matExpected, $mat);
        $this->assertEquals($permutationMatrixExpected, $decomposition->getPermutationMatrix());
    }

    public function testDecomposeWherePivotingIsNeeded()
    {
        $mat = new Mat(3, 3, \SplFixedArray::fromArray(array(
            1, 4, 5,
            -6, 4, 2,
            -4, -2, -1,
        )));

        $factory = new LinearAlgebraFactory();
        $decomposition = $factory->getInstanceOfMatrixDecompositionLU();
        $decomposition->decompose($mat);

        $matExpected = new Mat(3, 3, \SplFixedArray::fromArray(array(
            -6, 4, 2,
            -0.167, 4.667, 5.333,
            0.667, -1, 3
        )));

        $permutationMatrixExpected = new Mat(3, 3, \SplFixedArray::fromArray(array(
            0, 1, 0,
            1, 0, 0,
            0, 0, 1
        )));

        $this->assertEquals($matExpected, $mat, '', 0.001);
        $this->assertEquals($permutationMatrixExpected, $decomposition->getPermutationMatrix());
    }
}
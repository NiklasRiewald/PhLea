<?php


namespace PhLea\linearAlgebra;


class MatrixInverterTest extends \PHPUnit_Framework_TestCase
{

    public function testInverse()
    {
        $mat = new Mat(4, 4, \SplFixedArray::fromArray(array(
            4, -5, 3, 0,
            -1, -3, -11, 11,
            4, 2, 2, 1,
            2, 0, -3, -2
        )));

        $linearAlgebraFactory = new LinearAlgebraFactory();
        $matrixInverter = $linearAlgebraFactory->getInstanceOfMatrixInverter();
        $matrixInverter->invert($mat);

        $matExpected = new Mat(4, 4, \SplFixedArray::fromArray(array(
            (107 / 2063), (17 / 2063), (293 / 2063), (240 / 2063),
            (-285 / 2063), (-26 / 2063), (280 / 2063), (-3 / 2063),
            (70 / 2063), (-66 / 2063), (76 / 2063), (-325 / 2063),
            (2 / 2063), (116 / 2063), (179 / 2063), (-304 / 2063)
        )));

        $this->assertEquals($matExpected, $mat);
    }

    public function testInverseSingularMatrix()
    {
        $mat = new Mat(2, 2, \SplFixedArray::fromArray(array(
            4, 2,
            2, 1
        )));

        $linearAlgebraFactory = new LinearAlgebraFactory();
        $matrixInverter = $linearAlgebraFactory->getInstanceOfMatrixInverter();
        $matrixInverter->invert($mat);
        $matExpected = new Mat(2, 2, \SplFixedArray::fromArray(array(
            1 / 4
        )));

        $this->assertEquals($matExpected, $mat);
    }

    public function testInverseMatrixWithNecessaryPivoting()
    {
        $mat = new Mat(2, 2, \SplFixedArray::fromArray(array(
            0, 2,
            2, 1
        )));

        $linearAlgebraFactory = new LinearAlgebraFactory();
        $matrixInverter = $linearAlgebraFactory->getInstanceOfMatrixInverter();
        $matrixInverter->invert($mat);
        $matExpected = new Mat(2, 2, \SplFixedArray::fromArray(array(
            (-1 / 4), (1 / 2),
            (1 / 2), 0
        )));

        $this->assertEquals($matExpected, $mat);
    }

    public function testInverseSingleElement()
    {
        $mat = new Mat(1, 1, \SplFixedArray::fromArray(array(
            4
        )));

        $linearAlgebraFactory = new LinearAlgebraFactory();
        $matrixInverter = $linearAlgebraFactory->getInstanceOfMatrixInverter();
        $matrixInverter->invert($mat);
        $matExpected = new Mat(1, 1, \SplFixedArray::fromArray(array(
            1 / 4
        )));

        $this->assertEquals($matExpected, $mat);
    }
}
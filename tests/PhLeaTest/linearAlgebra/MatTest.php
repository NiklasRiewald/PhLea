<?php

namespace PhLea\linearAlgebra;

class MatTest extends \PHPUnit_Framework_TestCase
{
    public function testSum()
    {
        $mat1 = new Mat(2, 5);
        $mat2 = new Mat(2, 5);
        for ($i = 0; $i < 10; $i++) {
            $mat1->setAtIndex($i, $i);
            $mat2->setAtIndex($i, -5);
        }
        $matResult = $mat1->sum($mat2);

        $matExpected = new Mat(2, 5);
        for ($i = 0; $i < 10; $i++) {
            $matExpected->setAtIndex($i, $i - 5);
        }

        $this->assertEquals($matExpected, $matResult);
    }

    public function testDot()
    {
        $mat1 = new Mat(2, 4, \SplFixedArray::fromArray(array(
            3, 4,
            1, -1,
            -2, 5,
            5, -3
        )));

        $mat2 = new Mat(2, 2, \SplFixedArray::fromArray(array(
            2, 4,
            0, -3
        )));

        $matResult = $mat1->dot($mat2);

        $matExpected = new Mat(2, 4, \SplFixedArray::fromArray(array(
            6, 0,
            2, 7,
            -4, -23,
            10, 29
        )));

        $this->assertEquals($matExpected, $matResult);
    }

    public function testGetTranspose()
    {
        $mat = new Mat(2, 4, \SplFixedArray::fromArray(array(
            3, 4,
            1, -1,
            -2, 5,
            5, -3
        )));

        $matTransposed = $mat->getTranspose();

        $matExpected = new Mat(4, 2, \SplFixedArray::fromArray(array(
            3, 1, -2, 5,
            4, -1, 5, -3
        )));

        for ($y = 0; $y < 2; $y++) {
            for ($x = 0; $x < 4; $x++) {
                $this->assertEquals($matExpected->get($x, $y), $matTransposed->get($x, $y));
            }
        }
    }

    public function testGetRealTranspose()
    {
        $mat = new Mat(2, 4, \SplFixedArray::fromArray(array(
            3, 4,
            1, -1,
            -2, 5,
            5, -3
        )));


        $matTransposed = $mat->getRealTranspose();

        $matExpected = new Mat(4, 2, \SplFixedArray::fromArray(array(
            3, 1, -2, 5,
            4, -1, 5, -3
        )));

        $this->assertEquals($matExpected, $matTransposed);
    }

    public function testGetIdentityMatrix()
    {
        $identityMatrix = Mat::getIdentityMatrix(3);
        $expectedMat = new Mat(3, 3, \SplFixedArray::fromArray(
            array(
                1, 0, 0,
                0, 1, 0,
                0, 0, 1)));

        $this->assertEquals($expectedMat, $identityMatrix);
    }
}
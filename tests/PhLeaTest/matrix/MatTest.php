<?php

namespace PhLea\matrix;

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

    public function testInverse()
    {
        $mat = new Mat(4, 4, \SplFixedArray::fromArray(array(
            4, -5, 3, 0,
            -1, -3, -11, 11,
            4, 2, 2, 1,
            2, 0, -3, -2
        )));

        $mat->inverse();

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

        $mat->inverse();
        $matExpected = new Mat(2, 2, \SplFixedArray::fromArray(array(
            1 / 4
        )));

        $this->assertEquals($matExpected, $mat);
    }

    public function testInverseSingleElement()
    {
        $mat = new Mat(1, 1, \SplFixedArray::fromArray(array(
            4
        )));

        $mat->inverse();
        $matExpected = new Mat(1, 1, \SplFixedArray::fromArray(array(
            1 / 4
        )));

        $this->assertEquals($matExpected, $mat);
    }

    public function testDecomposeIntoLU()
    {
        $mat = new Mat(3, 3, \SplFixedArray::fromArray(array(
            8, 6, -2,
            1, 7, -4,
            3, 5, 3
        )));

        $mat->decomposeIntoLU();

        $matExpected = new Mat(3, 3, \SplFixedArray::fromArray(array(
            8, 6, -2,
            0.125, 6.25, -3.75,
            0.375, 0.44, 5.4000000000000004
        )));

        $this->assertEquals($matExpected, $mat);
    }
}
<?php


namespace PhLea\linearAlgebra;


class MatrixInverter
{
    /*@var MatrixDecompositionLU */
    private $decompositionLU;

    public function __construct(MatrixDecompositionLU $decompositionLU)
    {
        $this->decompositionLU = $decompositionLU;
    }

    /**
     * Inverse matrix using LU decomposition
     * Look at http://www.cl.cam.ac.uk/teaching/1314/NumMethods/supporting/mcmaster-kiruba-ludecomp.pdf for an explanation
     * Returns true if the inversion is successful and false if the Matrix is singular or not square
     *
     * @param Mat $mat
     * @return bool
     */
    public function invert(Mat $mat)
    {
        if ($mat->getRows() != $mat->getColumns()) {
            return false;
        }

        $resultMat = new Mat($mat->getColumns(), $mat->getRows());

        $this->decompositionLU->decompose($mat);
        $rowsMinusOne = $mat->getRows() - 1;

        for ($y = 0; $y < $mat->getRows(); $y++) {

            //initialising b (the y-th unit vector)
            $b = new \SplFixedArray($mat->getRows());
            for ($x = 0; $x < $mat->getRows(); $x++) {
                if ($y == $x) {
                    $b[$x] = 1;
                } else {
                    $b[$x] = 0;
                }
            }

            //solving Lz = b
            $z = new \SplFixedArray($mat->getRows());
            $z[0] = $b[0];
            for ($k = 1; $k < $mat->getRows(); $k++) {
                $s = 0;
                for ($x = 0; $x < $k; $x++) {
                    $s += $mat->get($x, $k) * $z[$x];
                }
                $z[$k] = $b[$k] - $s;
            }

            //solving Uw = z
            $z[$rowsMinusOne] = $z[$rowsMinusOne] / $mat->get($rowsMinusOne, $rowsMinusOne);
            for ($k = $rowsMinusOne - 1; $k >= 0; $k--) {
                $s = 0;
                for ($x = $k + 1; $x < $mat->getRows(); $x++) {
                    $s += $mat->get($x, $k) * $z[$x];
                }
                $z[$k] = ($z[$k] - $s) / $mat->get($k, $k);
            }

            //copying data into result Matrix
            for ($x = 0; $x < $mat->getRows(); $x++) {
                $resultMat->set($y, $x, $z[$x]);
            }
        }
        $mat->setData($resultMat->getData());
        return true;
    }
}
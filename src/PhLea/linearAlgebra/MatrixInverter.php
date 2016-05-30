<?php


namespace PhLea\linearAlgebra;


class MatrixInverter
{
    /*@var AbstractLinearSystemSolver */
    private $linearSystemSolver;

    public function __construct(AbstractLinearSystemSolver $linearSystemSolver)
    {
        $this->linearSystemSolver = $linearSystemSolver;
    }

    /**
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

            $z = $this->linearSystemSolver->solve(new Vector($mat->getRows(), $b));

            //copying data into result Matrix
            for ($x = 0; $x < $mat->getRows(); $x++) {
                $resultMat->set($y, $x, $z[$x]);
            }
        }
        $mat->setData($resultMat->getData());
        return true;
    }
}
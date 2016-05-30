<?php


namespace PhLea\linearAlgebra;


class SolverLU extends AbstractLinearSystemSolver
{
    /**
     * @param Mat $A
     */
    public function __construct(Mat $A)
    {
        parent::__construct($A);
        $matrixDecompositionLU = LinearAlgebraFactory::getInstanceOfMatrixDecompositionLU();
        $matrixDecompositionLU->decompose($this->A);
    }

    /**
     * Returns true if the inversion is successful and false if the Matrix is singular or not square
     *
     * @param Vector $b
     * @return Vector
     */
    public function solve(Vector $b)
    {
        if ($this->A->getRows() != $this->A->getColumns()) {
            return false;
        }

        $rowsMinusOne = $this->A->getRows() - 1;

        $z = new \SplFixedArray($this->A->getRows());
        $z[0] = $b->getAtIndex(0);
        for ($k = 1; $k < $this->A->getRows(); $k++) {
            $s = 0;
            for ($x = 0; $x < $k; $x++) {
                $s += $this->A->get($x, $k) * $z[$x];
            }
            $z[$k] = $b->getAtIndex($k) - $s;
        }


        $z[$rowsMinusOne] = $z[$rowsMinusOne] / $this->A->get($rowsMinusOne, $rowsMinusOne);
        for ($k = $rowsMinusOne - 1; $k >= 0; $k--) {
            $s = 0;
            for ($x = $k + 1; $x < $this->A->getRows(); $x++) {
                $s += $this->A->get($x, $k) * $z[$x];
            }
            $z[$k] = ($z[$k] - $s) / $this->A->get($k, $k);
        }

        return new Vector($b->getRows(), $z);
    }
}
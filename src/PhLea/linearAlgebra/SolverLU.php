<?php


namespace PhLea\linearAlgebra;


class SolverLU extends AbstractLinearSystemSolver
{
    /** @var Mat */
    private $permutationMat;

    /**
     * @param Mat $A
     */
    public function __construct(Mat $A)
    {
        parent::__construct($A);
        $matrixDecompositionLU = LinearAlgebraFactory::getInstanceOfMatrixDecompositionLU();
        $matrixDecompositionLU->decompose($this->A);
        $this->permutationMat = $matrixDecompositionLU->getPermutationMatrix();
    }

    /**
     * @param Vector $b
     * @return Vector
     */
    public function solve(Vector $b)
    {
        $z = new \SplFixedArray($this->A->getRows());
        for ($y = 0; $y < $this->A->getRows(); $y++) {
            for ($x = 0; $x < $this->A->getColumns(); $x++) {
                if ($this->permutationMat->get($x, $y) != 0) {
                    $z[$y] = $b->getAtIndex($x);
                    break;
                }
            }
        }

        for ($y = 0; $y < $this->A->getRows(); $y++) {
            for ($x = 0; $x < $y; $x++) {
                $z[$y] -= $this->A->get($x, $y) * $z[$x];
            }
        }

        for ($y = $this->A->getRows() - 1; $y >= 0; $y--) {
            for ($x = $y + 1; $x < $this->A->getRows(); $x++) {
                $z[$y] -= $this->A->get($x, $y) * $z[$x];
            }
            $z[$y] = $z[$y] / $this->A->get($y, $y);
        }

        return new Vector($b->getRows(), $z);
    }
}
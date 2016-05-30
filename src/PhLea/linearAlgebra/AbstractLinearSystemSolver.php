<?php


namespace PhLea\linearAlgebra;


abstract class AbstractLinearSystemSolver implements LinearSystemSolverInterface
{
    /*@var Mat */
    protected $A;

    public function __construct(Mat $A)
    {
        $this->A = $A;
    }
}
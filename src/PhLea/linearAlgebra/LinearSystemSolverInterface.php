<?php

namespace PhLea\linearAlgebra;


interface LinearSystemSolverInterface
{

    /**
     * @param Mat $A
     */
    public function __construct(Mat $A);

    /**
     * @param Vector $b
     * @return Vector
     */
    public function solve(Vector $b);
}
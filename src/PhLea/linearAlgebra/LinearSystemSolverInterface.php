<?php

namespace PhLea\linearAlgebra;


interface LinearSystemSolverInterface
{

    public function __construct(Mat $A);

    public function solve(Vector $b);
}
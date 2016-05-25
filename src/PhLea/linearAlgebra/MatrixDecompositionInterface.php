<?php


namespace PhLea\linearAlgebra;


interface MatrixDecompositionInterface
{
    public function decompose(Mat $mat);
}
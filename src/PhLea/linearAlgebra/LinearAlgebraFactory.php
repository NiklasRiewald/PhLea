<?php


namespace PhLea\linearAlgebra;


class LinearAlgebraFactory
{

    /**
     * @return MatrixDecompositionLU
     */
    public function getInstanceOfMatrixDecompositionLU() {
        return new MatrixDecompositionLU();
    }

    /**
     * @return MatrixInverter
     */
    public function getInstanceOfMatrixInverter() {
        return new MatrixInverter($this->getInstanceOfMatrixDecompositionLU());
    }
}
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
     * @return MatrixInverterLU
     */
    public function getInstanceOfMatrixInverterLU() {
        return new MatrixInverterLU($this->getInstanceOfMatrixDecompositionLU());
    }
}
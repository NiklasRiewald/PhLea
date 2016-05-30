<?php


namespace PhLea\linearAlgebra;


class LinearAlgebraFactory
{

    /**
     * @return MatrixDecompositionLU
     */
    public static function getInstanceOfMatrixDecompositionLU()
    {
        return new MatrixDecompositionLU();
    }

    /**
     * @param Mat $A
     * @return MatrixInverter
     */
    public static function getInstanceOfMatrixInverterLU(Mat $A)
    {
        return new MatrixInverter(LinearAlgebraFactory::getInstanceOfSolverLU($A));
    }

    /**
     * @param Mat $A
     * @return SolverLU
     */
    public static function getInstanceOfSolverLU(Mat $A)
    {
        return new SolverLU($A);
    }
}
<?php

namespace PhLea\regression;

use PhLea\linearAlgebra\Mat;

class MultipleLinearRegression
{

    /**
     * Solves min ||Ax - b|| for x where ||*|| is the L2-Norm
     *
     * @param Mat $A
     * @param Mat $b
     * @param bool $addBiasTerm
     * @return Mat
     */
    public function computeLinearModel(Mat $A, Mat $b, $addBiasTerm = true)
    {
        $At = $A->getRealTranspose();
        $result = $At->dot($A);
        $result->inverse();
        $result = $result->dot($At);
        return $result->dot($b);
    }
}
<?php

namespace PhLea\regression;

use PhLea\linearAlgebra\Mat;
use PhLea\linearAlgebra\Vector;

class MultipleLinearRegression
{

    /** @var Mat */
    private $coefficients;

    /**
     * Solves min ||Ax - b|| for x where ||*|| is the L2-Norm
     *
     * @param Mat $A
     * @param Vector $b
     * @return Mat
     */
    public function fit(Mat $A, Vector $b)
    {
        $At = $A->getRealTranspose();
        $result = $At->dot($A);
        $result->invert();
        $result = $result->dot($At);
        $this->coefficients = $result->dot($b);
    }

    /**
     * @param Vector $a
     * @return Mat
     */
    public function predict(Vector $a)
    {
        return $this->coefficients->getTranspose()->dot($a);
    }

    /**
     * @return Mat
     */
    public function getCoefficients() {
        return $this->coefficients;
    }
}
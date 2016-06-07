<?php


namespace PhLea\approximation;


class NewtonRaphsonApproximatior
{

    /**
     * For finding the solution to the real valued function f(x) = 0 by iteratively solving x1 = x0 - f(x0)/f'(x0)
     * See https://en.wikipedia.org/wiki/Newton%27s_method
     *
     * @param $function
     * @param $derivative
     * @param float $initialValue
     * @param float $tolerance
     * @param int $maxIterations
     * @return bool|float
     */
    public function approximateFunction(
        $function,
        $derivative,
        $initialValue = 0.0,
        $tolerance = 0.0000001,
        $maxIterations = 20)
    {
        $foundSolution = false;
        $x0 = $initialValue;
        $epsilon = 0.000000000000001;
        for ($i = 1; $i <= $maxIterations; $i++) {
            $y = $function($x0);
            $yDerivative = $derivative($x0);

            if (abs($yDerivative) < $epsilon) {
                break;
            }

            $x1 = $x0 - $y / $yDerivative;

            if (abs($x1 - $x0) <= $tolerance * abs($x1)) {
                $foundSolution = true;
                break;
            }
            $x0 = $x1;
        }

        if ($foundSolution) {
            return $x0;
        }
        return false;
    }
}
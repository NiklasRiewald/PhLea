<?php


namespace PhLea\linearAlgebra;


class MatrixDecompositionLU
{
    /*@var Mat */
    private $permutationMatrix;

    public function decompose(Mat $mat)
    {
        $this->permutationMatrix = Mat::getIdentityMatrix($mat->getRows());
        $rows = $mat->getRows();
        $rowsMinusOne = $rows - 1;
        for ($k = 0; $k < $rowsMinusOne; $k++) {
            for ($y = $k + 1; $y < $rows; $y++) {

                $pivot = $k;
                for ($i = $k + 1; $i < $rows; $i++) {
                    if (abs($mat->get($k, $i)) > abs($mat->get($k, $pivot))) {
                        $pivot = $i;
                    }
                }
                if ($pivot != $k) {
                    $mat->swapRows($pivot, $k);
                    $this->permutationMatrix->swapRows($pivot, $k);
                }

                $mat->set($k, $y, $mat->get($k, $y) / $mat->get($k, $k));

                for ($x = $k + 1; $x < $rows; $x++) {
                    $mat->set($x, $y, $mat->get($x, $y) - ($mat->get($k, $y) * $mat->get($x, $k)));
                }
            }
        }
    }

    public function getPermutationMatrix()
    {
        return $this->permutationMatrix;
    }
}
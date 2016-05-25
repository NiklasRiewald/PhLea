<?php


namespace PhLea\linearAlgebra;


class MatrixDecompositionLU implements MatrixDecompositionInterface
{

    public function decompose(Mat $mat)
    {
        $rows = $mat->getRows();
        $rowsMinusOne = $rows - 1;
        for ($k = 0; $k < $rowsMinusOne; $k++) {
            for ($y = $k + 1; $y < $rows; $y++) {
                $mat->set($k, $y, $mat->get($k, $y) / $mat->get($k, $k));

                for ($x = $k + 1; $x < $rows; $x++) {
                    $mat->set($x, $y, $mat->get($x, $y) - ($mat->get($k, $y) * $mat->get($x, $k)));
                }
            }
        }
    }
}
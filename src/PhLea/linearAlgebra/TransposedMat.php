<?php


namespace PhLea\linearAlgebra;


class TransposedMat extends Mat
{

    public function __construct(Mat $mat)
    {
        $this->data = $mat->data;
        $this->size = $mat->getSize();
        $this->rows = $mat->getColumns();
        $this->columns = $mat->getRows();
    }

    /**
     * @param int $x
     * @param int $y
     * @return float
     */
    public function get($x, $y) {
        return $this->data[$x * $this->rows + $y];
    }

    /**
     * @param int $x
     * @param int $y
     * @return int
     */
    public function getArrayIndex($x, $y) {
        return $x * $this->rows + $y;
    }

    /**
     * @param int $x
     * @param int $y
     * @param float $value
     */
    public function set($x, $y, $value) {
        $this->data[$x * $this->rows + $y] = $value;
    }
}
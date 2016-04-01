<?php


namespace PhLea\matrix;


class TransposedMat extends Mat
{

    public function __construct(Mat $mat)
    {
        $this->data = $mat->data;
        $this->size = $mat->getSize();
        $this->rows = $mat->getColumns();
        $this->columns = $mat->getRows();
    }

    public function get($x, $y) {
        return $this->data[$x * $this->rows + $y];
    }

    public function getArrayIndex($x, $y) {
        return $x * $this->rows + $y;
    }

    public function set($x, $y, $value) {
        $this->data[$x * $this->rows + $y] = $value;
    }
}
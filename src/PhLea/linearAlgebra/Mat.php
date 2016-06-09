<?php

namespace PhLea\linearAlgebra;

class Mat
{
    protected $size;
    protected $rows;
    protected $columns;
    protected $data;

    /**
     * @param int $columns
     * @param int $rows
     * @param \SplFixedArray $data
     */
    public function __construct($columns, $rows, \SplFixedArray $data = null)
    {
        $this->size = $rows * $columns;
        if ($data == null) {
            $this->data = new \SplFixedArray($this->size);
        } else {
            $this->data = $data;
        }

        $this->rows = $rows;
        $this->columns = $columns;
    }

    /**
     * @param Mat mat
     * @return Mat
     */
    public function sum(Mat $mat)
    {
        $resultMat = new Mat($this->columns, $this->rows);
        for ($y = 0; $y < $this->rows; $y++) {
            for ($x = 0; $x < $this->columns; $x++) {
                $index = $this->getArrayIndex($x, $y);
                $resultMat->setAtIndex($index, $this->data[$index] + $mat->getAtIndex($index));
            }
        }
        return $resultMat;
    }

    /**
     * @param Mat mat
     * @return Mat
     */
    public function dot(Mat $matB)
    {
        $columnsB = $matB->getColumns();
        $resultMat = new Mat($columnsB, $this->rows);
        for ($y = 0; $y < $this->rows; $y++) {
            for ($x = 0; $x < $columnsB; $x++) {
                $sum = 0;
                for ($i = 0; $i < $this->columns; $i++) {
                    $sum += $this->get($i, $y) * $matB->get($x, $i);
                }
                $resultMat->set($x, $y, $sum);
            }
        }
        return $resultMat;
    }

    /**
     * @return Mat
     */
    public function getRealTranspose()
    {
        $transposedMat = new Mat($this->rows, $this->columns);
        for ($y = 0; $y < $this->rows; $y++) {
            for ($x = 0; $x < $this->columns; $x++) {
                $transposedMat->set($y, $x, $this->get($x, $y));
            }
        }
        return $transposedMat;
    }

    /**
     * @return TransposedMat
     */
    public function getTranspose()
    {
        return new TransposedMat($this);
    }

    public static function getIdentityMatrix($rows)
    {
        $identityMat = new Mat($rows, $rows);
        for ($j = 0; $j < $rows; $j++) {
            for ($i = 0; $i < $rows; $i++) {
                if ($i == $j) {
                    $identityMat->set($i, $j, 1);
                } else {
                    $identityMat->set($i, $j, 0);
                }
            }
        }
        return $identityMat;
    }

    /**
     * @param int $x
     * @param int $y
     * @return float
     */
    public function get($x, $y)
    {
        return $this->data[$y * $this->columns + $x];
    }

    /**
     * @param int $i
     * @return float
     */
    public function getAtIndex($i)
    {
        return $this->data[$i];
    }

    /**
     * @param int $x
     * @param int $y
     * @return int
     */
    public function getArrayIndex($x, $y)
    {
        return $y * $this->columns + $x;
    }

    /**
     * @param int $y
     * @return TransposedVector
     */
    public function getRow($y) {
        $row = new TransposedVector($this->columns);
        for($i = 0; $i < $this->columns; $i++) {
            $row->setValue($i, $this->get($i, $y));
        }
        return $row;
    }

    /**
     * @param int $x
     * @param int $y
     * @param float $value
     */
    public function set($x, $y, $value)
    {
        $this->data[$y * $this->columns + $x] = $value;
    }

    /**
     * @param int $i
     * @param float $value
     */
    public function setAtIndex($i, $value)
    {
        $this->data[$i] = $value;
    }

    /**
     * @param int $x
     * @param Vector $row
     */
    public function setColumn($x, $row) {
        foreach($row->getData() as $index => $value) {
            $this->set($x, $index, $value);
        }
    }

    /**
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @return int
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->data->getSize();
    }

    /**
     * @return \SplFixedArray
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \SplFixedArray $data
     */
    public function setData(\SplFixedArray $data)
    {
        $this->data = $data;
    }

}
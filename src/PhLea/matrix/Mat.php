<?php

namespace PhLea\matrix;

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

    /**
     * @return Mat
     */
    public function getInverse()
    {
        $inverse = clone $this;
        return $inverse->inverse();
    }

    /**
     * Inverse matrix using LU decomposition
     * Look at http://www.cl.cam.ac.uk/teaching/1314/NumMethods/supporting/mcmaster-kiruba-ludecomp.pdf for an explanation
     * Returns true if the inversion is successful and false if the matrix is singular or not square
     *
     * @return bool
     */
    public function inverse()
    {
        if ($this->rows != $this->columns) {
            return false;
        }

        $resultMat = new Mat($this->columns, $this->rows);

        $this->decomposeIntoLU();
        $rowsMinusOne = $this->rows - 1;

        for ($y = 0; $y < $this->rows; $y++) {

            //initialising b (the y-th unit vector)
            $b = new \SplFixedArray($this->rows);
            for ($x = 0; $x < $this->rows; $x++) {
                if ($y == $x) {
                    $b[$x] = 1;
                } else {
                    $b[$x] = 0;
                }
            }

            //solving Lz = b
            $z = new \SplFixedArray($this->rows);
            $z[0] = $b[0];
            for ($k = 1; $k < $this->rows; $k++) {
                $s = 0;
                for ($x = 0; $x < $k; $x++) {
                    $s += $this->get($x, $k) * $z[$x];
                }
                $z[$k] = $b[$k] - $s;
            }

            //solving Uw = z
            $z[$rowsMinusOne] = $z[$rowsMinusOne] / $this->get($rowsMinusOne, $rowsMinusOne);
            for ($k = $rowsMinusOne - 1; $k >= 0; $k--) {
                $s = 0;
                for ($x = $k + 1; $x < $this->rows; $x++) {
                    $s += $this->get($x, $k) * $z[$x];
                }
                $z[$k] = ($z[$k] - $s) / $this->get($k, $k);
            }

            //copying data into result matrix
            for ($x = 0; $x < $this->rows; $x++) {
                $resultMat->set($y, $x, $z[$x]);
            }
        }
        $this->data = $resultMat->data;
        return true;
    }

    public function decomposeIntoLU()
    {
        $rowsMinusOne = $this->rows - 1;
        for ($k = 0; $k < $rowsMinusOne; $k++) {
            for ($y = $k + 1; $y < $this->rows; $y++) {
                $this->set($k, $y, $this->get($k, $y) / $this->get($k, $k));

                for ($x = $k + 1; $x < $this->rows; $x++) {
                    $this->set($x, $y, $this->get($x, $y) - ($this->get($k, $y) * $this->get($x, $k)));
                }
            }
        }
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

}
<?php

namespace PhLea\matrix;

class Mat
{
    protected $size;
    protected $rows;
    protected $columns;
    protected $data;

    public function __construct($columns, $rows, \SplFixedArray $data = null)
    {
        $this->size = $rows * $columns;
        if($data == null) {
            $this->data = new \SplFixedArray($this->size);
        } else {
            $this->data = $data;
        }

        $this->rows = $rows;
        $this->columns = $columns;
    }

    public function sum(Mat $matB)
    {
        $resultMat = new Mat($this->columns, $this->rows);
        for ($y = 0; $y < $this->rows; $y++) {
            for ($x = 0; $x < $this->columns; $x++) {
                $index = $this->getArrayIndex($x, $y);
                $resultMat->setAtIndex($index, $this->data[$index] + $matB->getAtIndex($index));
            }
        }
        return $resultMat;
    }

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

    public function getTranspose()
    {
        return new TransposedMat($this);
    }

    public function getInverse() {
        $inverse = clone $this;
        return $inverse->inverse();
    }

    //inverse matrix using LU decomposition
    //look at http://www.cl.cam.ac.uk/teaching/1314/NumMethods/supporting/mcmaster-kiruba-ludecomp.pdf for explanation
    public function inverse()
    {
        if ($this->rows != $this->columns) {
            return false;
        }

        $resultMat = new Mat($this->columns, $this->rows);

        $this->decomposeIntoLU();
        $rowsMinusOne = $this->rows-1;

        for ($y = 0; $y < $this->rows; $y++) {

            //initialising b
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
            for($k = $rowsMinusOne - 1; $k >= 0; $k--) {
                $s = 0;
                for($x = $k + 1; $x < $this->rows; $x++) {
                    $s += $this->get($x, $k) * $z[$x];
                }
                $z[$k] = ($z[$k] - $s) / $this->get($k, $k);
            }

            for($x = 0; $x < $this->rows; $x++) {
                $resultMat->set($y, $x, $z[$x]);
            }
        }
        $this->data = $resultMat->data;
        return true;
    }

    public function decomposeIntoLU() {
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

    public function get($x, $y)
    {
        return $this->data[$y * $this->columns + $x];
    }

    public function getAtIndex($i)
    {
        return $this->data[$i];
    }

    public function getArrayIndex($x, $y)
    {
        return $y * $this->columns + $x;
    }

    public function set($x, $y, $value)
    {
        $this->data[$y * $this->columns + $x] = $value;
    }

    public function setAtIndex($i, $value)
    {
        $this->data[$i] = $value;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getSize()
    {
        return $this->data->getSize();
    }

}
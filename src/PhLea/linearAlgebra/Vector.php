<?php


namespace PhLea\linearAlgebra;


class Vector extends Mat
{
    public function __construct($rows, \SplFixedArray $data = null)
    {
        parent::__construct(1, $rows, $data);
    }
}
<?php


namespace PhLea\linearAlgebra;


class Vector extends Mat
{
    public function __construct($size, \SplFixedArray $data = null)
    {
        parent::__construct(1, $size, $data);
    }

    public function setValue($y, $value)
    {
        $this->set(1, $y, $value);
    }
}
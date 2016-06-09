<?php


namespace PhLea\linearAlgebra;


class TransposedVector extends Mat
{
    public function __construct($size, \SplFixedArray $data = null)
    {
        parent::__construct($size, 1, $data);
    }

    public function setValue($x, $value)
    {
        $this->set($x, 0, $value);
    }
}
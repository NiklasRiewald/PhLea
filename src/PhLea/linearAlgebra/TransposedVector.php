<?php


namespace PhLea\linearAlgebra;


class TransposedVector extends Mat
{
    /**
     * @param int $size
     * @param \SplFixedArray $data
     */
    public function __construct($size, \SplFixedArray $data = null)
    {
        parent::__construct($size, 1, $data);
    }

    /**
     * @param int $x
     * @param float $value
     */
    public function setValue($x, $value)
    {
        $this->set($x, 0, $value);
    }
}
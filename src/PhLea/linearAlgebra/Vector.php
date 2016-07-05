<?php


namespace PhLea\linearAlgebra;


class Vector extends Mat
{
    /**
     * @param int $size
     * @param \SplFixedArray $data
     */
    public function __construct($size, \SplFixedArray $data = null)
    {
        parent::__construct(1, $size, $data);
    }

    /**
     * @param int $y
     * @param float $value
     */
    public function setValue($y, $value)
    {
        $this->set(0, $y, $value);
    }
}
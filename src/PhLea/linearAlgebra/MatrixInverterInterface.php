<?php

namespace PhLea\linearAlgebra;


interface MatrixInverterInterface
{
    public function invert(Mat $mat);
}
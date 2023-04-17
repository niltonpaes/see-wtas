<?php

$varTest = "Teste";

class Router
{
    public function b_require()
    {
        echo "b_require - " . $varTest;
        require 'test_c.php';
    }
}
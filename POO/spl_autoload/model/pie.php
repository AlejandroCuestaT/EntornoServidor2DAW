<?php

class Pie {
    public $pie;

    public function __construct($texto)
    {
        $this->pie = $texto;
    }

    public function mostrar() {
        echo "<h1>" . $this->pie . "</h1>";
    }

}

?>
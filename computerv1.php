<?php

include_once "parser.php";

if ($argc == 2)
    $parser = new Parser($argv[1]);
else
    echo "Usage : php computerv1.php \"Your + Mathematic = stuff\"";

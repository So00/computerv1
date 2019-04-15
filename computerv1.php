<?php

include_once "parser.php";
include_once "solve.php";

function parseOption($argv)
{
    $options = array();
    if (array_search("-f", $argv))
        $options["fraction"] = 1;
    if (array_search("-s", $argv))
        $options["step"] = 1;
    return ($options);
}

if ($argc >= 2)
{
    $options = array();
    if ($argc > 2)
        $options = parseOption($argv);
    try
    {
        $parser = new Parser($argv[$argc - 1], $options);
        $data = $parser->getData();
        $parser->reducedForm();
        $solver = new Solve($data, $options);
        if ($solver->array["left"]["pow2"])
        {
            $discri = $solver->discriminant();
            echo "The delta is " . $discri . "\n";
            if ($discri > 0)
                $solver->getBothSolutions();
            else if ($discri == 0)
                $solver->getOneSolution();
            else
                $solver->getComplexSolution();
        }
        else
        {
            echo "The delta doesn't matter in first degre polynom\n";
            $solver->getSolutionWithoutSecond();
        }
    }
    catch (Exception $e)
    {
        echo "An error has occured : " . $e->getMessage() . "\n";
    }
}
else
    echo "Usage : \
    php computerv1.php \"Your + Mathematic = stuff\"\n\
    ";

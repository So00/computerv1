<?php

class       Parser
{  
        public $str;
        public $options;
        public $array;

        function __construct($str, $options)
        {
            $this->str = $str;
            $this->options = $options;
            $this->parse();
        }

        function parse()
        {
            $this->str = str_replace(" ", "", $this->str);
            $split = explode("=" , $this->str);
            $this->array["left"] = $this->parsePol($split[0]);
            $this->array["right"] = $this->parsePol($split[1]);
            $this->array["left"] = $this->transformParsIntoPol($this->array["left"]);
            $this->array["right"] = $this->transformParsIntoPol($this->array["right"]);
            $maxDeg = 0;
            if (!empty($this->options["step"]))
            {
                echo "Detailled : \n";
                $firstOnly = 1;
                foreach ($this->array as $actArray)
                {
                    $start = 1;
                    foreach ($actArray as $pow => $nb)
                    {
                        $pow = intval(substr($pow, 3));
                        if ($pow > $maxDeg && $nb != 0)
                            $maxDeg = $pow;
                        echo (!$start ? ($nb >= 0 ? "+ " : "- ") : "") . ($nb < 0 ? -$nb : $nb) .($pow != 0 ? " * X". ($pow == 2 ? "^$pow": "") : "") . " ";
                        $start = 0;
                    }
                    if ($firstOnly)
                        echo "= ";
                    $firstOnly = 0;
                }
                echo "\n";
            }
            $this->mergeToZero();
        }

        function mergeToZero()
        {
            $this->array["left"]["pow0"] -= $this->array["right"]["pow0"];
            $this->array["right"]["pow0"] = 0;
            $this->array["left"]["pow1"] -= $this->array["right"]["pow1"];
            $this->array["right"]["pow1"] = 0;
            $this->array["left"]["pow2"] -= $this->array["right"]["pow2"];
            $this->array["right"]["pow2"] = 0;
            if ($this->array["left"]["pow2"] === 0 && $this->array["left"]["pow1"] === 0)
            {
                if ($this->array["left"]["pow0"] == 0)
                    throw new Exception("All real numbers are solutions");
                throw new Exception("No solution possible");
            }
        }

        function    getData()
        {
            return ($this->array);
        }

        function    transformParsIntoPol($array)
        {
            $ret = ["pow0" => 0, "pow1" => 0, "pow2" => 0];
            foreach ($array as $actArray)
            {
                if (($pos = stripos($actArray, "x")) === FALSE)
                {
                    $ret["pow0"] += floatval($actArray);
                }
                else
                {
                    while ($pos < strlen($actArray) && (is_numeric($actArray[++$pos]) === FALSE && $actArray[$pos] !== '-' && $actArray[$pos] !== '+'));
                    if ($pos < strlen($actArray))
                        $tmpXpow = floatval(substr($actArray, $pos));
                    else
                        $tmpXpow = 1;
                    if ($actArray[0] == '+' || $actArray[0] == '-' || is_numeric($actArray[0]))
                    {
                        if (!is_numeric($actArray[0]) && !is_numeric($actArray[1]))
                        {
                            $actArray = str_replace(" ", "", $actArray);
                            if ($actArray[1] == "x" || $actArray[1] == "X")
                                $actArray = str_replace(["x", "X"], "1x", $actArray);
                        }
                        $mult = floatval($actArray);
                    }
                    else
                        $mult = 1;
                    if ($tmpXpow > 2 || $tmpXpow < 0 || intval($tmpXpow) != $tmpXpow)
                        throw new Exception("$tmpXpow is not valid for a second degres polynom");
                    $ret["pow$tmpXpow"] += $mult;
                }
            }
            return ($ret);
        }

        function    parsePol($pol)
        {
            //Previous condition
            // || preg_match("/^[+-]?((([+-]?(\d+(\.\d+)?)?\*?x(\^\d+(\.\d+)?)?)*|([+-]?\d+(\.\d+)?)*))/i", $pol) === 0
            if (preg_match("/[a-wy-zA-WY-Z,]/", $pol) || preg_match("/([^\d\/\*\.\^x\+-])/i", $pol))
                throw new Exception("Not a valid polynom");
            preg_match_all("/(([+-]?([+-]?(\d+(\.\d+)?)?\*?x(\^\d+(\.\d+)?)?)|([+-]?\d+(\.\d+)?)))/i", $pol, $array);
            return ($array[0]);
        }

        function reducedForm ()
        {
            $start = 1;
            echo "Reduced form is : \n";
            $maxDeg = 0;
            foreach ($this->array["left"] as $pow => $nb)
            {
                $pow = intval(substr($pow, 3));
                if ($pow > $maxDeg && $nb != 0)
                    $maxDeg = $pow;
                if ($nb != 0)
                    echo ($nb < 0 ? "- " : ($start ?  "" : "+ ")) . ($nb < 0 ? -$nb : $nb) .($pow != 0 ? " * X". ($pow == 2 ? "^$pow": "") : "") . " ";
                $start = 0;
            }
            echo " = 0\n";
            echo "Max degree is $maxDeg \n";
        }
}

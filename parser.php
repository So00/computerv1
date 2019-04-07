<?php

class       Parser
{  
        public $str;
        public $array;

        function __construct($str)
        {
            $this->str = $str;
            $this->parse();
        }

        function parse()
        {
            // $sign = ["+", "-", "*", "=", "/", "^", "X", "x"];
            // foreach ($sign as $actSign)
            //     $this->str = str_replace($actSign, " $actSign ", $this->str);
            // $this->str = str_replace(" ", "", $this->str);
            $this->str = str_replace(" ", "", $this->str);
            $split = explode("=" , $this->str);
            $this->array["left"] = $this->parsePol($split[0]);
            $this->array["right"] = $this->parsePol($split[1]);
            $this->transformParsIntoPol($this->array["left"]);
        }

        function    transformParsIntoPol($array)
        {
            $ret = ["pow0" => 0, "pow1" => 0, "pow2" => 0];
            foreach ($array as $actArray)
            {
                echo $actArray . "\n";
                if (($pos = stripos($actArray, "x")) === FALSE)
                {
                    $ret["pow0"] += intval($actArray);
                }
                else
                {
                    while ($pos < strlen($actArray) && is_numeric($actArray[++$pos]) === FALSE);
                    if ($pos < strlen($actArray))
                        $tmpXpow = intval(substr($actArray, $pos));
                    else
                        $tmpXpow = 1;
                    if (is_numeric($actArray[0]) || ($actArray[0] == '+' || $actArray[0] == '-'))
                        $mult = intval($actArray);
                    else
                        $mult = 1;
                    echo "$tmpXpow => $mult\n";
                    $ret["pow$tmpXpow"] += $mult;
                }
            }
            var_dump($ret);
        }

        function    parsePol($pol)
        {
            if (preg_match("/[a-wy-zA-WY-Z]/", $pol)|| preg_match("/[[\^]{2}|[[\*]{2}|[[\-]{2}|[[\+]{2}|[[\/]{2}/", $pol))
                echo "Nooooo";
            preg_match_all("#([+-]?(?:(?:\d+\*?x\^\d+)|(?:\d+\*?x)|(?:\d+)|(?:x)))#i", $pol, $array);
            return ($array[0]);
        }
}

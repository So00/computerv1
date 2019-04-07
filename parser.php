<?php

class       Parser
{  
        public $str;
        public $array;

        function __construct($str)
        {
            $this->str = $str;
            $this->array = ["left" => ["addition" => 0], "right" => ["addition" => 0]];
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
            $this->parse_pol($split[0], "left");
        }

        function    parse_pol($pol, $key)
        {
            if (preg_match("/[a-wy-zA-WY-Z]/", $pol))
                echo "Nooooo";
            preg_match_all("#([+-]?(?:(?:\d+\*?x\^\d+)|(?:\d+\*?x)|(?:\d+)|(?:x)))#iU", $pol, $array);
            // var_dump($array);
            // preg_match_all("#([+-]?(?:(?:\d+x\^\d+)|(?:\d+x)|(?:\d+)|(?:x)))#i", $pol, $array);
            // $parse = explode("-", $pol);
            // foreach ($parse as $key => $actParse)
            // {
            //     if (empty($actParse))
            //         unset($parse[$key]);
            //     else if ($key)
            //         $parse[$key] = "-" . $actParse;
            // }
            // foreach ($parse as $key => $value)
            // {
            //     $parseAgain = explode("+", $value);
            //     foreach ($parseAgain as $key => $actParse)
            //     {
            //         if (empty($actParse))
            //             unset($parseAgain[$key]);
            //         else
            //             $operation[$key][] = $actParse;
            //     }
            // }
            // var_dump($operation);
        }
}

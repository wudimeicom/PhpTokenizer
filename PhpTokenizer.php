<?php

/*
 * author Yang Qing-rong <admin@wudimei.com>
 * blog: http://wudimei.com/yangqingrong
 */
require_once 'Rong/Text/Utf8String.php';
class PhpTokenizer
{

    public function tokenize($content)
    {

        $arr = array();
        // $string = new Rong_Common_String();
        $utf8String = new Rong_Text_Utf8String($content);

        $arr = $utf8String->getCharArray();
        $arr_count = count($arr);
        $in_php = false;
        $in_string = false; // in php also
        $in_string_var = false;
        $is_line_comment = false;
        $is_block_comment = false;
        $strQuote = "";
        $result = array("");
        $result_index = 0;

        for ($i = 0; $i < $arr_count; $i++)
        {
            $ch = $arr[$i];
            $nextCh = @$arr[$i+1];
            
            if (!isset($result[$result_index + 1]))
            {
                $result[$result_index + 1] = "";
                $result[$result_index + 2] = "";
                $result[$result_index + 3] = "";
                $result[$result_index + 4] = "";
            }


            if ($in_php == false)
            {
                if ($ch == "<")
                {
                    $tag = $utf8String->subString($i, 5);
                    if ($tag == "<?php")
                    {
                        $in_php = true;
                        $i+=5;
                        $result[++$result_index] .= "<?php ";
                        ++$result_index;
                        continue;
                    }
                }
                $result[$result_index] .= $ch;
            } else
            {
                //in php

                if ($in_string == true)
                {

                    if ($ch == "{" && $arr[$i + 1] == '$')
                    {
                        $result[$result_index] .= $strQuote;
                        $result[++$result_index] .= ".";
                        ++$result_index;
                        $in_string_var = true;

                        continue;
                        //$in_string = false;
                    } elseif ($ch == "}" && $in_string_var == true)
                    {
                        $result[++$result_index] .= ".";
                        $result[++$result_index] .= $strQuote;
                        $in_string_var = false;
                        continue;
                        //$in_string = true;
                    } elseif ($in_string_var == true)
                    {
                        $result[$result_index] .= $ch;
                        continue;
                    } elseif ($ch == "\\" && in_array($arr[$i + 1], array("\\", "t", "n", "r", "\"", "'", '$')) == true)
                    {
                        /*if ($arr[$i + 1] == '$')
                        {
                            //don't add
                            continue;
                        } else*/
                        {
                            $result[$result_index] .= $ch . $arr[$i + 1];
                            $i++;
                            continue;
                            
                        }
                    }

                    if ($ch == $strQuote)
                    {
                        if ($in_string_var == true)
                        {
                            $result[$result_index] .= $ch;
                        } else
                        {
                            $in_string = false;
                            $result[$result_index] .= $ch;
                            $result_index++;
                        }
                    } else
                    {
                        $result[$result_index] .= $ch;
                    }
                } elseif ($is_block_comment == true)
                {


                    $str2char = $utf8String->subString($i, 2);
                    if ($str2char == "*/")
                    {
                        $is_block_comment = false;

                        $this->resultElementAppendString($result, $result_index, $str2char);
                        $i++;
                        continue;
                    }
                    $result[$result_index] .= $ch;
                } elseif ($is_line_comment == true)
                {
                    if (in_array($ch, array("\r", "\n")))
                    {
                        $is_line_comment = false;

                        $this->resultElementAppendString($result, $result_index, $ch);
                        $result_index++;
                    }
                    $result[$result_index] .= $ch;
                } else
                {
                    //in code
                    if ($ch == "?")
                    {
                        $tag = $utf8String->subString($i, 2);
                        if ($tag == "?>")
                        {
                            $in_php = false;
                            $i+=1;
                            $result[++$result_index] .= "?>";
                            ++$result_index;
                            continue;
                        } else
                        {
                            $this->resultElementAppendString($result, ++$result_index, $ch);
                        }
                    } elseif (in_array($ch, array("!",  "%", "^", "&", "*", "-", "+", "|", "+",
                                "/", ".", ";", ",", ">", "<", ":", "=")) == true)
                    {
                        if ($arr[$i + 1] == "/" && $ch == "/")
                        {
                            $is_line_comment = true;
                            $this->resultElementAppendString($result, ++$result_index, $ch . "/");
                            $i+=1;
                            continue;
                        } elseif ($utf8String->subString($i, 2) == "/*")
                        {
                            $is_block_comment = true;
                            $this->resultElementAppendString($result, ++$result_index, "/*");
                            $i+=1;
                            continue;
                        } elseif ($utf8String->subString($i, 3) == "!==")
                        {
                            $result[++$result_index] .= "!==";
                            $i+=2;
                            continue;
                        }
                        elseif ($utf8String->subString($i, 3) == "===")
                        {
                            $this->resultElementAppendString($result, ++$result_index, "===");
                            $i+=2;
                            continue;
                        }
                        elseif (in_array($utf8String->subString($i, 2), array($ch . "=", "::", "||", "&&", "++", "--", "->", ">=", "<=", "!=", "=>")))
                        {
                            $str2char = $utf8String->subString($i, 2);
                            if ($str2char == "/*")
                            {
                                $is_block_comment = true;
                                $this->resultElementAppendString($result, ++$result_index, $str2char);
                                $i++;
                                continue;
                            } else
                            {
                                $this->resultElementAppendString($result, ++$result_index, $str2char);
                                $i++;
                                ++$result_index;
                                continue;
                            }
                        }
                        else{
                            $this->resultElementAppendString($result, ++$result_index, $ch);
                            $result_index++;
                        }
                    } elseif ($ch == "\\")
                    {
                       
                       $result[$result_index] .= $ch;//not in string
                    } elseif (in_array($ch, array('"', "'")) == true)
                    {
                        $strQuote = $ch;
                        $in_string = true;
                        $this->resultElementAppendString($result, ++$result_index, $ch);
                    } elseif (in_array($ch, array(",","@", "(", ")", "[", "]", "{", "}")) == true)
                    {
                        $result[++$result_index] .= $ch;
                        ++$result_index;
                    } elseif (in_array($ch, array(" ", "\t", "\r", "\n")) == true)
                    {
                        $result[++$result_index] .= $ch;
                    } else
                    {
                        $this->resultElementAppendString($result, $result_index, $ch);
                    }
                }// end in code
            }//end in php
        }//end for

        $txt = "";
        $arr2 = array();
        $a2 = 0;
        for ($a = 0; $a < $result_index + 1; $a++)
        {
            if (trim(@$result[$a]) != "")
            {
                $txt .= "\$tokenArray[" . $a2++ . "] : " . $result[$a] . " \r\n";
                $arr2[] = $result[$a];
            }
        }
        $this->log($arr2);
        return array("data" => $arr2, "length" => $a2);
    }

    public function resultElementAppendString(&$result, $index, $value)
    {
        if (!isset($result[$index]))
        {
            $result[$index] = "";
        }
        $result[$index].= $value;
    }

    public function log($var)
    {
        $fp = fopen( "log.txt", "a+");
        fwrite($fp, "---------" . print_r($var, true) . "\r\n");
        fclose($fp);
    }

}

?>
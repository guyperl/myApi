<?php
namespace Reshetech\MyApi;

class Utilis
{
	/**
	 * Make a string out of array.
	 *
	 * @param  array
	 * @return string
	 */ 	   
	public static function arrayToString($arr)
	{
	    if(!is_array($arr) || empty($arr)) return;
	
		$string = '';

        foreach($arr as $item)
        {
            $string .= $item;
        }		

        return $string;
    }
	
	
	/**
	 * Write the header for the output.
	 *
	 * @param  string  $msg
	 * @param  integer $code
	 * @param  boolean  $exit
	 * @return 
	 */ 
	public static function writeHeader($msg,$code,$exit=false)
	{
        header($msg,true,$code);
		
		if($exit) exit;
    }
	
	
	/**
	 * Leave only the allowed characters.
	 *
	 * @param  string  $str
	 * @return string
	 */ 
	public static function cleanString($str)
	{
	    return preg_replace('/[^0-9a-zA-Z-_]/','',$str);
	}
	
	
	/**
	 * Leave only the allowed characters in each array item.
	 *
	 * @param  array  $arr
	 * @return array
	 */ 
	public static function cleanArray(array $arr)
	{
	    $cleanArray = array();
		
		foreach($arr as $item)
		{
		    $cleanArray[]=static::cleanString($item);
		}
		
		return $cleanArray;
	}
}

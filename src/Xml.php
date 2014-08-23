<?php
namespace Reshetech\MyApi;

class Xml extends OutputAbstract
{
	/**
	 * Output xml data.
	 *
	 * @return mixed
	 */ 	   
	public function get()
	{  
		$this->objToArray();
	   
		$arr = $this->entries;
		
		$tableName = $this->getTableName();
		
		$fields = $this->getFields();

		$output  = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;

		$output .= "<group-".$tableName.">".PHP_EOL;
	   
		$numOfRows = $this->recordNum;
		
		for($i = 0 ; $i < $numOfRows; $i++)
		{
			$output .= "<".$tableName.">".PHP_EOL;			
			
			foreach($fields as $field)
			{
				$output .= "<".$field.">".$arr[$i][$field]."</".$field.">".PHP_EOL;
			}
			 
			$output .= "</".$tableName.">".PHP_EOL;
		}
		$output .= "</group-".$tableName.">";
	   
        $this->views->setXmlHeader()->getHeader();
		
		$this->views->writeToScreen($output,true);
   }
}

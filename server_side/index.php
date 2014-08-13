<?php
require 'app/configuration/init.php';

// The name of the table to pull results from. e.g. 'hotels'
$tableName = '';

// You can give a different name to the table so the results will have a name which is different than the name of the table. e.g. 'resort'.
//$tableNameAlias = '';

// Name of fields in the table to pull results from. e.g. array('hotel_name','country','date_start','date_end','price')
$fields    = array();

// You can also give a different name to each field for a more friendly and secure field names.
// e.g. array('name','region','start','end','price')
//$fieldsAliases = array();

// Order by clause example. e.g. array('price','asc')
$orderBy = array();
	

if(isset($_POST['key']) && isset($_POST['pass']) && isset($_POST['where']))
{
	// Checks if the user is authenticated according to his key and pass.	
	$authObj  = new \app\classes\MyApiAuth();
	
	$auth = $authObj->isAuth($_POST['key'],$_POST['pass']);
	
	if(!$auth)
	{	
		echo $errors = $authObj->getErrors();	
		echo "Unauthorized distant user.";
		exit;	
	}		
		
			
	// Checks if the returned format is valid. 
	// The returned formats are json or xml.
	$checkFormat = new \app\classes\MyApiFormat($_POST['format']);
	
	$format   = $checkFormat->getFormat();
	
	
	// Query the database for the selected data.
	$posts  = new \app\classes\MyApiPosts();

	$posts->setTableName($tableName);
	
	// You have to pass only one parameter - $fields,
    // you can also pass a second parameter - $fieldsAliases.	
	$posts->setFields($fields);
	
	// Number of posts to get from the database.
	if(isset($_POST['num']))
	{
		$posts->setNum($_POST['num']);
	}
	
	// Where string.
	if(isset($_POST['where']))
    {	
	    $posts->prepareWhere($_POST['where']);
	}
	
	if(isset($orderBy))
	{
	    $posts->setOrderBy($orderBy);
	}
	
	// The results returned from the query.
	$results=$posts->getResults();
	
	if(!$results)
	{
		echo "Query error.<br />"; 
		
		echo $errors = $posts->getErrors();
		
		exit;
	}
	
	// Output the result in xml or json format.
	if(!isset($fieldsAliases)) $fieldsAliases = array();

    if(!isset($tableNameAlias)) $tableNameAlias = '';	

	echo \app\classes\MyApiOutputFactory::createOutput($format,$results,$tableNameAlias,$fieldsAliases);
}
else
{
    echo "<p>Please insert a query string.</p>";
	echo "<p><a href='http://reshetech.co.il/myApi/#query'>Read the documentation</a></p>";
}


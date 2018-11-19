<?php
session_start();
require_once "dbconnect.php";

$sql = "SELECT lastName FROM user_tbl"; //Where mmStatus=1";
$a = $DB->Execute($sql);

$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "")
{ 	
	$q=strtolower($q); 
	$len=strlen($q);

		foreach($a as $name){ 

			if (stristr($q, substr($name['lastName'],0,$len))){ //test if $q matches with the first few characters of the same length in the lastname
				if ($hint===""){ 
					$hint = "<option>". $name['lastName']."</option>";
				}
				else{ 	
					$hint .= "<option>". $name['lastName']."</option>";
				}
			}
		}
}


print $hint;
?>
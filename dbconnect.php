<?php
@$DB = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');
// @ to ignore error message display //
if ($DB->connect_error){
    die("Unable to connect to DB");
	// above 2 statments same as die() //
	}
if (!$DB->select_db ("f34ee"))
    exit("<p>Unable to locate the f34ee database</p>");
?>
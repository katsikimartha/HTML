<?php
//connection to the database
//if connection fails, a message will be shown
//if it cannot open the database, a message will be shown as well
error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE );
if(!mysql_connect("localhost","users_upload","bb2Pdm7W!!"))
{
	die('oops connection problem ! --> '.mysql_error());
}
if(!mysql_select_db("users_upload"))
{
	die('oops database selection problem ! --> '.mysql_error());
}

?>
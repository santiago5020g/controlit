<?php
class DBConnection{
	function getConnection(){
	  //change to your database server/user name/password
		mysql_connect("192.168.200.17","administrador","Gusano2012") or
         die("Could not connect: " . mysql_error());
         mysql_query("SET NAMES 'utf8'");
    //change to your database name
		mysql_select_db("controlit") or 
		     die("Could not select database: " . mysql_error());
	}
}
?>
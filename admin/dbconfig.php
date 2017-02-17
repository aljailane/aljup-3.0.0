<?php

	$DB_HOST = 'sql103.dawnloadgroups.ga';
	$DB_USER = 'daw_15525157';
	$DB_PASS = '0509354461';
	$DB_NAME = 'daw_15525157_aboud';
	
	try{
		$DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER,$DB_PASS);
		$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
	

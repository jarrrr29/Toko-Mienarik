<?php 
	$hostname = 'localhost';
	$username = 'root';
	$password = '';
	$dbname   = 'tester1_db';

	$conn = mysqli_connect($hostname, $username, $password, $dbname) or die ('Gagal terhubung ke database');
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
/*
	'username' => 'krunb4it_alaa',
	'password' => 'alaa@8416841',
	'database' => 'krunb4it_elites',
	*/
	'username' => 'root',
	'password' => '',
	'database' => 'elites',
	
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => TRUE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

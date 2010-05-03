<?php

// Config check
if (!file_exists('conf/config.php'))
{
	die('You need to create conf/config.php from template conf/config.php.template!');
}

// require config
require_once('conf/config.php');

// Read url options
if (array_key_exists('calc_type', $_GET))
{
	$calc_type=$_GET['calc_type'];
}

// get scm management class
require_once('lib/scm_' . $scm_type . '.php');

// Calculator
require_once('lib/calc_' . $calc_type . '.php');

// Visualizer
require_once('lib/visual_' . $visual_type . '.php');

// login
$scm=new scm;
$scm::Login();

// get data
$log=$scm::GetLog();

// calculate
$calc=new calc;
$data=$calc->Calculate($log);

// Get header text
if ($visual_header=='')
{
	$visual_header=$calc->GetHeader();
}

// visualize
$visual=new visual;
$visual->CreatePng($data);

?>

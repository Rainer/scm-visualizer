<?php

// Config check
if (!file_exists('conf/config.php'))
{
	die('You need to create conf/config.php from template conf/config.php.template!');
}

// require config
require_once('conf/config.php');

// Which config should be used?
if (array_key_exists('conf', $_GET))
{
	$useconf=$_GET['conf'];
} else {
	// No config object given -> use first one
	if (count($conf>1))
	{
		$useconf=key($conf);
	} else {
		die('Not configured! Please check your configuration!');
	}
}

// Get config vars
if (array_key_exists($useconf,$conf))
{
	$scm_type=$conf[$useconf]->scm_type;
	$scm_username=$conf[$useconf]->scm_username;
	$scm_password=$conf[$useconf]->scm_password;
	$scm_url=$conf[$useconf]->scm_url;
	$scm_limit=$conf[$useconf]->scm_limit;
	$scm_getpaths=$conf[$useconf]->scm_getpaths;

	$calc_type=$conf[$useconf]->calc_type;

	$visual_type=$conf[$useconf]->visual_type;
	$visual_width=$conf[$useconf]->visual_width;
	$visual_height=$conf[$useconf]->visual_height;
	$visual_fontsize=$conf[$useconf]->visual_fontsize;
	$visual_header=$conf[$useconf]->visual_header;
} else {
	die('Config object '.$useconf.' not found!');
}

// Read url options
if (array_key_exists('calc_type', $_GET))
{
	$calc_type=$_GET['calc_type'];
	if ($calc_type=='files')
	{
		$scm_getpaths=true;
	}
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

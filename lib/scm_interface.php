<?php
// There must be the following values
//$scm_type='svn';
//$scm_user='username';
//$scm_pass='password'
//$scm_url='http://my.url/repopath'

// Interface definition for scm access
interface scm_interface
{

	// Login
	public function Login();

	// get log
	// should return an array of scm_logentry
	public function GetLog();

	// get diff

	// get stats
}

<?php
// There must be the following values
//$calc_type='commit';

// Interface definition for scm access
interface calc_interface
{
	// Calculate
	public function Calculate($log);

	// Get header text
	public function GetHeader();
}

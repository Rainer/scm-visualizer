<?php
require_once('scm_interface.php');
require_once('scm_logentry.php');

// svn scm class
class scm implements scm_interface
{
        // Login
        public function Login()
	{
		global $scm_username,$scm_password;

		// do login
		svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, $scm_username);
		svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, $scm_password);
	}

        // get log
        public function GetLog()
	{
		global $scm_url,$scm_getpaths,$scm_limit;

		// Set flags
		$flags = 0;
		if (!$scm_getpaths)
		{
			$flags=$flags|SVN_DISCOVER_CHANGED_PATHS;
		}

		// get log
		$svnlog=svn_log($scm_url,SVN_REVISION_INITIAL,SVN_REVISION_HEAD,$scm_limit,$flags);

		$returnarray=array();

		foreach ($svnlog as $ent)
		{
			if (array_key_exists('paths',$ent))
			{
				$files = count($ent['paths']);
			} else {
				$files = 0;
			}
			// Get date and time
			$date=substr($ent['date'],0,4).substr($ent['date'],5,2).substr($ent['date'],8,2);
			$time=substr($ent['date'],11,8);
			$aent = new scm_logentry($ent['rev'], $ent['author'], $date, $time, $files, $ent['msg']);

			$returnarray[] = $aent;
		}
		$svnlog=null;

		// quick and dirty
		return $returnarray;
	}
}

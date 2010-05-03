<?php
require_once('calc_interface.php');

// Calculate visualdata
class calc implements calc_interface
{
	// Calculate
	public function Calculate($log)
	{
		$data=array();
		foreach ($log as $ent)
		{
			// Add commit to date
			$author=$ent->scm_author;
			if (array_key_exists($author, $data))
			{
				$data[$author] += 1;
			} else {
				$data[$author] = 1;
			}
		}

		// Sort array
		ksort($data);

		// Return data
		return $data;
	}

	// Header text
	public function GetHeader()
	{
		return "Visualized by number of commits by author";
	}
}

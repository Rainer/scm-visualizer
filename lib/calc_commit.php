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
			$date=$ent->scm_date;
			if (array_key_exists($date, $data))
			{
				$data[$date] += 1;
			} else {
				$data[$date] = 1;
			}
		}
		// TODO: fillup dates here - no commit on a date within min and max will result in a wrong graph
		return $data;
	}

	// Header text
	public function GetHeader()
	{
		return "Visualized by number of commits per date";
	}
}

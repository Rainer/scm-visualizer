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
				$data[$date] += $ent->scm_files;
			} else {
				$data[$date] = $ent->scm_files;
			}
		}

		// get first entry
		reset($data);
		$first=DateTime::createFromFormat('Ymd', key($data));

		// Get last entry
		end($data);
		$last=DateTime::createFromFormat('Ymd', key($data));

		// Create missing date values
		$current=$first;
		$day=new DateInterval('P1D');
		while ($current<$last) {
			$curd=$current->format('Ymd');
			if (!array_key_exists($curd, $data))
			{
				$data[$curd]=0;
			}
			// get next date
			$current=$current->add($day);
		}

		// Sort by key
		ksort($data);

		// Return sorted result
		return $data;
	}

	// Header text
	public function GetHeader()
	{
		return "Visualized by number of changed files per date";
	}
}

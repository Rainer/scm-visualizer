<?php
// scm logentry class interface
class scm_logentry
{
	// id
	public $scm_id;
	// user
	public $scm_author;
	// date
	public $scm_date;
	// time
	public $scm_time;
	// number of files
	public $scm_files;
	// logentry
	public $scm_log;

	public function __construct($id='', $author='', $date='', $time=time, $files=0, $log='')
	{
		$this->scm_id=$id;
		$this->scm_author=$author;
		$this->scm_date=$date;
		$this->scm_time=$time;
		$this->scm_files=$files;
		$this->scm_log=$log;
	}
}

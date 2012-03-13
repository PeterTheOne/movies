<?php

	class TimePeriod {
	
		public $startYear;
		public $endYear;
		public $movies;
	
		public function __construct($startYear, $endYear) {
			$this->startYear = $startYear;
			$this->endYear = $endYear;
			$this->movies = array();
		}
		
		public function add($movie) {
			$this->movies[] = $movie;
		}
	
	}

?>

<?php

	class Cat {
	
		private $id;
		public $name;
		public $timePeriods;
	
		public function __construct($catId, $catName) {
			$this->id = $catId;
			$this->name = $catName;
			$this->timePeriods = array();
		}
		
		public function add($timePeriod) {
			$this->timePeriods[] = $timePeriod;
		}
	
	}

?>

<?php
	class Movie {
		
		public $id;
		public $time_added;
		public $title;
		public $year;
		public $imdb_id;
		public $imdb_rating;
		public $seen;
		public $comment;
		public $cat;
		public $rank;
		
		public function __construct($dataArray) {
			$this->id = $dataArray['id'];
			$this->time_added = $dataArray['time_added'];
			$this->title = $dataArray['title'];
			$this->year = $dataArray['year'];
			$this->imdb_id = $dataArray['imdb_id'];
			$this->imdb_rating = $dataArray['imdb_rating'];
			$this->seen = $dataArray['seen'];
			$this->comment = $dataArray['comment'];
			$this->cat = $dataArray['cat'];
			$this->rank = $dataArray['rank'];
		}
		
		public function swap($con, $swapMovie) {
			//TODO: transaction?
			$rankBackup = $this->rank;
			$this->rank = $swapMovie->rank;
			$swapMovie->rank = $rankBackup;
			
			$q = "UPDATE movies SET rank = " . $this->rank . " WHERE id = " . $this->id;
			$result1 = mysqli_query($con, $q);
			$q = "UPDATE movies SET rank = " . $swapMovie->rank . " WHERE id = " . $swapMovie->id;
			$result2 = mysqli_query($con, $q);
			return $result1 && $result2;
		}
		
	}
?>

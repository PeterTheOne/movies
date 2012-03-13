<?php
	include_once('database.inc.php');
	include_once('movie.inc.php');
	include_once('timeperiod.inc.php');
	include_once('cat.inc.php');
	
	class Movies {

		private $con;
		public $seenMovies;
		public $unseenMovies;
		
		public function __construct($con) {
			$this->con = $con;
			$this->seenMovies = array();
			$this->unseenMovies = array();
			$this->loadSeenMovies();
			$this->loadUnseenMovies();
		}
		
		private function loadSeenMovies() {
			$cats = $this->getCats(false);
			if ($cats) {
				foreach ($cats as $cat) {
					$this->echoMoviesByCat($cat['id'], $cat['name']);
				}
				$this->echoMoviesByCat(1, "Unsorted");
			}
		}
		
		private function loadUnseenMovies() {
			$this->echoMoviesAllUnseen();
		}
		
		public function getCats($getUnsorted) {
			$q = "SELECT * FROM movies_cats";
			if (!$getUnsorted) {
				$q .= " WHERE id <> 1";
			}
			$result = mysqli_query($this->con, $q);
			if (db_hasErrors($this->con, $result)) {
				return false;
			}
			$cats = array();
			while ($line = mysqli_fetch_array($result)) {
				$cats[] = $line;
			}
			return $cats;
		}
		
		private function echoMoviesByCat($catId, $catName) {
			$allSeenMoviesByCat = $this->getMovies(true, $catId);
			$movieCount = mysqli_num_rows($allSeenMoviesByCat);
			
			if ($movieCount > 0) {
			
				$cat = new Cat($catId, $catName);
			
				$minYear = $this->getMinYearByCat(true, $catId);
				$maxYear = $this->getMaxYearByCat(true, $catId);
				
				if ($movieCount < 10 || $minYear === $maxYear) {
				
					$timePeriod = new TimePeriod($minYear, $maxYear);
					
					$movieResult = $this->echoMovies123(true, false, $catId);
					while ($row = mysqli_fetch_array($movieResult)) {
						$timePeriod->add(new Movie($row));
					}
					$cat->add($timePeriod);
					
				} else {
					$firstDecade = $this->getDecade($minYear);
					$lastDecade = $this->getDecade($maxYear);
					$currentDecade = $lastDecade;
					while ($currentDecade >= $firstDecade) {
					
						$timePeriod = new TimePeriod($currentDecade, $currentDecade + 10);
						
						$movieResult = $this->echoMovies123(true, true, $catId, $currentDecade);
						while ($row = mysqli_fetch_array($movieResult)) {
							$timePeriod->add(new Movie($row));
						}
						$cat->add($timePeriod);
						
						$currentDecade -= 10;
					}
				}
				$this->seenMovies[] = $cat;
			}
		}
		
		private function echoMoviesAllUnseen() {
			$allUnSeenMovies = $this->getMovies(false);
			$movieCount = mysqli_num_rows($allUnSeenMovies);
			
			if ($movieCount > 0) {
				
				$minYear = $this->getMinYearByCat(false);
				$maxYear = $this->getMaxYearByCat(false);
				
				if ($movieCount < 20 || $minYear === $maxYear) {
					
					$timePeriod = new TimePeriod($minYear, $maxYear);
				
					$movieResult = $this->echoMovies123(false, false, 0);
					while ($row = mysqli_fetch_array($movieResult)) {
						$timePeriod->add(new Movie($row));
					}
					$this->unseenMovies[] = $timePeriod;
					
				} else {				
					$firstDecade = $this->getDecade($minYear);
					$lastDecade = $this->getDecade($maxYear);
					$currentDecade = $lastDecade;
					while ($currentDecade >= $firstDecade) {
					
						$timePeriod = new TimePeriod($currentDecade, $currentDecade + 10);
						
						$movieResult = $this->echoMovies123(false, true, 0, $currentDecade);
						while ($row = mysqli_fetch_array($movieResult)) {
							$timePeriod->add(new Movie($row));
						}
						$this->unseenMovies[] = $timePeriod;
						
						$currentDecade -= 10;
					}
				}
			}
		}
		
		private function getMovies($seen, $catId = 0) {
			$q = "SELECT * FROM movies";
			if ($seen) {
				$q .= " WHERE cat = " . $catId;
				$q .= " AND seen = 1";
			} else {
				$q .= " WHERE seen = 0";
			}
			$result = mysqli_query($this->con, $q);
			if (!$result) {
				die('Failed to getMovies: ' . mysqli_error($this->con));
			}
			return $result;
		}
		
		private function getMinYearByCat($seen, $catId = 0) {
			$q = "SELECT MIN(year) as minYear  FROM movies";
			if ($seen) {
				$q .= " WHERE cat = " . $catId;
				$q .= " AND seen = 1";
			} else {
				$q .= " WHERE seen = 0";
			}
			$statsResult = mysqli_query($this->con, $q);
			$statsRow = mysqli_fetch_array($statsResult);
			return $statsRow['minYear'];
		}
		
		private function getMaxYearByCat($seen, $catId = 0) {
			$q = "SELECT MAX(year) as maxYear  FROM movies";
			if ($seen) {
				$q .= " WHERE cat = " . $catId;
				$q .= " AND seen = 1";
			} else {
				$q .= " WHERE seen = 0";
			}
			$statsResult = mysqli_query($this->con, $q);
			$statsRow = mysqli_fetch_array($statsResult);
			return $statsRow['maxYear'];
		}
		
		private function inSameDecade($minYear, $maxYear) {
			return $this->getDecade($minYear) === $this->getDecade($maxYear);
		}
		
		private function getDecade($year) {
			return substr_replace($year, "0", -1, 1);
		}
		
		private function echoMovies123($seen, $byDecade, $catId, $currentDecade = 0) {
			$q = "SELECT * FROM movies";
			if ($seen) {
				$q .= " WHERE cat = " . $catId;
				$q .= " AND seen = 1";
			} else {
				$q .= " WHERE seen = 0";
			}
			if ($byDecade) {
				$q .= " AND year >= " . $currentDecade;
				$q .= " AND year < " . ($currentDecade + 10);
			}
			$q .= " ORDER BY rank ASC";
			$result = mysqli_query($this->con, $q);
			if (!$result) {
				die('Failed to echoMovies123: ' . mysqli_error($this->con));
			}
			return $result;
		}
		
		public function oneUp($id) {
			foreach ($this->seenMovies as $cat) {
				foreach ($cat->timePeriods as $timePeriod) {
					foreach ($timePeriod->movies as $i => $movie) {
						if ($movie->id == $id) {
							if ($i <= 0) {
								//do nothing
							} else {
								$swapMovie = $timePeriod->movies[$i - 1];
								if ($movie->swap($this->con, $swapMovie)) {
									$timePeriod->movies[$i - 1] = $movie;
									$timePeriod->movies[$i] = $swapMovie;
								}
								return true;
							}
						}
					}
				}
			}
			return false;
		}
		
		public function oneDown($id) {
			foreach ($this->seenMovies as $cat) {
				foreach ($cat->timePeriods as $timePeriod) {
					foreach ($timePeriod->movies as $i => $movie) {
						if ($movie->id == $id) {
							if ($i >= count($timePeriod->movies) - 1) {
								//do nothing
							} else {
								$swapMovie = $timePeriod->movies[$i + 1];
								if ($movie->swap($this->con, $swapMovie)) {
									$timePeriod->movies[$i + 1] = $movie;
									$timePeriod->movies[$i] = $swapMovie;
								}
								return true;
							}
						}
					}
				}
			}
			return false;
		}
		
	}
?>

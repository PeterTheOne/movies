$(function() {
	// TODO: validate input: is year a year
		
	$('input[name|="imdb_id"]').focusout(function() {
		var title = $('input[name|="title"]').val();
		var imdb_id = $('input[name|="imdb_id"]').val();
		var year = $('input[name|="year"]').val();
		
		var url_base = 'http://www.imdbapi.com/';
		var url_imdb_id = '?i=' + imdb_id;
		var url_title = '?t=' + title;
		var url_year = '&y=' + year;
		var url_callback = '&callback=?';
		
		if (imdb_id != '') {
			$('p#status').html('status: searching by id');
			var url = url_base + url_imdb_id + url_callback;
			$.getJSON(url , function(data) {
				$('p#status').html('status: found');
				$('input[name|="title"]').val(data.Title);
				$('input[name|="year"]').val(data.Year);
				$('input[name|="imdb_rating"]').val(data.Rating);
			});
		}
	});
	
	$('input[name|="title"]').focusout(function() {
		var title = $('input[name|="title"]').val();
		var imdb_id = $('input[name|="imdb_id"]').val();
		var year = $('input[name|="year"]').val();
		
		var url_base = 'http://www.imdbapi.com/';
		var url_imdb_id = '?i=' + imdb_id;
		var url_title = '?t=' + title;
		var url_year = '&y=' + year;
		var url_callback = '&callback=?';
		
		if (title != '') {
			if (year != '') {
				$('p#status').html('status: searching by title and year');
				var url = url_base + url_title + url_year + url_callback;
			} else {
				$('p#status').html('status: searching by title');
				var url = url_base + url_title + url_callback;
			}
			$.getJSON(url, function(data) {
				var yearMatch = false;
				if (year != '') {
					if (year == data.Year) {
						yearMatch = true;
					} else {
						// can leave away
						yearMatch = false;
					}
				} else {
					yearMatch = true;
				}
				
				$('p#status').html('status: do you mean ' + data.Title + 
					' (' + data.Year + ') ?');
				
				if (title.toLowerCase() == data.Title.toLowerCase() && 
						yearMatch) {
					$('p#status').html('status: found');
					$('input[name|="imdb_id"]').val(data.ID);
					$('input[name|="year"]').val(data.Year);
					$('input[name|="imdb_rating"]').val(data.Rating);
				}
			});
		}		
	});
	
	$('select[name|="cat"]').click(function() {
		$('input[name|="catradio"][value="cat"]').prop('checked', true);
		$('input[name|="catradio"][value="newcat"]').prop('checked', false);
		$('input[name|="newcat"]').prop('required', false);
	});
	
	$('input[name|="newcat"]').focus(function() {
		$('input[name|="catradio"][value="cat"]').prop('checked', false);
		$('input[name|="catradio"][value="newcat"]').prop('checked', true);
		$('input[name|="newcat"]').prop('required', true);
	});
	
	$('input[name|="catradio"][value="cat"]').click(function() {
		$('input[name|="newcat"]').prop('required', false);
	});
	
	$('input[name|="catradio"][value="newcat"]').click(function() {
		$('input[name|="newcat"]').prop('required', true);
	});
});

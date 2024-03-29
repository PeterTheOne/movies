$(function() {
	// TODO: validate input: is year a year
	
	// constants:
	var url_base = 'http://www.imdbapi.com/';
	var url_callback = '&callback=?';
	
	// variable:
	var dataFound = null;
		
	$('input[name|="imdb_id"]').focusout(function() {
		// cleanup
		$('p#status').removeClass('do-you-mean');
		
		// set variables
		var title = $('input[name|="title"]').val();
		var imdb_id = $('input[name|="imdb_id"]').val();
		var year = $('input[name|="year"]').val();
		
		var url_imdb_id = '?i=' + imdb_id;
		var url_title = '?t=' + title;
		var url_year = '&y=' + year;
		
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
		// cleanup
		$('p#status').removeClass('do-you-mean');
		
		// set variables
		var title = $('input[name|="title"]').val();
		var imdb_id = $('input[name|="imdb_id"]').val();
		var year = $('input[name|="year"]').val();
		
		var url_imdb_id = '?i=' + imdb_id;
		var url_title = '?t=' + title;
		var url_year = '&y=' + year;
		
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
				
				if (title.toLowerCase() == data.Title.toLowerCase() && 
						yearMatch) {
					$('p#status').html('status: found');
					$('input[name|="title"]').val(data.Title);
					$('input[name|="imdb_id"]').val(data.ID);
					$('input[name|="year"]').val(data.Year);
					$('input[name|="imdb_rating"]').val(data.Rating);
				} else {
					$('p#status').html('status: do you mean ' + data.Title + 
						' (' + data.Year + ') ?').addClass('do-you-mean');
					dataFound = data;
				}
			});
		}		
	});
	
	$('p#status').click(function() {
		if ($(this).hasClass('do-you-mean') && dataFound != null) {
			$('p#status').removeClass('do-you-mean');
			$('p#status').html('status: found');
			$('input[name|="title"]').val(dataFound.Title);
			$('input[name|="imdb_id"]').val(dataFound.ID);
			$('input[name|="year"]').val(dataFound.Year);
			$('input[name|="imdb_rating"]').val(dataFound.Rating);
			dataFound = null;
		}
	});
	
	// TODO: after submit with error, it must be checked what fields are required
	
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

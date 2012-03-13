<tr id="{$movie->id}">
	<td>
		<a href="http://www.imdb.com/title/{$movie->imdb_id}">
			<strong>{$movie->title}</strong> 
			({$movie->year})
		</a>
	</td>
	<td>
		{$movie->imdb_rating}
	</td>
	<td>
		{$movie->comment}
	</td>
{if $seen && $logged_in}
	<td>
		<!--TODO: link to other file and redirect back -->
		<a href="updown.php?oneup={$movie->id}">oneup</a>
	</td>
	<td>
		<!--TODO: link to other file and redirect back -->
		<a href="updown.php?onedown={$movie->id}">onedown</a>
	</td>
{/if}
</tr>

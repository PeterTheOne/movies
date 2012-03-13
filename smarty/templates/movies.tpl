<table>
<tr>
	<td>
		<h2>Seen Movies</h2>
	</td>
</tr>
{assign var="seen" value="true"}
{foreach $movies->seenMovies as $cat}
{include file="movie_cat.tpl"}
{foreachelse}
<tr>
	<td>no movies</td>
</tr>
{/foreach}
<tr>
	<td>
		<h2>Unseen Movies</h2>
	</td>
</tr>
{assign var="seen" value="false"}
{foreach $movies->unseenMovies as $timePeriod}
{include file="movie_time-period.tpl"}
{foreachelse}
<tr>
	<td>no movies</td>
</tr>
{/foreach}
</table>

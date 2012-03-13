{*if (count($this->movies) > 0)*}
{if $timePeriod->startYear == $timePeriod->endYear}
<tr>
	<td>
		<h4>{$timePeriod->startYear}</h4>
	</td>
</tr>
{else}
<tr>
	<td>
		<h4>{$timePeriod->startYear} - {$timePeriod->endYear}</h4>
	</td>
</tr>
{/if}
<tr>
	<td>Title (Year)</td>
	<td>IMDB Rating</td>
	<td>Comment</td>
{if isset($logged_in) && $seen}
	<td>Up</td>
	<td>Down</td>
{/if}
</tr>
{foreach $timePeriod->movies as $movie}
{include file="movie.tpl"}
{/foreach}
{*/if*}

<tr>
	<td>
		<h3>{$cat->name}</h3>
	</td>
</tr>
{foreach $cat->timePeriods as $timePeriod}
{include file="movie_time-period.tpl"}
{/foreach}

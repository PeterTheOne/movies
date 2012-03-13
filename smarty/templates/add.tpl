{include file="head.tpl"}
	<body>
		<header>
			<h1>Movies seen by Peter Grassberger</h1>
			<nav>
{if isset($logged_in)}
				<a href="index.php">normal</a> | 
				<a href="add.php">add</a> | 
				<a href="admin_logout.php">logout</a>
{else}
				<a href="admin_login.php">login</a>
{/if}
			</nav>
		</header>
{if isset($error)}
			<ul>
{$error}
			</ul>
{/if}
		<p id="status">status: idle</p>
		<form action="add.php" method="post">
			<table>
			<tr>
				<td>imdb_id:</td>
				<td>
					<input type="text" name="imdb_id" 
						{if isset($param_imdb_id)}value="{$param_imdb_id}" {/if}
						required />
				</td>
			</tr>
			<tr>
				<td>title:</td>
				<td>
					<input type="text" name="title" 
						{if isset($param_title)}value="{$param_title}" {/if}
						required />
				</td>
			</tr>
			<tr>
				<td>year:</td>
				<td>
					<input type="text" name="year" 
						{if isset($param_year)}value="{$param_year}" {/if}
						required />
				</td>
			</tr>
			<tr>
				<td>imdb_rating:</td>
				<td>
					<input type="text" name="imdb_rating" 
						{if isset($param_imdb_rating)}value="{$param_imdb_rating}" {/if}
						required />
				</td>
			</tr>
			<tr>
				<td>seen:</td>
				<td>
					<input type="checkbox" name="seen" {if isset($param_seen)}checked {/if}/>
				</td>
			</tr>
			<tr>
				<td>comment:</td>
				<td>
					<input type="text" name="comment" 
						{if isset($param_imdb_id)}value="{$param_comment}" {/if}required />
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="catradio" value="cat" 
						{if !isset($param_catradio) || $param_catradio == 'cat'}checked {/if}required />cat:
				</td>
				<td>
					<select name="cat" required>
{foreach $cats as $cat}
						<option value="{$cat['id']}" {if isset($param_cat) && $cat['id'] == $param_cat}selected {/if}>{$cat['name']}</option>
{/foreach}			
					</select>
				</td>
			</tr>	
			<tr>
				<td>
					<input type="radio" name="catradio" value="newcat"  
						{if isset($param_catradio) && $param_catradio == 'newcat'}checked {/if}required />new cat:
				</td>
				<td>
					<input type="text" name="newcat" {if isset($param_newcat)}value="{$param_newcat}" required{/if} />
				</td>
			</tr>
			</table>
			<input class="token" name="token" type="hidden" value="{$token}" />
			<input type="submit" value="submit" />
		</form>
	</body>
</html>


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
			imdb_id: <input type="text" name="imdb_id" {if isset($param_imdb_id)}value="{$param_imdb_id}" {/if}required /><br />
			title: <input type="text" name="title" {if isset($param_title)}value="{$param_title}" {/if}required /><br />
			year: <input type="text" name="year" {if isset($param_year)}value="{$param_year}" {/if}required /><br />
			imdb_rating: <input type="text" name="imdb_rating" {if isset($param_imdb_rating)}value="{$param_imdb_rating}" {/if}required /><br />
			seen: <input type="checkbox" name="seen" {if isset($param_seen)}checked {/if}/><br />
			comment: <input type="text" name="comment" {if isset($param_imdb_id)}value="{$param_comment}" {/if}/><br />
			cat: <select name="cat"required>
{foreach $cats as $cat}
			<option value="{$cat['id']}" {if isset($param_cat) && $cat['id'] == $param_cat}selected {/if}>{$cat['name']}</option>
{/foreach}			
			</select><br />
			<input class="token" name="token" type="hidden" value="{$token}" />
			<input type="submit" value="submit" />
		</form>
	</body>
</html>


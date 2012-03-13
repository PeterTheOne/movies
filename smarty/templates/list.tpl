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
{if isset($info)}
			<ul>
{$info}
			</ul>
{/if}
{if isset($error)}
			<ul>
{$error}
			</ul>
{/if}	
{include file="movies.tpl"}
	</body>
</html>

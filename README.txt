movies
======

[movies](http://petergrassberger.com/movies) is a project where i try to list 
every movie i have seen.

Created by:
-----------
- [Peter Grassberger (PeterTheOne)](http://petergrassberger.com)

Install:
--------
1. download and copy dependencies (see below) to root or js directory.
2. rename sample_config.inc.php to config.inc.php .
3. add MySql-server connection constants in config.inc.php .
4. upload to webserver or use xampp on local machine.
5. set read permissions for smarty/cache and smarty/templates_c
6. create tables by running setup_createtables.php
7. remove setup_createtables.php and other unused files from production server.
8. have fun!

Dependencies:
-------------
- Smarty-3.1.3:
	- Site: http://www.smarty.net/
	- Path: /Smarty-3.1.3/libs/Smarty.class.php
- jQuery 1.7.1:
	- Site: http://jquery.com/
	- Source: http://github.com/jquery/jquery
	- Path: /jquery-1.7.1/jquery-1.7.1.min.js

UnitEngine
==========

A distributed PHP framework powered by small units of social, dependency-aware code. UnitEngine allows you to bring small functions and classes from the [gist.github.com](https://gist.github.com) universe into your project with ease. It's basically like [composer](http://getcomposer.org/) for gists.

About
=====

Developers often find existing libraries and frameworks lacking certain foresight, performance optimisations, documentation, or unit tests. This is often expected since libraries are usually written by less than a couple people. The old saying, "No one can do everything, but everyone can do something." rings true in many projects lacking enough hands.

Unit Engine splits code generation, documentation, and unit tests up into smaller bit-size chunks allowing many people to contribute in a very easy way. This means that each person can write the small bit of code they specialize in resulting in much better quality, performance, and documentation. 

Features
========

 * Supports nested, recursive dependencies
 * Based on git version control (though code can be managed completely through the web interface)
 * Supports [unit tests](http://phpunit.de/manual/3.7/en/writing-tests-for-phpunit.html)
 * [Easy to contribute](#basegisthere)

Share Your Code
===============

Have a good unit of code you want to share? Simply [fork the starter gist](#) with your code, add a description, and create a simple unit test. Only takes a couple minutes to make your function available to the world.

Install
=======

A) Simply checkout the latest copy of UnitEngine or 

	$ git clone https://github.com/Xeoncross/UnitEngine.git

B) Download the project using [composer](http://getcomposer.org/doc/00-intro.md) by creating a `composer.json` and running "`$ composer install`" from the command line.

	{
		"require": {
			"xeoncross/unitengine": "dev-master"
		},
	}


Getting Started
===============

From your project folder you can now create a `units.txt` which contains the URL's of all the gists you need for your project (along with any text you want). For example, consider the following example `units.txt` file:

	# My Project

	We need a good [array_sort method](http://gist.github.com/1234567890000)
	and a [cURL wrapper](http://gist.github.com/0000987654321).

After you have a `units.txt` file you can run the unit engine update manager to checkout the latest versions of the functions and classes you need.

	$ php UnitEngine/update.php

After UnitEngine installs all the required code, (and their dependencies), you can include the compiled output by including the `UnitEngine/UnitEngine.php` file in your code.

	<?php
	
	require('UnitEngine/UnitEngine.php');

	...your code here...

KISS
====

We encourage developers to write small chunks of reusable code by providing a simple parser which counts how many logical commands you are doing in your code. We recommend people keep their code down to less than 100 actions.

	$ php UnitEngine/parser.php ../path/to/file.php

UnitEngine is built for small functional blocks - not whole libraries. If your code is larger then you might want to setup a [full github repository](https://github.com/) and register the library with [packigist](https://packagist.org/). 

UnitEngine ♡ Composer.

Namespacing
===========

All UnitEngine blocks **should** be namespaced. Namespacing your code will prevent clashes with other functions and gists and provide easier seporation for unit testing.

Web Admin
=========

If you are on an environment which does not provide command-line access (i.e. shared hosting), you can upload a [copy of the UnitEngine source code](https://github.com/Xeoncross/UnitEngine/archive/master.zip), then create a web_update.php file and paste the following into it assuming [PHP](http://php.net) and [git](http://git-scm.com/) are installed on the server and registered on the system $PATH.

	<?php passthru('php UnitEngine/update.php');

_Make sure you delete this file when you are done!_
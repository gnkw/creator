# GNKW Creator

## Introduction

This creator is used to __generate__ some PHP Classes in an __organized structure__. It use an __autoloader__, so you can easily call the classes you want between them and from a php main script by calling the autoloader. It also let you create __PHPUnit__ test classes to test your php classes.

To use this Creator you need to have __read and write__ rights to create files by PHP.

## Create a class

You can create a class by using this command (replace __Name/Space__ and __MyClass__ by your datas) :

	$ php app/console.php create class Name/Space MyClass

## Create a test class

To create a __test class__ for a class using __PHPUnit__, it's a similar syntax :

	$ php app/console.php create test Name/Space MyClass

Note : If the original class don't exist, the test class can't be created.

## Use a class

Copy the `index.php` example file to your web directory

	$ mkdir web && cp examples/index.php web/.

After that, you want use your classes, so go to the `web/index.php` file and use or precise the namespace in the __Your Main Code__ section :

	$ vim web/index.php

~~~~~~~~~~~~~{.php}
	/**
	* Your Main Code
	*/
	use \Name\Space\MyClass;
	$myClass = new MyClass();
~~~~~~~~~~~~~

Then, when executing `web/index.php`, it returns :

	$ php web/index.php
	Hello MyClass !

## Transform your classes

If you want change your classes extension to a standard format for example, you can use :

	$ php app/console.php transform class.php php
	Transforming files …
	[RENAME] "/home/gnkw/GNKW_Creator/app/../src/Name/Space/MyClass.class.php" to "/home/gnkw/GNKW_Creator/app/../src/Name/Space/MyClass.php"
	… files transformed

After a transformation, you should check if there is no link problems.

In this example, your `src/Name/Space/MyClass.test.php` can't load `MyClass.class.php` because this class is renamed.

## Adapt to use without autoloader

The creator allow you to use an autoloader, so, if there is no autoloader in the project you add your code, you should __require__ the classes when you use them with :

~~~~~~~~~~~~~{.php}
	require_once(__DIR__ . 'TheClass/IUse.class.php');
~~~~~~~~~~~~~
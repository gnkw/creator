# GNKW Creator

## Introduction

To use this Creator you need to add the good rights to create files by PHP.

## Create a class

You can create a class by using this command (replace _Namespace_ and _Class_ by your datas) :

	php console.php create class Namespace Class

## Create a test class

To create a test class for a class using phpunit, it's a similar syntax :

	php console.php create test Namespace Class

If the original class don't exist, the test class can't be created.

## Use a class

After that, you want use your classes, so go to the __index.php__ file and precise use or precise the namespace :

~~~~~~~~~~~~~{.php}
	/**
	* Your Main Code
	*/
	use \Namespace\Class;
	$myClass = new Class();
~~~~~~~~~~~~~

By default, when executing index.php, it returns :

	$ php index.php
	Hello Class !
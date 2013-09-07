# GNKW Creator

## Introduction

This creator is used to __generate__ some PHP Classes in an __organized structure__. It use an __autoloader__, so you can easily call the classes you want between them and from a php main script by calling the autoloader. It also let you create __PHPUnit__ test classes to test your php classes.

To use this Creator you need to have __read and write__ rights to create files by PHP.

## Install it with composer

To install composer :

	$ curl -sS https://getcomposer.org/installer | php

To install the latest version of the creator :

Stable :

	$ php composer.phar create-project gnkw/creator gnkw-creator

Dev :

	$ php composer.phar create-project gnkw/creator gnkw-creator master

Go to your creator

	$ cd gnkw-creator

## Update from 1.x to 2.x

This is the version 2.x of the creator, so now, you can't transform your classes and you can't use the old notation class like this : MyClass.class.php.

Please transform your classes with the standard notation : MyClass.php before updating the creator.


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

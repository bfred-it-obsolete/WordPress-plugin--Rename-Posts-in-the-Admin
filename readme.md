# BFR Rename Posts in the Admin (API)

This API lets you rename Posts or Pages to "Articles", "Homes", or whatever you please.

![Screenshot](http://i.imgur.com/zHrwtnG.png "Screenshot")

## Setup

Once installed you need to set this up anywhere in your code: `functions.php` is fine.

	$bpr = new WPPostTypeRenamer();
	$bpr->set('Accomodation','Accomodations');
	$bpr->setCategory('Location'); // optional, only for 'post'
	$bpr->setTags('Services'); // optional, only for 'post'

There's also an Italian version, just use `WPPostTypeRenamer_IT()` instead (if the name is feminine you might need to edit the plugin)

## API

For more info on how to use these, read the comments in the `.php` file itself

	function set($Singular, $Plural, $singular = null, $plural = null)
	function setCategory($category)
	function setTags($tags)

## Author

Federico Brigante: [@bfred_it](https://twitter.com/bfred_it)
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Shenanigans - Xkeeper's Link's Awakening depot</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<style type="text/css">
	body	{
		background:		#ddd url('bg.png');
		font-family:	Verdana, sans-serif;
		color:			#000;
		font-size:		90%;
		text-align:		center;
		}
	div, h1, h2	{
		text-align:		left;
		background:		#fff;
		border-bottom:	1px solid #777;
		border-right:	2px solid #aaa;
		padding:		2px 5px 2px 5px;
		max-width:		800px;
		margin-left:	auto;
		margin-right:	auto;
		margin-bottom:	2px;
		}
	h1, h2	{
		text-align:		center;
		margin-top:	.5em;
		}
	ul	{
		margin-left:	none;
		list-style-type:	none;
		padding-left:		1em;
		}
	
	a:link		{	color:	#33f;	}
	a:visited	{	color:	#93f;	}
	.fr			{	float:	right;	font-size:	.75em;	}
	</style>
</head>
<body>

	<h1><a name="top">Shenaningans</a></h1>
	<div>

		<p>This is a collection of weird crap I've found that just makes no sense and isn't already in some other page (e.g., chests). For other things, check the <a href="./">main Link's Awakening page</a>.
		</p>

		<p>Navigation:
		<ul>
			<li><a href="#enemies">Weird enemies</a></li>
		</ul>
	</div>

	
	<h2><a name="enemies">Weird enemies</a></h2>
	<div><div class="fr">[<a href="#enemies">#</a>] [<a href="#top">top</a>]</div>

		<h3>Rather fishy</h3>
		<p><img src="enemies.php?offset=0x59165&amp;room=F9&amp;m=2" alt="large trout" title="good luck slapping anybody with this fish">
		<br>It's kind of silly, but believe it or not, there's a fish under these stairs. My guess is that, since it isn't on water, it's never drawn and is therefore pretty much pointless. It was probably never removed for that reason -- it's impossible to see since it disappears immediately.
		</p>

		<h3>Out of gas</h3>
		<p><img src="enemies.php?offset=0x58b37&amp;room=B9&amp;m=1" alt="burned" title="all of this wasted space is really burning me up">
		<br><img src="enemies.php?offset=0x58be4&amp;room=D0&amp;m=1" alt="two for one" title="sure hope those statues are fireproof">
		<br>Fireball shooters require enemies to work; they stop when everything else is dead. With that, hopefully you can understand why this is silly. They're never used in-game (just sits there idle), though I'm sure if you put a hidden Gel somewhere they'd flare up again and surprise anybody who knows these rooms well.
		</p>

	</div>

	
	<p><br></p>
	<div style="text-align: center;">Last update: <?php print fdate("shenanigans.php"); ?>
	<br>Made to be <a href="http://validator.w3.org/check?uri=referer">valid HTML 4.01 strict</a>.</div>

</body>
</html><?php

	function fdate($filename) {
		return date("m/d/Y", filemtime($filename));
	}
?>
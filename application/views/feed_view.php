<?php echo '<?xml version="1.0" encoding="ISO-8859-1" ?>' ; ?>
<?php //print_r($articles); ?>
<rss version="2.0">
	<channel>
	  	<title>W3Schools Home Page</title>
	  	<link>http://www.w3schools.com</link>
	  	<description>Free web building tutorials</description>
		<?php foreach($articles as $article) { ?>
			<item>
		    	<title><?php echo $article->article_title; ?></title>
		    	<link>http://www.w3schools.com/rss/<?php echo $article->article_id; ?></link>
				<description><?php $article->article_body; ?></description>
			</item>	
	  	<?php } ?>
	</channel>
</rss>
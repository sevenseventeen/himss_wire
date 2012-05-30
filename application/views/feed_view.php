<?php echo '<?xml version="1.0" encoding="ISO-8859-1" ?>' ; ?>
<rss version="2.0">
	<channel>
	  	<title>HIMSS Wire</title>
	  	<link>http://www.himsswire.com</link>
	  	<description>HIMSS Wire</description>
		<?php foreach($articles as $article) { ?>
			<item>
		    	<title><?php echo $article->article_title; ?></title>
		    	<link>http://www.himsswire.com/article/<?php echo $article->article_id; ?></link>
				<description><?php echo $article->article_summary; ?></description>
			</item>	
	  	<?php } ?>
	</channel>
</rss>
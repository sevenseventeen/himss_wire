<?php echo '<?xml version="1.0" encoding="utf-8" ?>' ; ?>
<rss version="2.0">
	<channel>
	  	<title>HIMSSwire</title>
	  	<link>http://www.himsswire.com</link>
	  	<description>HIMSSwire</description>
		<?php foreach($articles as $article) { ?>
			<item>
		    	<title><?php echo $article->article_title; ?></title>
		    	<link>http://www.himsswire.com/development/article/<?php echo $article->article_slug; ?></link>
		    	<guid>http://www.himsswire.com/development/article/<?php echo $article->article_slug; ?></guid>
				<description><?php echo strip_tags($article->article_summary); ?></description>
			</item>	
	  	<?php } ?>
	</channel>
</rss>
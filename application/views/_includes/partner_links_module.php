<div id="partner_links" class="rounded_corners_10 module_300 inner_shadow_2">
	<h3 class="module_header_no_icon rounded_top_corners_10 header_gradient inner_shadow_2">Network Partners</h3>
	<?php 
		foreach ($footer_links as $footer_link) {
			echo "<a href='$footer_link->footer_link_url' target='_blank'>$footer_link->footer_link_text</a><br />";
		}
	?>
</div>

<!-- echo "<a href='".base_url()."article/".$related_article->article_id."'><h4>".$related_article->article_title."<span class='date'>".$date_formatted."</span></h4></a>"; -->


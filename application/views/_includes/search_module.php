<!-- Search Module -->
		
<div id="search_module" class="module_300 header_gradient rounded_corners_10 inner_shadow_2">
	<h3>Article Search</h3>
		<?php echo form_open('article_search'); ?>
			<input class="rounded_corners_10 inner_shadow_2" type="text" name="search_term" value="" />
			<input type="submit" value="Search" class="article_search_button">
		<?php echo form_close(); ?>
</div>
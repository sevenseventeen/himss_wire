<div id="partner_links" class="rounded_corners_10 module_300 inner_shadow_2">
	<h3 class="module_header_no_icon rounded_top_corners_10 header_gradient inner_shadow_2">Network Partners</h3>
	<?php 
		foreach ($partner_links as $partner_link) {
			echo "<a href='$partner_link->partner_link_url' target='_blank'>$partner_link->partner_link_text</a><br />";
		}
	?>
</div>
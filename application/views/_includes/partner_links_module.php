<div id="partner_links" class="rounded_corners_10 module_300 inner_shadow_2">
	<h3 class="module_header_no_icon rounded_top_corners_10 header_gradient inner_shadow_2">News by Topic</h3>
	<?php
		function custom_array_sort($a, $b) {
    		if ($a == $b) return 0;
    		return ($a[0]->category_name < $b[0]->category_name) ? -1 : 1;
		}
		usort($active_categories, "custom_array_sort");
		foreach ($active_categories as $category) {
			echo "<a href='".base_url().'category/'.$category[0]->category_slug."'>".$category[0]->category_name."</a><br />";
		}
	?>
</div>
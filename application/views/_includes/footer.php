			<footer>
				<div id="partner_sites" class="module_920 inner_shadow_2 rounded_corners_10">
					<?php 
						$i = 0;
						foreach ($footer_links as $footer_link) {
							$i++;
							echo "<a class='column_$i' href='$footer_link->footer_link_url' target='_blank'>$footer_link->footer_link_text</a>";
							if ($i == 3) {
								echo "<br />";
								$i = 0;
							}
						}
					?>
				</div>
				<div id="footer_navigation">
					&copy; HIMMS Media |
					<a href="<?php echo base_url(); ?>privacy_policy/5">Privacy Policy</a> |
					<a href="<?php echo base_url(); ?>">Home</a>
				</div>
			</footer>
		</div>  
	</body>
</html>
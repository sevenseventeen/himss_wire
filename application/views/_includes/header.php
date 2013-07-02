<header class="drop_shadow_14">
    <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>_images/himss_wire_logo.png" /></a>
    <div id="header_right_side">
	    <ul id="login_navigation">
	        <?php if ($this->auth->logged_in()) { ?>
	        	<?php $user_id = $this->session->userdata('user_id'); ?>
	        	<li><a href="<?php echo base_url(); ?>authentication/logout">Logout</a>
	        	<?php
	        		switch ($this->auth->user_type()) {
						case 'Administrator':
							echo "| <li><a href='".base_url()."admin'>Admin</a>";
							break;
						case 'Editor':
							echo "| </li><li><a href='".base_url()."admin'>Editor</a></li>";
							break;
						case 'Subscriber':
							echo "| </li><li><a href='".base_url()."subscriber/$user_id'>My Account</a></li>";
							break;
						case 'Network Partner':
							echo "| </li><li><a href='".base_url()."network_partner/$user_id'>My Account</a></li>";
							break;
						default:
							echo '</li>'; 
							break;
					}
	        	?>
	    	<?php } else { ?>
	            <li><a href="<?php echo base_url(); ?>authentication/login">Partner Login</a></li>    
	        <?php } ?> 
	        <li id="twitter_icon"><a href="http://www.twitter.com/HIMSSwire" target="_blank"><img src="<?php echo base_url(); ?>_images/twitter_icon.jpg" /></a></li>
	    </ul>
	    <br class="clear_float" />
	    <div id="search_archive">
			<?php echo form_open('article_search'); ?>
				<input class="rounded_corners_10 inner_shadow_2" type="text" name="search_term" value="" />
				<input type="submit" value="Search Archive" id="article_search_button">
			<?php echo form_close(); ?>
		</div>
	</div>
    <br class="clear_float" />
    <ul id="main_navigation">
    	<?php //TODO  the static navigation items can be dynamically named (in case someone edits the name of a static page) ?>
        <li <?php if ($main_navigation == "articles_home" || $main_navigation == "category" || $main_navigation == "articles") { echo "class='current'"; } ?>><a href="<?php echo base_url(); ?>news">News</a></li>
        <li <?php if ($main_navigation == "about") 			{ echo "class='current'"; } ?>><a href="<?php echo base_url(); ?>alerts/1">Alerts</a></li>
        <li <?php if ($main_navigation == "our_network") 	{ echo "class='current'"; } ?>><a href="<?php echo base_url(); ?>our_network/2">Our Network</a></li>
        <li <?php if ($main_navigation == "join") 			{ echo "class='current'"; } ?>><a href="<?php echo base_url(); ?>get_published/3">Get Published</a></li>
        <li <?php if ($main_navigation == "contact") 		{ echo "class='current'"; } ?>><a href="<?php echo base_url(); ?>about_himss_wire/4">About HIMSSWire</a></li>
    </ul>
</header>

<!-- Custom Breadcrumb -->

<?php
	//echo $main_navigation;
	if(isset($_SERVER['argv'][0]) && $main_navigation != 'admin') {
		$destination_url = $_SERVER['argv'][0];
		echo "<div id='breadcrumb'>";
		echo "<a href='".base_url()."'>Home</a>";
		if ($main_navigation == 'articles') {
			echo " > <a href='".base_url()."news'>News</a> > <a href='".base_url()."category/".$category_slug."'>".$category_name."</a> > <a href='".base_url()."article/".$category_slug."/".$article_slug."'>".$article_title."</a>";
		} elseif ($main_navigation == 'category') {
			echo " > <a href='".base_url()."category/".$category_slug."'>".$category_name."</a>";
		} else {
			$destination_url_array = explode('/', $destination_url);
			$destination_url_formatted = str_replace('_', ' ', $destination_url_array[1]);
			echo " > <a href='".base_url().substr($destination_url, 1)."'>".ucwords($destination_url_formatted)."</a>";
		}
		echo "</div>";
	}
?>

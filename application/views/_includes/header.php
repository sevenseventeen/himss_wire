            <header class="header_gradient drop_shadow_14">
                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>_images/himms_wire_logo.png" /></a>
                <ul id="login_social_navigation" class="rounded_corners_10 inner_shadow_2">
                    <li><a href="<?php echo base_url(); ?>">Home</a> | </li>
                    <li><a href="https://twitter.com/#!/HIMSSwire" target="_blank">Twitter</a> | </li>
                    <li><a href="http://www.linkedin.com/groups?gid=93115" target="_blank">LinkedIn</a> |</li>
                    <?php if ($this->auth->logged_in()) { ?>
                        <li><a href="<?php echo base_url(); ?>admin/logout">Logout</a> 
                        <?php if ($this->auth->user_type() == "Administrator") { ?>
                        	| </li><li><a href="<?php echo base_url(); ?>admin">Admin</a></li>
                       	<?php } elseif ($this->auth->user_type() == "Editor") { ?>
                       		| </li><li><a href="<?php echo base_url(); ?>admin">Editor</a></li>
                       	<?php } else { ?>
                       		</li>
                       	<?php } ?>
                    <?php } else { ?>
                        <li><a href="<?php echo base_url(); ?>admin/login">Login</a></li>    
                    <?php } ?> 
                    
                </ul>
                <br class="clear_float" />
                <ul id="main_navigation">
                	<?php //TODO  the static navigation items can be dynamically named (in case someone edits the name of a static page) ?>
                    <li <?php if ($main_navigation == "articles_home") 	{ echo "class='current'"; } ?>><a href="<?php echo base_url(); ?>articles">Articles</a></li>
                    <li <?php if ($main_navigation == "about") 			{ echo "class='current'"; } ?>><a href="<?php echo base_url(); ?>about_himss_wire/1">About HIMSS Wire</a></li>
                    <li <?php if ($main_navigation == "our_network") 	{ echo "class='current'"; } ?>><a href="<?php echo base_url(); ?>our_network/2">Our Network</a></li>
                    <li <?php if ($main_navigation == "join") 			{ echo "class='current'"; } ?>><a href="<?php echo base_url(); ?>join_himss/3">Join HIMSS</a></li>
                    <li <?php if ($main_navigation == "contact") 		{ echo "class='current'"; } ?>><a href="<?php echo base_url(); ?>contact_us/4">Contact Us</a></li>
                </ul>
            </header>
            
            <!-- Custom Breadcrumb -->
            
	            <?php
	            	
	            	if(isset($_SERVER['argv'][0])) {
	            		$destination_url = $_SERVER['argv'][0];
	            		echo "<div id='breadcrumb'>";
						echo "<a href='".base_url()."'>Home</a>";
						if ($main_navigation == 'articles') {
							echo " > <a href='".base_url()."articles'>Articles</a> > <a href='".base_url()."category/".$category_id."'>".$category_name."</a> > <a href='".base_url()."article/".$article_id."'>".$article_title."</a>";
						} elseif ($main_navigation == 'category') {
							echo " > <a href='".base_url()."category/".$category_id."'>".$category_name."</a>";
						} else {
							$destination_url_array = explode('/', $destination_url);
							$destination_url_formatted = str_replace('_', ' ', $destination_url_array[1]);
//							echo " > <a href='".base_url().$destination_url_array[1]."/".$destination_url_array[2]."'>".ucwords($destination_url_formatted)."</a>";

							echo " > <a href='".base_url().substr($destination_url, 1)."'>".ucwords($destination_url_formatted)."</a>";
						}
						echo "</div>";
	            	}

				?>

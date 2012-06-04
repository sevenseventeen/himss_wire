            <header class="header_gradient drop_shadow_14">
                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>_images/himms_wire_logo.png" /></a>
                <ul id="login_social_navigation" class="rounded_corners_10 inner_shadow_2">
                    <li><a href="<?php echo base_url(); ?>">Home</a> | </li>
                    <li><a href="#">Twitter</a> | </li>
                    <li><a href="#">LinkedIn</a> |</li>
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
                	<?php //TODO  the static navigation items can be dynamically named (in case someone edit the name of a static page) ?> 
                    <li><a href="<?php echo base_url(); ?>articles">Articles</a></li>
                    <li><a href="<?php echo base_url(); ?>about_himss_wire/1">About HIMSS Wire</a></li>
                    <li><a href="<?php echo base_url(); ?>our_network/2">Our Network</a></li>
                    <li><a href="<?php echo base_url(); ?>join_himss/3">Join HIMSS</a></li>
                    <li><a href="<?php echo base_url(); ?>contact_us/4">Contact Us</a></li>
                </ul>
            </header>
            <div id="breadcrumb"><?php echo set_breadcrumb(); ?></div>
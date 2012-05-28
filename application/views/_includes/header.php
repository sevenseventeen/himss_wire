            <header class="header_gradient drop_shadow_14">
                <img src="<?php echo base_url(); ?>_images/himms_wire_logo.png" />
                <ul id="login_social_navigation" class="rounded_corners_10 inner_shadow_2">
                    <li><a href="<?php echo base_url(); ?>">Home</a> | </li>
                    <li><a href="#">Twitter</a> | </li>
                    <li><a href="#">LinkedIn</a> |</li>
                    <?php if ($this->auth->logged_in()) { ?>
                        <li><a href="<?php echo base_url(); ?>admin/logout">Logout</a></li>    
                    <?php } else { ?>
                        <li><a href="<?php echo base_url(); ?>admin/login">Login</a></li>    
                    <?php } ?> 
                    
                </ul>
                <br class="clear_float" />
                <ul id="main_navigation">
                    <li><a href="<?php echo base_url(); ?>articles">Articles</a></li>
                    <li><a href="<?php echo base_url(); ?>about_himss_wire">About HIMSS Wire</a></li>
                    <li><a href="<?php echo base_url(); ?>our_network">Our Network</a></li>
                    <li><a href="<?php echo base_url(); ?>join_himss">Join HIMSS</a></li>
                    <li><a href="<?php echo base_url(); ?>contact_us">Contact Us</a></li>
                </ul>
            </header>
            <div id="breadcrumb"><?php echo set_breadcrumb(); ?></div>
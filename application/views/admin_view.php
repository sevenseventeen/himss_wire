<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<div id="accordion">
		<h3><a href="#">Articles</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Edit</a></li>
					<li><a href="#tabs-2">Add</a></li>
				</ul>
				<div id="tabs-1">
					<?php
						foreach ($articles as $article) { 
							echo "<a href='".base_url()."admin/edit_article/$article->article_id'>".$article->article_title."</a><br />";
						}
					?>
				</div>
				<div id="tabs-2">
					<?php echo form_open('admin/add_article'); ?>
						<fieldset>
						<legend>Add Article</legend>
						<select name="subscriber_id">
							<option value=''>Select a Subscriber</option>
							<?php 
								foreach ($subscribers_with_remaining_articles as $subscriber) { 
									echo "<option value='".$subscriber->subscriber_account_id."'>".$subscriber->company_name."</option>";
								}
							?>
						</select>
						<?php echo form_error('subscriber_id'); ?>
						<br />
						<select name="article_category_id">
							<option value=''>Select a Category</option>
							<?php 
								foreach ($categories as $category) { 
									echo "<option value='".$category->article_category_id."'>".$category->category_name."</option>";
								}
							?>
						</select>
						<?php echo form_error('article_category_id'); ?>
						<br class="clear_float" />
						<label>Article Title</label> 
							<?php echo form_input('article_title', set_value('article_title', '')); ?>
							<?php echo form_error('article_title'); ?>
							<br class="clear_float" />
						<label>Article Summary</label>
							<?php echo form_textarea('article_summary', set_value('article_summary', ''), 'class="ckeditor"'); ?>
							<?php echo form_error('article_summary'); ?>
							<br class="clear_float" />
						<label>Article Body</label>
							<?php echo form_textarea('article_body', set_value('article_body', ''), 'class="ckeditor"'); ?>
							<?php echo form_error('article_body'); ?>
							<br class="clear_float" />
						<script>
							$(function() {
								$('#publish_date').datepicker({
									onSelect: function(dateText, inst) {
										$('#publish_date').val(dateText);
									}
								});
							});
						</script>
						<label>Publish Date</label>
							<input type="text" name="publish_date" id="publish_date" />
							<?php echo form_error('publish_date'); ?>
							<br class="clear_float" />
						<label>Article Tags</label>
							<?php echo form_input('article_tags', set_value('article_tags', '')); ?>
							<?php echo form_error('article_tags'); ?>
							<br class="clear_float" />
						</fieldset>
						<input type="submit" />		
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordion Item -->
		
	<?php if ($user_type == 'Administrator') { ?>
		
		<!-- ••••••••••• Internal Accounts ••••••••••••••• -->
		
		<h3><a href="#">Internal Accounts</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Tab1</a></li>
					<li><a href="#tabs-2">Tab2</a></li>
				</ul>
				<div id="tabs-1">
					Administrators
					<?php
						foreach ($administrators as $administrator) {
							echo "<a href='".base_url()."admin/edit_admin_account/$administrator->user_id/$administrator->administrator_account_id'>".$administrator->first_name." ".$administrator->last_name."</a><br />";
						}
					?>
					Editors
					<?php
						foreach ($editors as $editor) { 
							echo "<a href='".base_url()."admin/edit_editor_account/$editor->user_id/$editor->editor_account_id'>".$editor->first_name." ".$editor->last_name."</a><br />";
						}
					?>
				</div>
				<div id="tabs-2">
					<?php echo form_open('admin/add_internal_account'); ?>
						<fieldset>
							<legend>Add User Account</legend>
							<select name="account_type_id">
								<option value=''>Select an Account Type</option>
								<?php 
									foreach ($internal_account_types as $account_type) { 
										echo "<option value='".$account_type->account_type_id."'>".$account_type->account_type_name."</option>";
									}
								?>
							</select>
							<br class="clear_float" />
							<label>First Name</label>
								<?php echo form_input('first_name', set_value('first_name', 'Josh')); ?>
								<?php echo form_error('first_name'); ?>
								<br class="clear_float" />
							<label>Last Name</label>
								<?php echo form_input('last_name', set_value('last_name', 'Knight')); ?>
								<?php echo form_error('last_name'); ?>
								<br class="clear_float" />
							<label>Email</label>
								<?php echo form_input('email', set_value('email', 'subscriber@himms.com')); ?>
								<?php echo form_error('email'); ?>
								<br class="clear_float" />
							<label>Password</label>
								<?php echo form_input('password', set_value('password', 'password123')); ?>
								<?php echo form_error('password'); ?>
								<br class="clear_float" />
						</fieldset>
						<input type="submit" />		
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordian Item -->
		
		<!-- ••••••••••• External Accounts ••••••••••••••• -->
		
		<h3><a href="#">External Accounts</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Tab1</a></li>
					<li><a href="#tabs-2">Tab2</a></li>
				</ul>
				<div id="tabs-1">
					Subscribers<br />
					<?php
						foreach ($subscribers as $subscriber) { 
							echo "<a href='".base_url()."admin/subscriber_account/$subscriber->user_id/$subscriber->subscriber_account_id'>".$subscriber->company_name."</a><br />";
						}
					?>
					Network Partners<br />
					<?php
						foreach ($network_partners as $network_partner) { 
							echo "<a href='".base_url()."admin/edit_network_partner_account/$network_partner->user_id/$network_partner->network_partner_account_id'>".$network_partner->company_name."</a><br />";
						}
					?>
				</div>
				<!-- TODO Send email on account creation <br /> -->
				<div id="tabs-2">
					<?php echo form_open('admin/add_external_account'); ?>
						<fieldset>
							<legend>Add External Account</legend>
							<select name="account_type_id">
								<option value=''>Select an Account Type</option>
								<?php 
									foreach ($external_account_types as $account_type) { 
										echo "<option value='".$account_type->account_type_id."'>".ucfirst($account_type->account_type_name)."</option>";
									}
								?>
							</select>
							<br class="clear_float" />
							<label>Company Name</label> 
								<?php echo form_input('company_name', set_value('company_name', '')); ?>
								<?php echo form_error('company_name'); ?>
								<br class="clear_float" />
							<label>Website</label>
								<?php echo form_input('website', set_value('website', '')); ?>
								<?php echo form_error('website'); ?>
								<br class="clear_float" />
							<label>First Name</label>
								<?php echo form_input('first_name', set_value('first_name', '')); ?>
								<?php echo form_error('first_name'); ?>
								<br class="clear_float" />
							<label>Last Name</label>
								<?php echo form_input('last_name', set_value('last_name', '')); ?>
								<?php echo form_error('last_name'); ?>
								<br class="clear_float" />
							<label>Phone Number</label>
								<?php echo form_input('phone_number', set_value('phone_number', '')); ?>
								<?php echo form_error('phone_number'); ?>
								<br class="clear_float" />
							<label>Street Address</label>
								<?php echo form_input('street_address', set_value('street_address', '')); ?>
								<?php echo form_error('street_address'); ?>
								<br class="clear_float" />
							<label>City</label>
								<?php echo form_input('city', set_value('city', '')); ?>
								<?php echo form_error('city'); ?>
								<br class="clear_float" />
							<label>State</label>
								<?php echo form_input('state', set_value('state', '')); ?>
								<?php echo form_error('state'); ?>
								<br class="clear_float" />
							<label>Zip Code</label>
								<?php echo form_input('zip_code', set_value('zip_code', '')); ?>
								<?php echo form_error('zip_code'); ?>
								<br class="clear_float" />
							<label>Email</label>
								<?php echo form_input('email', set_value('email', '')); ?>
								<?php echo form_error('email'); ?>
								<br class="clear_float" />
							<label>Password</label>
								<?php echo form_input('password', set_value('password', '')); ?>
								<?php echo form_error('password'); ?>
								<br class="clear_float" />
						</fieldset>
						<input type="submit" />		
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordian Item -->
		
		<!-- ••••••••••• Categories ••••••••••••••• -->
		
		<h3><a href="#">Categories</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Tab1</a></li>
					<li><a href="#tabs-2">Tab2</a></li>
				</ul>
				<div id="tabs-1">
					<?php
						foreach ($categories as $category) { 
							echo "<a href='".base_url()."admin/edit_category/$category->article_category_id'>".$category->category_name."</a><br />";
						}
					?>
				</div>
				<div id="tabs-2">
					<?php echo form_open('admin/add_category'); ?>
						<fieldset>
							<legend>Add Category</legend>
							<label>Category Name</label> 
								<?php echo form_input('category_name', set_value('category_name')); ?>
								<?php echo form_error('company_name'); ?>
								<br class="clear_float" />
						</fieldset>
						<input type="submit" />		
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordian Item -->
		
		<!-- ••••••••••• Static Pages ••••••••••••••• -->
		
		<h3><a href="#">Static Pages</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Tab1</a></li>
				</ul>
				<div id="tabs-1">
					Edit Static Pages<br />
					<?php 
						foreach ($static_pages as $static_page) { 
							echo "<a href='admin/edit_static_page/".$static_page->page_id."'>".$static_page->page_name."</a><br />";
						}
					?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordian Item -->
		
		<!-- ••••••••••• Feature Module ••••••••••••••• -->
		
		<h3><a href="#">Feature Module</a></h3>
		
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Tab1</a></li>
				</ul>
				<div id="tabs-1">
					<?php echo form_open_multipart('admin/update_feature_module');?>
						<fieldset>
							<legend>Edit Feature Module</legend>
							<label>Feature Module Text</label>
								<?php echo form_textarea('module_text', set_value('module_text', $feature_module[0]->module_text), 'class="ckeditor"'); ?>
								<?php echo form_error('module_text'); ?>
								<br class="clear_float" />
							<label>Feature Module Image</label>
									<?php echo form_upload('userfile', set_value('userfile')); ?>
									<?php echo form_error('userfile'); ?>
									<br class="clear_float" />
							<?php echo form_hidden('module_entry_id', $feature_module[0]->module_entry_id); ?>
						</fieldset>
						<input type="submit" />
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordian Item -->
		
		<!-- ••••••••••• Banner Ad ••••••••••••••• -->
		
		<h3><a href="#">Banner Ad</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Tab1</a></li>
				</ul>
				<div id="tabs-1">
					<?php echo form_open_multipart('admin/update_banner_ad');?>
						<fieldset>
							<legend>Edit Banner Ad</legend>
							<label>Banner Ad Image (270 Pixels Wide)</label>
									<?php echo form_upload('banner_image', set_value('banner_image')); ?>
									<?php echo form_error('banner_image'); ?>
									<br class="clear_float" />
							<?php echo form_hidden('banner_ad_id', $banner_ads[0]->banner_ad_id); ?>
						</fieldset>
						<input type="submit" />
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordian Item -->
		
		<!-- ••••••••••• Footer Links ••••••••••••••• -->
		
		<h3><a href="#">Footer Links</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Tab1</a></li>
				</ul>
				<div id="tabs-1">
					<?php echo form_open('admin/add_footer_link');?>
						<fieldset>
							<legend>Add Footer Links</legend>
								<label>Footer Link Text</label>
									<?php echo form_input('footer_link_text', set_value('footer_link_text')); ?>
									<?php echo form_error('footer_link_text'); ?>
									<br class="clear_float" />
								<label>Footer Link Text</label>
									<?php echo form_input('footer_link_url', set_value('footer_link_url')); ?>
									<?php echo form_error('footer_link_url'); ?>
									<br class="clear_float" />
						</fieldset>
						<input type="submit" />
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordion Item -->
		
		<!-- ••••••••••• FAQ's ••••••••••••••• -->
		
		<h3><a href="#">FAQ's</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Tab1</a></li>
				</ul>
				<?php echo form_open('admin/add_faq');?>
					<fieldset>
						<legend>Add FAQ</legend>
							<label>FAQ Question</label>
								<?php echo form_textarea('faq_question', set_value('faq_question'), 'class="ckeditor"'); ?>
								<?php echo form_error('faq_question'); ?>
								<br class="clear_float" />
							<label>FAQ Answer</label>
								<?php echo form_textarea('faq_answer', set_value('faq_answer'), 'class="ckeditor"'); ?>
								<?php echo form_error('faq_answer'); ?>
								<br class="clear_float" />
					</fieldset>
					<input type="submit" />
				<?php echo form_close(); ?>
			</div> 	<!-- End Tabs -->
		</div> 		<!-- End  Accordion Item -->
		<?php } ?> 	<!-- End if_admin -->
	</div>			<!-- End  Accordion Container -->
</div> 				<!-- End Main Content -->
<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
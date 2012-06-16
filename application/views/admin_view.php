<?php 
	$data['main_navigation'] = 'admin';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
	<h1><?php echo $this->session->flashdata('message'); ?></h1>
	<div id="accordion">
		<h3><a href="#">Articles</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#articles_edit">Edit</a></li>
					<li><a href="#articles_add">Add</a></li>
				</ul>
				<div id="articles_edit">
					<h2>Edit Article</h2>
					<?php
						foreach ($articles as $article) { 
							echo "<a href='".base_url()."admin/edit_article/$article->article_id'>".$article->article_title."</a><br />";
						}
					?>
				</div>
				<div id="articles_add">
					<?php echo form_open('admin/add_article'); ?>
						<fieldset>
							<h2>Add Article</h2>
							<label>Subscriber</label>
							<select name="subscriber_id">
								<option value=''>Select a Subscriber</option>
								<?php 
									foreach ($subscribers_with_remaining_articles as $subscriber) { 
										echo "<option value='".$subscriber->subscriber_account_id."' ".set_select('subscriber_id', $subscriber->subscriber_account_id).">".$subscriber->company_name."</option>";
									}
								?>
							</select>
							<?php echo form_error('subscriber_id'); ?>
							<br />
							<label>Article Category</label>
							<select name="article_category_id">
								<option value=''>Select a Category</option>
								<?php 
									foreach ($categories as $category) { 
										echo "<option value='".$category->article_category_id."' ".set_select('article_category_id', $category->article_category_id).">".$category->category_name."</option>";
									}
								?>
							</select>
							<?php echo form_error('article_category_id'); ?>
							<br class="clear_float" />
							<label>Article Title</label> 
								<?php echo form_input('article_title', set_value('article_title', '')); ?>
								<?php echo form_error('article_title'); ?>
								<br class="clear_float" />
							<label>Article Summary (120 Characters)</label>
								<?php echo form_textarea('article_summary', set_value('article_summary', ''), 'maxlength="160"'); ?>
								<?php echo form_error('article_summary'); ?>
								<br class="clear_float" />
							<label>Article Body</label>
								<?php echo form_textarea('article_body', set_value('article_body', ''), 'class="ckeditor" maxlength="10"'); ?>
								<?php echo form_error('article_body'); ?>
								<br class="clear_float" />
							<label>Draft</label>
								<input type="checkbox" id="draft_status" name="draft_status" value="true" checked="checked" <?php echo set_checkbox('draft_status', 'true'); ?> />
								<br class="clear_float" />
							<div id="publish_date_container">
								<label>Publish Date</label>
									<input type="text" name="publish_date" id="publish_date" class="datepicker"/>
									<?php echo form_error('publish_date'); ?>
									<br class="clear_float" />
							</div>
							<label>Article Tags (separate tags with comma)</label>
								<?php echo form_input('article_tags', set_value('article_tags', '')); ?>
								<?php echo form_error('article_tags'); ?>
								<br class="clear_float" />
						</fieldset>
						<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />	
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
					<li><a href="#internal_accounts_edit">Edit</a></li>
					<li><a href="#internal_accounts_add">Add</a></li>
				</ul>
				<div id="internal_accounts_edit">
					<h2>Administrators</h2>
					<?php
						foreach ($administrators as $administrator) {
							echo "<a href='".base_url()."admin/edit_admin_account/$administrator->user_id/$administrator->administrator_account_id'>".$administrator->first_name." ".$administrator->last_name."</a><br />";
						}
					?>
					<h2>Editors</h2>
					<?php
						foreach ($editors as $editor) { 
							echo "<a href='".base_url()."admin/edit_editor_account/$editor->user_id/$editor->editor_account_id'>".$editor->first_name." ".$editor->last_name."</a><br />";
						}
					?>
				</div>
				<div id="internal_accounts_add">
					<?php echo form_open('admin/add_internal_account'); ?>
						<fieldset>
							<h2>Add User Account</h2>
							<select name="account_type_id">
								<option value=''>Select an Account Type</option>
								<?php 
									foreach ($internal_account_types as $account_type) { 
										echo "<option value='".$account_type->account_type_id."' ".set_select('account_type_id', $account_type->account_type_id).">".$account_type->account_type_name."</option>";
									}
								?>
							</select>
							<?php echo form_error('account_type_id'); ?>
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
								<?php echo form_password('password', set_value('password', 'password123')); ?>
								<?php echo form_error('password'); ?>
								<br class="clear_float" />
						</fieldset>
						<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />	
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordian Item -->
		
		<!-- ••••••••••• External Accounts ••••••••••••••• -->
		
		<h3><a href="#">External Accounts</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Edit</a></li>
					<li><a href="#tabs-2">Add</a></li>
				</ul>
				<div id="tabs-1">
					<h2>Subscribers</h2>
					<?php
						foreach ($subscribers as $subscriber) { 
							echo "<a href='".base_url()."admin/subscriber_account/$subscriber->user_id/$subscriber->subscriber_account_id'>".$subscriber->company_name."</a><br />";
						}
					?>
					<h2>Network Partners</h2>
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
							<h2>Add External Account</h2>
							<select name="account_type_id">
								<option value=''>Select an Account Type</option>
								<?php 
									foreach ($external_account_types as $account_type) { 
										echo "<option value='".$account_type->account_type_id."' ".set_select('account_type_id', $account_type->account_type_id).">".$account_type->account_type_name."</option>";
									}
								?>
							</select>
							<?php echo form_error('account_type_id'); ?>
							<br class="clear_float" />
							<label>Company Name</label> 
								<?php echo form_input('company_name', set_value('company_name', '')); ?>
								<?php echo form_error('company_name'); ?>
								<br class="clear_float" />
							<label>Website(s) <a href="#" id="add_website">[+] Add Website</a></label>
							<div id="website_container">
								<?php 
									if(!empty($websites)) {
										
								 		foreach ($websites as $website) { ?>
											<input type="text" name="websites[]" id="websites" value="<?php echo $website; ?>"/>
								 <?php 	} ?>
								<?php } else { ?>
									<input type="text" name="websites[]" id="websites" value=""/>
								<?php  } ?>
							</div> 	
								<?php echo form_error('websites[]'); ?>
								<!-- <br class="clear_float" /> -->
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
								<?php $state_options = array('' => '', 'Alabama' => 'Alabama',	'Alaska' => 'Alaska',	'Arizona' => 'Arizona',	'Arkansas' => 'Arkansas',	'California' => 'California',	'Colorado' => 'Colorado',	'Connecticut' => 'Connecticut',	'Delaware' => 'Delaware',	'District of Columbia' => 'District of Columbia',	'Florida' => 'Florida',	'Georgia' => 'Georgia',	'Guam' => 'Guam',	'Hawaii' => 'Hawaii',	'Idaho' => 'Idaho',	'Illinois' => 'Illinois',	'Indiana' => 'Indiana',	'Iowa' => 'Iowa',	'Kansas' => 'Kansas',	'Kentucky' => 'Kentucky',	'Louisiana' => 'Louisiana',	'Maine' => 'Maine',	'Maryland' => 'Maryland',	'Massachusetts' => 'Massachusetts',	'Michigan' => 'Michigan',	'Minnesota' => 'Minnesota',	'Mississippi' => 'Mississippi',	'Missouri' => 'Missouri',	'Montana' => 'Montana',	'Nebraska' => 'Nebraska',	'Nevada' => 'Nevada',	'New Hampshire' => 'New Hampshire',	'New Mexico' => 'New Mexico',	'New York' => 'New York',	'North Carolina' => 'North Carolina',	'North Dakota' => 'North Dakota',	'Ohio' => 'Ohio',	'Oklahoma' => 'Oklahoma',	'Oregon' => 'Oregon',	'Pennsylvania' => 'Pennsylvania',	'Puerto Rico' => 'Puerto Rico',	'Rhode Island' => 'Rhode Island',	'South Carolina' => 'South Carolina',	'South Dakota' => 'South Dakota',	'Tennessee' => 'Tennessee',	'Texas' => 'Texas',	'Utah' => 'Utah',	'Vermont' => 'Vermont',	'Virginia' => 'Virginia',	'Virgin Islands' => 'Virgin Islands',	'Washington' => 'Washington',	'West Virginia' => 'West Virginia',	'Wisconsin' => 'Wisconsin',	'Wyoming' => 'Wyoming'); ?>
								<?php echo form_dropdown('state', $state_options, set_value('state', '')); ?>																					
								<?php echo form_error('state'); ?>
								<br class="clear_float" />
							<label>Zip Code</label>
								<?php echo form_input('zip_code', set_value('zip_code', '')); ?>
								<?php echo form_error('zip_code'); ?>
								<br class="clear_float" />
							<label>Send Welcome Email</label>
								<input type="checkbox" id="welcome_email" name="welcome_email" value="true" checked="checked" <?php echo set_checkbox('welcome_email', 'true'); ?> />
								<br class="clear_float" />
							<label>Email</label>
								<?php echo form_input('email', set_value('email', '')); ?>
								<?php echo form_error('email'); ?>
								<br class="clear_float" />
							<label>Password</label>
								<?php echo form_password('password', set_value('password', '')); ?>
								<?php echo form_error('password'); ?>
								<br class="clear_float" />
						</fieldset>
						<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />		
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordian Item -->
		
		<!-- ••••••••••• Categories ••••••••••••••• -->
		
		<h3><a href="#">Categories</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Edit</a></li>
					<li><a href="#tabs-2">Add</a></li>
				</ul>
				<div id="tabs-1">
					<h2>Edit Categories</h2>
					<?php
						foreach ($categories as $category) { 
							echo "<a href='".base_url()."admin/edit_category/$category->article_category_id'>".$category->category_name."</a><br />";
						}
					?>
				</div>
				<div id="tabs-2">
					
					<?php echo form_open('admin/add_category'); ?>
						<fieldset>
							<h2>Add Category</h2>
							<label>Category Name</label> 
								<?php echo form_input('category_name', set_value('category_name')); ?>
								<?php echo form_error('company_name'); ?>
								<br class="clear_float" />
						</fieldset>
						<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />		
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordian Item -->
		
		<!-- ••••••••••• Static Pages ••••••••••••••• -->
		
		<h3><a href="#">Static Pages</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Edit</a></li>
				</ul>
				<div id="tabs-1">
					<h2>Edit Static Pages</h2>
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
					<li><a href="#tabs-1">Edit</a></li>
				</ul>
				<div id="tabs-1">
					<?php echo form_open_multipart('admin/update_feature_module');?>
						<fieldset>
							<h2>Edit Feature Module</h2>
							<label>Feature Module Content</label>
								<?php echo form_textarea('module_text', set_value('module_text', $feature_module[0]->module_text), 'class="ckeditor"'); ?>
								<?php echo form_error('module_text'); ?>
								<br class="clear_float" />
							<?php echo form_hidden('feature_module_id', $feature_module[0]->feature_module_id); ?>
						</fieldset>
						<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordion Item -->
		
		<!-- ••••••••••• Feature Module Optional ••••••••••••••• -->
		
		<h3><a href="#">Optional Feature Module</a></h3>
		
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Edit</a></li>
				</ul>
				<div id="tabs-1">
					<?php echo form_open_multipart('admin/update_feature_module_optional');?>
						<fieldset>
							<h2>Edit Optional Feature Module</h2>
							<label>Feature Module Content</label>
								<?php echo "ENABLED: ".$feature_module_optional[0]->enabled; ?>
								<?php echo form_textarea('module_text_optional', set_value('module_text_optional', $feature_module_optional[0]->module_text), 'class="ckeditor"'); ?>
								<?php echo form_error('module_text_optional'); ?>
								<br class="clear_float" />
							<label>Enabled</label>
								<!-- I'm not sure why this checked business is needed -->
								<?php 
									if ($feature_module_optional[0]->enabled == "1") {
										$checked = "checked='checked'"; 
									} else {
										$checked = "";
									}
								?>
								<input type="checkbox" name="enabled" value="1" <?php echo $checked; ?> <?php echo set_checkbox('enabled', '1'); ?> />
							<?php echo form_hidden('feature_module_optional_id', $feature_module_optional[0]->feature_module_optional_id); ?>
						</fieldset>
						<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordion Item -->
		
		<!-- ••••••••••• Banner Ad ••••••••••••••• -->
		
		<h3><a href="#">Banner Ad</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Edit</a></li>
				</ul>
				<div id="tabs-1">
					<?php echo form_open_multipart('admin/update_banner_ad');?>
						<fieldset>
							<h2>Edit Banner Ad</h2>
							<label>Banner Ad Image (270 Pixels Wide)</label>
									<?php echo form_upload('banner_image', set_value('banner_image')); ?>
									<?php echo form_error('banner_image'); ?>
									<br class="clear_float" />
							<label>Banner URL</label>
									<?php echo form_input('banner_url', set_value('banner_url')); ?>
									<?php echo form_error('banner_url'); ?>
									<br class="clear_float" />
							<?php echo form_hidden('banner_ad_id', $banner_ads[0]->banner_ad_id); ?>
						</fieldset>
						<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordian Item -->
		
		<!-- ••••••••••• Footer Links ••••••••••••••• -->
		
		<h3><a href="#">Footer Links</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Edit</a></li>
					<li><a href="#tabs-2">Add</a></li>
				</ul>
				<div id="tabs-1">
					<h2>Edit Footer Links</h2>
					<?php
						foreach ($footer_links as $footer_link) { 
							echo "<a href='".base_url()."admin/edit_footer_link/$footer_link->footer_link_id'>".$footer_link->footer_link_text."</a><br />";
						}
					?>
				</div>
				<div id="tabs-2">
					<?php echo form_open('admin/add_footer_link');?>
						<fieldset>
							<h2>Add Footer Links</h2>
								<label>Footer Link Text</label>
									<?php echo form_input('footer_link_text', set_value('footer_link_text')); ?>
									<?php echo form_error('footer_link_text'); ?>
									<br class="clear_float" />
								<label>Footer Link Text</label>
									<?php echo form_input('footer_link_url', set_value('footer_link_url')); ?>
									<?php echo form_error('footer_link_url'); ?>
									<br class="clear_float" />
						</fieldset>
						<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
					<?php echo form_close(); ?>
				</div>
			</div> <!-- End Tabs -->
		</div> <!-- End  Accordion Item -->
		
		<!-- ••••••••••• FAQ's ••••••••••••••• -->
		
		<h3><a href="#">FAQ's</a></h3>
		<div>
			<div class="tabs">
				<ul>
					<li><a href="#tabs-1">Edit</a></li>
					<li><a href="#tabs-2">Add</a></li>
				</ul>
				<div id="tabs-1">
					<h2>Edit FAQ's</h2>
					<?php
						foreach ($faqs as $faq) { 
							echo "<a href='".base_url()."admin/edit_faq/$faq->faq_id'>".$faq->faq_question."</a><br />";
						}
					?>
				</div>
				<div id="tabs-2">
					<?php echo form_open('admin/add_faq');?>
					<fieldset>
						<h2>Add FAQ</h2>
							<label>FAQ Question</label>
								<?php echo form_textarea('faq_question', set_value('faq_question'), ''); ?>
								<?php echo form_error('faq_question'); ?>
								<br class="clear_float" />
							<label>FAQ Answer</label>
								<?php echo form_textarea('faq_answer', set_value('faq_answer'), ''); ?>
								<?php echo form_error('faq_answer'); ?>
								<br class="clear_float" />
					</fieldset>
					<input type="image" src="<?php echo base_url().'_images/submit.png'; ?>" />
				<?php echo form_close(); ?>
				</div>
			</div> 	<!-- End Tabs -->
		</div> 		<!-- End  Accordion Item -->
		<?php } ?> 	<!-- End if_admin -->
	</div>			<!-- End  Accordion Container -->
</div> 				<!-- End Main Content -->
<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
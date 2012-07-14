<?php 
	$data['main_navigation'] = 'our_network';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>

<div id="main_content" class="rounded_corners_10 module_600 inner_shadow_2 static_page">
	<?php echo $static_page_content[0]->content; ?>
</div>
<aside>
	<?php $this->load->view('_includes/feature_module'); ?>
	<?php $this->load->view('_includes/linked_in_module'); ?>
	<?php $this->load->view('_includes/banner_ad_module'); ?>
	<?php $this->load->view('_includes/partner_links_module'); ?>
</aside>
<br class="clear_float" />			

<?php 
	$this->content_library->load_footer();
?>
<!DOCTYPE html>
<html>

    <head>
		<?php 
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache");
		?> 

    	<?php 
    		if ($this->session->userdata('admin_accordion_state')) {
    			$admin_accordion_state = $this->session->userdata('admin_accordion_state');
			} else {
				$admin_accordion_state = '0';
			} 
			if ($this->session->userdata('admin_tab_state')) {
    			$admin_tab_state = $this->session->userdata('admin_tab_state');
			} else {
				$admin_tab_state = '0';
			}
		?>
		
		<meta name="robots" content="noindex, nofollow">
		
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/reset.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/main.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="http://cdn-images.mailchimp.com/embedcode/classic-081711.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/mailchimp_override.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/debugging.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/print.css'; ?>" media="print" />
        
        <!-- JQuery and JQuery UI -->

        <link type="text/css" href="<?php echo base_url().'_css/jquery_ui_theme/jquery-ui-1.8.20.custom.css'; ?>" rel="stylesheet" />
        
        
		<script type="text/javascript" src="<?php echo base_url().'_javascript/jquery-1.7.2.min.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'_javascript/jquery-ui-1.8.20.custom.min.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'_javascript/toggleField.jquery.js'; ?>"></script>
		
		<!-- CK Editor -->
		
		<script type="text/javascript" src="<?php echo base_url().'/ckeditor/ckeditor.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'/ckeditor/adapters/jquery.js'; ?>"></script>
		
		
		<script>
			// The configuration options for the text editors
			var config = {
				toolbar:[
					['Bold', 'Italic', 'Underline', 'BulletedList', 'Link', 'Image', 'Format', 'Source'],
				]
			};
			config.format_tags = 'h1;h2;h3;h4;p';
			config.width = 592;
			config.filebrowserImageBrowseUrl = '<?php echo base_url(); ?>ckfinder/ckfinder.html';
			config.filebrowserImageUploadUrl = '<?php echo base_url(); ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
			$(function() {
				$(".tabs").tabs({
					selected: <?php echo $admin_tab_state; ?>,
					select: function(event, ui) { 
						var tab_level = ui.index;
						$.ajax({
							url: "<?php echo base_url(); ?>ajax_controller/set_tab/"+tab_level,
							cache: false
						});
					}
				});
				$("textarea.ckeditor").ckeditor(config);
				//$("textarea.ckeditor").ckeditor();
				$("#accordion").accordion({ 
					collapsible:true, 
					autoHeight: false, 
					active: <?php echo $admin_accordion_state; ?>,
					change: function(event, ui) { 
						var accordion_level = ui.options.active.toString();
						$.ajax({
							url: "<?php echo base_url(); ?>ajax_controller/set_accordion/"+accordion_level,
							cache: false
						});
					} 
				});
			});
			
		</script>
		
		<!-- Textarea maxlength unsupported browsers -->
		
		<script type="text/javascript">
			$(function($) {
				var ignore = [8,9,13,33,34,35,36,37,38,39,40,46];
				var eventName = 'keypress';
				$('textarea[maxlength]')
					.live(eventName, function(event) {
						var self = $(this),
							maxlength = self.attr('maxlength'),
							code = $.data(this, 'keycode');
						if (maxlength && maxlength > 0) {
							return ( self.val().length < maxlength
								|| $.inArray(code, ignore) !== -1 );
						}
					})
					.live('keydown', function(event) {
						$.data(this, 'keycode', event.keyCode || event.which);
					});
			});
		</script>
		
		<!-- DatePicker -->
		<script type="text/javascript">
			$(function() {
				$( ".datepicker" ).datepicker({ 
					dateFormat: 'yy-mm-dd'
				});
			});
		</script>
		
		<!-- Add This -->
		
		<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fd2ae7257ffdec9"></script>
		
		<!-- Miscellaneous JQuery Functionality -->
		
		<script type="text/javascript">
		
			// Warning on all delete links of the delete class
		
			$(function($) {
				$(".delete").click(function() {
  					if(!confirm('You are about to permanenty delete this file. Please click "OK" to proceed.')) {
						return false;
					}
				});
			});
			
			// Show publish date when "draft" is unchecked. 
			
			$(document).ready(function() {
				if ( $("#draft_status").attr("checked") == "checked") {
					$("#publish_date_container").hide();
				} else {
					$("#publish_date_container").show();
				}
			});
			
			$(function($) {
				$("#draft_status").click(function() {
  					if (this.checked == true) {
  						$("#publish_date_container").hide();
  					} else {
  						$("#publish_date_container").show();
  					}
				});
			});
			
			// Duplicate file upload fields. 
			
        	$(function() {
        		var name_increment = 0;
            	$('#add_file').click(function() {
            		name_increment++
            		current_name = $('#supporting_files').attr("name");
            		current_name_without_increment = current_name.substring(0, current_name.length - 1);
            		//alert(current_name);
                	$('#supporting_files').clone().val('').attr("name", current_name_without_increment+name_increment).appendTo('#supporting_files_container');
                	$("<br />").appendTo('#supporting_files_container');
                	return false;
            	});
        	});
        	
        	$("input:radio:checked").attr("name","new_name");
        	
			// Duplicate web site fields. 
			
        	$(function() {
            	$('#add_website').click(function() {
                	$('#websites').clone().val('').appendTo('#website_container');
                	$("<br />").appendTo('#website_container');
                	return false;
            	});
        	});
        	
        	// Hide "add web site" link for Subscriber accounts
        	
        	$(function($) {
        		//$('#add_website').hide();
        		$('#account_type').change(function () { 
        			if ($(this).val() == 4) {
        				$('#add_website').show();
        			} else {
        				$('#add_website').hide();
        			}
    			});
			});
			
			// Draggable and Sortable for Partner Links and FAQ Lists
			
			$(function() {
				$("#sortable_partner_links").sortable({
					stop:function(i) {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url().'ajax_controller/order_partner_links/'; ?>",
							data: $("#sortable_partner_links").sortable("serialize")	
						});
					}
				});
				
				$("#sortable_faqs").sortable({
					stop:function(i) {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url().'ajax_controller/order_faqs/'; ?>",
							data: $("#sortable_faqs").sortable("serialize")	
						});
					}
				});
			});
			
		</script>
		
<!-- 					//data: $("#sortable_partner_links").sortable("serialize")
			//url: "<?php echo base_url().'_php/partner_links_reorder.php'; ?>",
			//data: $("#sortable_partner_links").sortable("serialize") -->
		
		<!-- HTML5 Shiv for IE <= 8 -->
		
		<!--[if lt IE 9]>
			<script src="<?php echo base_url().'_javascript/html5shiv.js'; ?>"></script>
		<![endif]-->
		
		<link type="text/css" href="<?php echo base_url().'_css/jquery_ui_override.css'; ?>" rel="stylesheet" />
		
		<!--[if lte IE 8]>
			<link type="text/css" href="<?php echo base_url().'_css/ie_8.css'; ?>" rel="stylesheet" />
		<![endif]-->
		
		<!--[if IE 9]>
			<link type="text/css" href="<?php echo base_url().'_css/ie_9.css'; ?>" rel="stylesheet" />
		<![endif]-->
		
        <title>
        	<?php 
        		if (isset ($page_title)) {
        			echo $page_title; 
				} else {
					echo "HIMSSwire";
				}
			?>
		</title>
    
    </head>
    <body id="home">
        <div id="main_container">
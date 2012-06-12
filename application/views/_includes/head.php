<!DOCTYPE html>
<html>

    <head>
    	
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
		
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/reset.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/main.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/debugging.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/print.css'; ?>" media="print" />

        <!-- JQuery and JQuery UI -->

        <link type="text/css" href="<?php echo base_url().'_css/jquery_ui_theme/jquery-ui-1.8.20.custom.css'; ?>" rel="stylesheet" />
        <link type="text/css" href="<?php echo base_url().'_css/jquery_ui_override.css'; ?>" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url().'_javascript/jquery-1.7.2.min.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'_javascript/jquery-ui-1.8.20.custom.min.js'; ?>"></script>

		<!-- CK Editor -->
		
		<script type="text/javascript" src="<?php echo base_url().'/ckeditor/ckeditor.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'/ckeditor/adapters/jquery.js'; ?>"></script>
		<script>
			// The configuration options for the text editors
			var config = {
				/*toolbar:[
					['Source', '-', 'Bold', 'Italic', 'Link'],
					['Format'],
					['Insert', 'ShowBlocks','-','About']
				]*/
			};
			config.format_tags = 'h1;h2;h3;h4;p';
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
			
			// CKEDITOR.replace( 'editor1', {
		        // filebrowserBrowseUrl : '/ckfinder/ckfinder.html',
		        // filebrowserImageBrowseUrl : '/ckfinder/ckfinder.html?Type=Images',
		        // filebrowserFlashBrowseUrl : '/ckfinder/ckfinder.html?Type=Flash',
		        // filebrowserUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
		        // filebrowserImageUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
		        // filebrowserFlashUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
		    // });
			
			
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
			
			$(function($) {
				$("#publish_date_container").hide();
				$("#draft_status").click(function() {
  					if (this.checked == true) {
  						$("#publish_date_container").hide();
  					} else {
  						$("#publish_date_container").show();
  					}
				});
			});
			
			// Duplicate website fields. 
			
        	$(function() {
            	$('#add_website').click(function() {
                	$("<br />").appendTo('#website_container');
                	$('#websites').clone().val('').appendTo('#website_container');
                	return false;
            	});
        	});

		</script>

        <title>HIMMS Wire</title>
    </head>
    
    <body id="home">
        
        <div id="main_container">

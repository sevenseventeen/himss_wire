<!DOCTYPE html>
<html>

    <head>
    	
    	<?php 
    		if ($this->session->userdata('admin_accordion_state')) {
    			$admin_accordion_state = $this->session->userdata('admin_accordion_state');
			} else {
				$admin_accordion_state = '0';
			}
		?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/reset.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/main.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/debugging.css'; ?>" />

        <!-- JQuery and JQuery UI -->

        <link type="text/css" href="<?php echo base_url().'_css/jquery_ui_theme/jquery-ui-1.8.20.custom.css'; ?>" rel="stylesheet" />
        <link type="text/css" href="<?php echo base_url().'_css/jquery_ui_override.css'; ?>" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url().'_javascript/jquery-1.7.2.min.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'_javascript/jquery-ui-1.8.20.custom.min.js'; ?>"></script>
		
		<!-- Max Length Script -->
		
		<script type="text/javascript">
			$(function($) {
				var ignore = [8,9,13,33,34,35,36,37,38,39,40,46];
				var eventName = 'keypress';
				$('textarea[maxlength]')
					.live(eventName, function(event) {
						alert("test");
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

		<!-- CK Editor -->
		
		<script type="text/javascript" src="<?php echo base_url().'/ckeditor/ckeditor.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'/ckeditor/adapters/jquery.js'; ?>"></script>
		<script>
			// The configuration options for the text editors
			var config = {
				toolbar:[
					[ 'Source', '-', 'Bold', 'Italic', 'Link'],
					[ 'Format' ]
				]
			};
			config.format_tags = 'h1;h2;h3;h4;p';
			$(function() {
				$(".tabs").tabs();
				$("textarea.ckeditor").ckeditor(config);
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
		
		<!-- Share This -->
		
		<script type="text/javascript">var switchTo5x=true;</script>
		<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
		<script type="text/javascript">
			stLight.options({
				publisher: "ur-3920714f-f56c-9f11-67a7-d12e6156f1a0",
				onhover: false
			});
		</script>
		
		
        <title>HIMMS Wire</title>
    </head>
    
    <body id="home">
        
        <div id="main_container">

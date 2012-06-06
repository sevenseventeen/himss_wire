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
		
		<!-- LinkedIn Module -->
		
		<script type="text/javascript" src="http://platform.linkedin.com/in.js">
  			api_key: 24kp3woxkhce
  			authorize: true
		</script>
		
		<!-- End LinkedIn -->
		
		
        <title>HIMMS Wire</title>
    </head>
    
    <body id="home">
        
        <div id="main_container">

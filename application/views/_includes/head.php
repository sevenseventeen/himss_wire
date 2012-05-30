<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/reset.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/main.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'_css/debugging.css'; ?>" />

        <!-- JQuery and JQuery UI -->

        <link type="text/css" href="<?php echo base_url().'_css/jquery_ui_theme/jquery-ui-1.8.20.custom.css'; ?>" rel="stylesheet" />
        <link type="text/css" href="<?php echo base_url().'_css/jquery_ui_override.css'; ?>" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url().'_javascript/jquery-1.7.2.min.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'_javascript/jquery-ui-1.8.20.custom.min.js'; ?>"></script>

		<!-- End JQuery and JQuery UI -->

		<!-- CK Editor -->
		
		<script type="text/javascript" src="<?php echo base_url().'/ckeditor/ckeditor.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo base_url().'/ckeditor/adapters/jquery.js'; ?>"></script>
		<script>
			// The configuration options for the text editors
			var config = {
				toolbar:[
					[ 'Source', '-', 'Bold', 'Italic', 'Link' ]
				]
			};
			$(function() {
				$(".tabs").tabs();
				$("#accordion").accordion({ collapsible:true, autoHeight: false, active: <?php echo 1; ?> });
				$("textarea.ckeditor").ckeditor(config);
				$("#accordion").click(function() {
  					var admin_accordion_level = $("#accordion").accordion("option", "active");
				});
			});
			
			
		</script>
		
		<?php //$this->session->set_userdata('current_admin_accordion', 'some_value'); ?>
		
		<!-- End CK Editor -->		
		
		
        <title>HIMMS Wire</title>
    </head>
    
    <body id="home">
        
        <div id="main_container">

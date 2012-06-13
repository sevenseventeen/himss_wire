<?php 
	$data['main_navigation'] = 'home';
	$this->load->view('_includes/head');
	$this->load->view('_includes/header', $data);
?>
	
<script type="text/javascript" src="http://platform.linkedin.com/in.js">
	api_key: 24kp3woxkhce
	authorize: true
</script>
<script type="text/javascript">
	function loadData() {
		IN.API.Raw("/groups/166581:(id,name,short-description,description,posts)")
			.result(function(result) {
				console.debug(result);
				profHTML = "H";
				for (var index in result.values) {
					profHTML += "ello";
					profile = result.values[index]
					if (profile.title) {
						profHTML += "<p>Hello</p>";
						//profHTML += "<img class=img_border height=30 align=\"left\" src=\"" + profile.pictureUrl + "\"></a>";   
					}    
				}
				$("#connections").html(profHTML);
			});
		}
</script>

<div id="main_content">
	<div class="category_module module_600 rounded_corners_10 inner_shadow_2">
		<img class="module_header_icon" src="_images/latest_article_icon.png" />
		<h1 class="module_header_with_icon rounded_top_corners_10 header_gradient inner_shadow_2">The Latest</h1>
		<?php foreach ($articles as $article) { ?>
			<div class="article_snippet">
				<h2><a href="<?php echo base_url().'article/'.$article->article_id; ?>"><?php echo $article->article_title; ?></a></h2>
				<h3 class="date_and_category">
					<?php 
						$date = new DateTime($article->publish_date);
						echo $date->format('m-d-Y');
						echo " | <a href='".base_url().'category/'.$article->article_category_id."'>".$article->category_name."</a>";
					?>
				</h3>
				<p><?php echo $article->article_summary; ?></p>
				<p><a href="<?php echo base_url().'article/'.$article->article_id; ?>">Read Article</a></p>
			</div>
		<?php }?>
	</div>
</div>

<aside>
	<?php $this->load->view('_includes/feature_module'); ?>
	<?php $this->load->view('_includes/search_module'); ?>
	<?php $this->load->view('_includes/banner_ad_module'); ?>
</aside>

<br class="clear_float" />

<?php 
	$this->content_library->load_footer();
?>
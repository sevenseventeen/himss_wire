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
			//alert("load data");
			//IN.API.Groups(93115)
			//IN.API.Raw("/groups/93115/posts:(title,summary,creator)?order=recency")
			//IN.API.Raw("/groups/93115/posts:(title,summary,creator)?order=recency")
			//IN.API.Raw("/groups/1778196:(id,name,short-description,description,posts)")
			//IN.API.Raw("/groups/93115:(id,name,short-description,description,posts)")
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
				// .error( function(error) { 
					// alert("error");
				// });
			}
			//IN.API.Groups("93115")
			//.posts(["title","summary","creator"])
			//.params({"count":30})
			// .result(function(result) {
				// alert(result);
				// console.debug(result);
				// profHTML = "";
				// for (var index in result.values) {
					// profile = result.values[index]
					// if (profile.title) {
						// profHTML += "<p>Hello</p>";
						// //profHTML += "<img class=img_border height=30 align=\"left\" src=\"" + profile.pictureUrl + "\"></a>";   
					// }    
				// }
				// $("#connections").html(profHTML);
			// });
			//
		//}

		// function loadData() {
			// alert("load data");
			// IN.API.Groups(93115)
			// .posts(["title","summary","creator"])
			// .params({"count":30})
			// .result(function(result) {
				// alert(result);
				// $("#connections").html(profHTML);
			// });
		// }
// 		
		
		// function loadData() {
			// IN.API.Connections("me")
			// .fields(["pictureUrl","publicProfileUrl"])
			// .params({"count":30})
			// .result(function(result) {
				// console.debug(result);
				// profHTML = "";
				// for (var index in result.values) {
					// profile = result.values[index]
					// if (profile.pictureUrl) {
						// profHTML += "<p><a href=\"" + profile.publicProfileUrl + "\">";
						// profHTML += "<img class=img_border height=30 align=\"left\" src=\"" + profile.pictureUrl + "\"></a>";   
					// }    
				// }
				// $("#connections").html(profHTML);
			// });
		// }
		
		//IN.API.Raw("/groups/12345/posts:(title,summary,creator)?order=recency")
		//IN.API.Raw("/groups/12345:(id,name,short-description,description,posts)")
		//IN.API.Raw("/people/~/group-memberships?membership-state=member ") 
		//IN.API.Raw("/people/~/suggestions/groups")
		
	</script>
	
	<div id="main_content" class="rounded_corners_10 module_600 inner_shadow_2">
		<img class="module_header_icon" src="_images/latest_article_icon.png" />
		<h1 class="module_header_with_icon rounded_top_corners_10 header_gradient inner_shadow_2">The Latest</h1>
		<?php foreach ($articles as $article) { ?>
			<div class="article_snippet">
				<h2><?php echo $article->article_title; ?></h2>
				<h3 class="date">
					<?php 
						$date = new DateTime($article->publish_date);
						echo $date->format('m-d-Y');
					?>
				</h3>
				<br class=" clear_float" />
				<?php echo $article->article_summary; ?>
				<a href="<?php echo base_url().'article/'.$article->article_id; ?>" class="category">Read Article</a>
			</div>
		<?php }?>
	</div>
			
	<aside>
		<?php $this->load->view('_includes/feature_module'); ?>
		<?php $this->load->view('_includes/search_module'); ?>
		<?php $this->load->view('_includes/linked_in_module'); ?>
		<?php $this->load->view('_includes/banner_ad_module'); ?>
	</aside>
	
	<!--<script type="text/javascript" src="http://cdn.widgetserver.com/syndication/subscriber/InsertWidget.js"></script><script type="text/javascript">if (WIDGETBOX) WIDGETBOX.renderWidget('75f5638c-1d72-4f35-a0d7-f04f9a038da2');</script>
	<noscript>Get the <a href="http://www.widgetbox.com/widget/apple-hot-news-sevenseventeen">Apple Hot News</a> widget and many other <a href="http://www.widgetbox.com/">great free widgets</a> at <a href="http://www.widgetbox.com">Widgetbox</a>! Not seeing a widget? (<a href="http://support.widgetbox.com/">More info</a>)</noscript>
	-->
			
	<br class="clear_float" />
			

<?php 
	$this->content_library->load_footer();
?>
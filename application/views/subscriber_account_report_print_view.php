<div id="main_content" class="rounded_corners_10 module_920 inner_shadow_2">
		
	<h2><?php echo $subscriber_account[0]->company_name; ?></h2>
	<p>
		<?php echo $subscriber_account[0]->first_name." ".$subscriber_account[0]->last_name; ?><br />
		<?php echo $subscriber_account[0]->phone_number; ?><br />
		<?php echo $subscriber_account[0]->street_address; ?><br />
		<?php echo $subscriber_account[0]->city.", ".$subscriber_account[0]->state; ?><br />
		<?php echo $subscriber_account[0]->zip_code; ?><br />
		<?php echo $subscriber_account[0]->website; ?><br />
		<?php echo $user_account[0]->email; ?><br />
	</p>
	<?php 
		$user_id = $user_account[0]->user_id;
		$subscriber_account_id = $subscriber_account[0]->subscriber_account_id;
	?>
	<h2>Subscription Package</h2>
	<?php if ($subscription_details) { ?>
		<?php 
			$subscription_start_date_datetime = new DateTime($subscription_details[0]->subscription_start_date); 
			$subscription_start_date_formattted = $subscription_start_date_datetime->format('Y-m-d');
			$subscription_end_date_datetime = new DateTime($subscription_details[0]->subscription_end_date); 
			$subscription_end_date_formattted = $subscription_end_date_datetime->format('Y-m-d');
		?>
		<p>Package Summary: 	<span class="data"><?php echo $subscription_details[0]->subscription_summary; ?></p>
		<p>
			Articles Published:	<span class="data"><?php echo count($articles); ?></span><br />
			Package Details: 	<span class="data"><?php echo $subscription_details[0]->subscription_details; ?></span><br />
			Purchased Articles:	<span class="data"><?php echo $subscription_details[0]->stories_purchased; ?></span><br />
			Remaining Articles:	<span class="data"><?php echo $subscription_details[0]->stories_remaining; ?></span><br />
			Subscription Start: <span class="data"><?php echo $subscription_start_date_formattted; ?></span><br />
			Subscription End: 	<span class="data"><?php echo $subscription_end_date_formattted; ?></span><br />
		</p>
	<?php } else { ?>
		<h3>No subscription package found.</h3>
	<?php } ?>
	
	<h2>Current Published Articles</h2>
	<p>
		<?php 
			foreach ($published_articles as $published_article) {
				echo "<a href='".base_url()."article/".$published_article->category_slug."/".$published_article->article_slug."'>".$published_article->article_title."</a><br />".base_url()."article/".$published_article->article_slug."<br /><br />";
			}
		?>
	</p>
	
</div>
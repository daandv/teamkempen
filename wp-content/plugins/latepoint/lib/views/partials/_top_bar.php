<div class="latepoint-top-bar-w">
	<div class="latepoint-top-logo">
		<a href="<?php echo OsRouterHelper::build_link(OsRouterHelper::build_route_name('dashboard', 'index')); ?>"><img src="<?php echo LatePoint::images_url().'logo-admin.png' ?>" alt=""></a>
	</div>
	<div class="latepoint-top-search-w">
		<div class="latepoint-top-search-input-w">
			<input type="text" data-route="<?php echo OsRouterHelper::build_route_name('search', 'query_results') ?>" class="latepoint-top-search" placeholder="<?php _e('Start typing to search...', 'latepoint'); ?>">
		</div>
		<div class="latepoint-top-search-results-w"></div>
	</div>
	<a href="<?php echo OsRouterHelper::build_link(OsRouterHelper::build_route_name('bookings', 'pending_approval')); ?>" class="latepoint-top-notifications-trigger">
		<i class="latepoint-icon latepoint-icon-bell"></i>
		<?php  
		$count_pending_bookings = OsBookingHelper::count_pending_bookings(OsAuthHelper::get_logged_in_agent_id(), OsLocationHelper::get_selected_location_id());
		if($count_pending_bookings > 0) echo '<span class="notifications-count">'.$count_pending_bookings.'</span>'; ?>
	</a>
	<a href="<?php echo $settings_link; ?>" class="latepoint-top-settings-trigger"><i class="latepoint-icon latepoint-icon-settings"></i></a>
	<?php 
	if(OsLocationHelper::count_locations() > 1){
		echo '<select class="os-main-location-selector" data-route="'.OsRouterHelper::build_route_name('locations', 'set_selected_location').'">';
		foreach($locations_for_select as $location_for_select){
			$selected = (OsLocationHelper::get_selected_location_id() == $location_for_select->id) ? 'selected="selected"' : '';
			echo '<option '.$selected.' value="'.$location_for_select->id.'">'.$location_for_select->name.'</option>';
		}
		echo '</select>';
	} ?>
	<a href="#" class="latepoint-top-new-appointment-btn latepoint-btn latepoint-btn-primary" <?php echo OsBookingHelper::quick_booking_btn_html(); ?>>
		<i class="latepoint-icon latepoint-icon-plus-circle"></i>
		<span><?php _e('New Appointment', 'latepoint'); ?></span>
	</a>
	<div class="latepoint-top-user-info-w">
		<?php 
    if ( in_array($logged_in_admin_user_type, [LATEPOINT_WP_ADMIN_ROLE, LATEPOINT_WP_AGENT_ROLE] )) { ?>
      <div class="avatar-w" style="background-image: url('<?php echo $logged_in_user_avatar_url; ?>);"></div>
	  	<div class="latepoint-user-info-dropdown">
	  		<div class="latepoint-uid-head">
					<div class="uid-avatar-w">
						<div class="uid-avatar" style="background-image: url('<?php echo $logged_in_user_avatar_url; ?>);"></div>
					</div>
					<div class="uid-info">
			  		<h4><?php echo $logged_in_user_displayname; ?></h4>
			  		<h5><?php echo $logged_in_user_role; ?></h5>
					</div>
				</div>
	  		<ul>
	  			<li>
	  				<a href="<?php echo $settings_link; ?>">
		  				<i class="latepoint-icon latepoint-icon-ui-46"></i>
		  				<span><?php _e('Settings', 'latepoint'); ?></span>
		  			</a>
		  		</li>
	  			<li>
	  				<a href="<?php echo wp_logout_url(); ?>">
		  				<i class="latepoint-icon latepoint-icon-log-in"></i>
		  				<span><?php _e('Logout', 'latepoint'); ?></span>
	  				</a>
	  			</li>
	  		</ul>
	  	</div>
	  	<?php 
    } ?>
	</div>
</div>
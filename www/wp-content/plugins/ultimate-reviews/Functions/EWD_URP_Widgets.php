<?php
class EWD_URP_Recent_Reviews_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'ewd_urp_recent_reviews_widget', // Base ID
			__('Recent Reviews', 'ultimate-reviews'), // Name
			array( 'description' => __( 'Insert a number of recent reviews', 'EWD_URP' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$params =  array('posts_per_page' => $instance['post_count'],
						'post_type' => 'urp_review',
						'orderby' => 'date',
					);
		if ($instance['product_name'] != 'All' and $instance['product_name'] != "") {
			$params['meta_query'] = array(
				array(
					'key' => 'EWD_URP_Product_Name',
					'value' => $instance['product_name']
				)
			);
		}
		$Posts_Query = new WP_Query($params);
		$Posts = $Posts_Query->posts;
		if (is_array($Posts)) {foreach ($Posts as $Post) {$Post_IDs .= $Post->ID . ",";}}
		$Post_IDs = trim($Post_IDs, ",");

		echo $args['before_widget'];
		echo $instance['before_text'];
		echo do_shortcode("[select-review review_id='" . $Post_IDs . "']");
		echo $instance['after_text'];
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$Product_Names = EWD_URP_Get_Product_Names();

		$before_text = ! empty( $instance['before_text'] ) ? $instance['before_text'] : __( '', 'EWD_URP' );
		$product_name = ! empty( $instance['product_name'] ) ? $instance['product_name'] : __( 'All', 'EWD_URP' );
		$post_count = ! empty( $instance['post_count'] ) ? $instance['post_count'] : __( '3', 'EWD_URP' );
		$after_text = ! empty( $instance['after_text'] ) ? $instance['after_text'] : __( '', 'EWD_URP' );

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'before_text' ); ?>"><?php _e( 'Text Before:', 'EWD_URP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'before_text' ); ?>" name="<?php echo $this->get_field_name( 'before_text' ); ?>" type="text" value="<?php echo esc_attr( $before_text ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'product_name' ); ?>"><?php _e( 'Reviewed Product:', 'EWD_URP' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'product_name' ); ?>" name="<?php echo $this->get_field_name( 'product_name' ); ?>">
			<option value='All' <?php echo ($product_name == 'All' ? 'selected' : ''); ?>><?php _e("All Products", 'EWD_URP'); ?></option>
			<?php if (is_array($Product_Names)) {foreach ($Product_Names as $Product_Name) { ?>
				<option value='<?php echo esc_attr($Product_Name); ?>' <?php echo ($product_name == $Product_Name ? 'selected' : ''); ?>><?php echo esc_attr($Product_Name); ?></option>
			<?php }} ?>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'post_count' ); ?>"><?php _e( 'Number of Reviews:', 'EWD_URP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'post_count' ); ?>" name="<?php echo $this->get_field_name( 'post_count' ); ?>" type="text" value="<?php echo esc_attr( $post_count ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'after_text' ); ?>"><?php _e( 'Text After:', 'EWD_URP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'after_text' ); ?>" name="<?php echo $this->get_field_name( 'after_text' ); ?>" type="text" value="<?php echo esc_attr( $after_text ); ?>">
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['before_text'] = ( ! empty( $new_instance['before_text'] ) ) ? strip_tags( $new_instance['before_text'] ) : '';
		$instance['product_name'] = ( ! empty( $new_instance['product_name'] ) ) ? strip_tags( $new_instance['product_name'] ) : '';
		$instance['post_count'] = ( ! empty( $new_instance['post_count'] ) ) ? strip_tags( $new_instance['post_count'] ) : 'All';
		$instance['after_text'] = ( ! empty( $new_instance['after_text'] ) ) ? strip_tags( $new_instance['after_text'] ) : '';
		return $instance;
	}
}

function EWD_URP_Register_Recent_Reviews_Widget() {
	return register_widget("EWD_URP_Recent_Reviews_Widget");
}
add_action('widgets_init', 'EWD_URP_Register_Recent_Reviews_Widget');

class EWD_URP_Selected_Reviews_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'ewd_urp_selected_reviews_widget', // Base ID
			__('Selected Reviews', 'ultimate-reviews'), // Name
			array( 'description' => __( 'Insert a number of selected reviews', 'EWD_URP' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo $instance['before_text'];
		echo do_shortcode("[select-review review_id='" . $instance['post_ids'] . "']");
		echo $instance['after_text'];
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$before_text = ! empty( $instance['before_text'] ) ? $instance['before_text'] : __( '', 'EWD_URP' );
		$post_ids = ! empty( $instance['post_ids'] ) ? $instance['post_ids'] : __( '', 'EWD_URP' );
		$after_text = ! empty( $instance['after_text'] ) ? $instance['after_text'] : __( '', 'EWD_URP' );

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'before_text' ); ?>"><?php _e( 'Text Before:', 'EWD_URP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'before_text' ); ?>" name="<?php echo $this->get_field_name( 'before_text' ); ?>" type="text" value="<?php echo esc_attr( $before_text ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'post_ids' ); ?>"><?php _e( 'IDs of Posts to Display', 'EWD_URP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'post_ids' ); ?>" name="<?php echo $this->get_field_name( 'post_ids' ); ?>" type="text" value="<?php echo esc_attr( $post_ids ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'after_text' ); ?>"><?php _e( 'Text After:', 'EWD_URP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'after_text' ); ?>" name="<?php echo $this->get_field_name( 'after_text' ); ?>" type="text" value="<?php echo esc_attr( $after_text ); ?>">
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['before_text'] = ( ! empty( $new_instance['before_text'] ) ) ? strip_tags( $new_instance['before_text'] ) : '';
		$instance['post_ids'] = ( ! empty( $new_instance['post_ids'] ) ) ? strip_tags( $new_instance['post_ids'] ) : '';
		$instance['after_text'] = ( ! empty( $new_instance['after_text'] ) ) ? strip_tags( $new_instance['after_text'] ) : '';
		return $instance;
	}
}

function EWD_URP_Register_Selected_Reviews_Widget() {
	return register_widget("EWD_URP_Selected_Reviews_Widget");
}
add_action('widgets_init', 'EWD_URP_Register_Selected_Reviews_Widget');

class EWD_URP_Popular_Reviews_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'ewd_urp_popular_reviews_widget', // Base ID
			__('Popular Reviews', 'ultimate-reviews'), // Name
			array( 'description' => __( 'Insert a number of popular reviews', 'EWD_URP' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$params =  array('posts_per_page' => $instance['post_count'],
						'post_type' => 'urp_review',
						'orderby' => 'meta_value_num',
						'meta_key' => 'urp_view_count'
					);
		if ($instance['product_name'] != 'All' and $instance['product_name'] != "") {
			$params['meta_query'][] = array(
				array(	
					'key' => 'EWD_URP_Product_Name',
					'value' => $instance['product_name']
				)
			);
		}
		$Posts_Query = new WP_Query($params);
		$Posts = $Posts_Query->posts;
		if (is_array($Posts)) {foreach ($Posts as $Post) {$Post_IDs .= $Post->ID . ",";}}
		$Post_IDs = trim($Post_IDs, ",");

		echo $args['before_widget'];
		echo $instance['before_text'];
		echo do_shortcode("[select-review review_id='" . $Post_IDs . "']");
		echo $instance['after_text'];
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$Product_Names = EWD_URP_Get_Product_Names();

		$before_text = ! empty( $instance['before_text'] ) ? $instance['before_text'] : __( '', 'EWD_URP' );
		$product_name = ! empty( $instance['product_name'] ) ? $instance['product_name'] : __( 'All', 'EWD_URP' );
		$post_count = ! empty( $instance['post_count'] ) ? $instance['post_count'] : __( '3', 'EWD_URP' );
		$after_text = ! empty( $instance['after_text'] ) ? $instance['after_text'] : __( '', 'EWD_URP' );

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'before_text' ); ?>"><?php _e( 'Text Before:', 'EWD_URP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'before_text' ); ?>" name="<?php echo $this->get_field_name( 'before_text' ); ?>" type="text" value="<?php echo esc_attr( $before_text ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'product_name' ); ?>"><?php _e( 'Reviewed Product:', 'EWD_URP' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'product_name' ); ?>" name="<?php echo $this->get_field_name( 'product_name' ); ?>">
			<option value='All' <?php echo ($product_name == 'All' ? 'selected' : ''); ?>><?php _e("All Products", 'EWD_URP'); ?></option>
			<?php if (is_array($Product_Names)) {foreach ($Product_Names as $Product_Name) { ?>
				<option value='<?php echo esc_attr($Product_Name); ?>' <?php echo ($product_name == $Product_Name ? 'selected' : ''); ?>><?php echo esc_attr($Product_Name); ?></option>
			<?php }} ?>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'post_count' ); ?>"><?php _e( 'Number of Reviews:', 'EWD_URP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'post_count' ); ?>" name="<?php echo $this->get_field_name( 'post_count' ); ?>" type="text" value="<?php echo esc_attr( $post_count ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'after_text' ); ?>"><?php _e( 'Text After:', 'EWD_URP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'after_text' ); ?>" name="<?php echo $this->get_field_name( 'after_text' ); ?>" type="text" value="<?php echo esc_attr( $after_text ); ?>">
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['before_text'] = ( ! empty( $new_instance['before_text'] ) ) ? strip_tags( $new_instance['before_text'] ) : '';
		$instance['product_name'] = ( ! empty( $new_instance['product_name'] ) ) ? strip_tags( $new_instance['product_name'] ) : '';
		$instance['post_count'] = ( ! empty( $new_instance['post_count'] ) ) ? strip_tags( $new_instance['post_count'] ) : '';
		$instance['after_text'] = ( ! empty( $new_instance['after_text'] ) ) ? strip_tags( $new_instance['after_text'] ) : '';
		return $instance;
	}
}

function EWD_URP_Register_Popular_Reviews_Widget() {
	return register_widget("EWD_URP_Popular_Reviews_Widget");
}
add_action('widgets_init', 'EWD_URP_Register_Popular_Reviews_Widget');

class EWD_URP_Reviews_Slider_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'ewd_urp_reviews_slider_widget', // Base ID
			__('Reviews Slider', 'ultimate-reviews'), // Name
			array( 'description' => __( 'Insert a slider of reviews (requires "Ultimate Slider" plugin installed)', 'EWD_URP' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo $instance['before_text'];
		echo do_shortcode("[ultimate-slider slider_type='urp' post__in_string='" . $instance['post_ids'] . "']");
		echo $instance['after_text'];
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$before_text = ! empty( $instance['before_text'] ) ? $instance['before_text'] : __( '', 'EWD_URP' );
		$post_ids = ! empty( $instance['post_ids'] ) ? $instance['post_ids'] : __( '', 'EWD_URP' );
		$after_text = ! empty( $instance['after_text'] ) ? $instance['after_text'] : __( '', 'EWD_URP' );

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'before_text' ); ?>"><?php _e( 'Text Before:', 'EWD_URP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'before_text' ); ?>" name="<?php echo $this->get_field_name( 'before_text' ); ?>" type="text" value="<?php echo esc_attr( $before_text ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'post_ids' ); ?>"><?php _e( 'IDs of Posts to Display', 'EWD_URP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'post_ids' ); ?>" name="<?php echo $this->get_field_name( 'post_ids' ); ?>" type="text" value="<?php echo esc_attr( $post_ids ); ?>">
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'after_text' ); ?>"><?php _e( 'Text After:', 'EWD_URP' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'after_text' ); ?>" name="<?php echo $this->get_field_name( 'after_text' ); ?>" type="text" value="<?php echo esc_attr( $after_text ); ?>">
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['before_text'] = ( ! empty( $new_instance['before_text'] ) ) ? strip_tags( $new_instance['before_text'] ) : '';
		$instance['post_ids'] = ( ! empty( $new_instance['post_ids'] ) ) ? strip_tags( $new_instance['post_ids'] ) : '';
		$instance['after_text'] = ( ! empty( $new_instance['after_text'] ) ) ? strip_tags( $new_instance['after_text'] ) : '';
		return $instance;
	}
}

function EWD_URP_Register_Reviews_Slider_Widget() {
	return register_widget("EWD_URP_Reviews_Slider_Widget");
}
add_action('widgets_init', 'EWD_URP_Register_Reviews_Slider_Widget');

function EWD_URP_Get_Product_Names( $status = 'publish' ) {

    global $wpdb;

    $r = $wpdb->get_col( $wpdb->prepare( "
        SELECT DISTINCT(pm.meta_value) FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = 'EWD_URP_Product_Name' 
        AND p.post_status = '%s' 
        AND p.post_type = 'urp_review'
    ", $status ) );

    return $r;
}
?>
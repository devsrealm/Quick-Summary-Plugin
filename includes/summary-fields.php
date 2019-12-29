<?php 

function quick_summary_meta_box() {
	
		global $post;
			
		add_meta_box(
			'quicksummary_Id', // unique Id for the box
			__( 'Quick Summary Box', 'quicksummary' ), //title of the box
			'quick_summary_meta_box_fields', // callback function
			'post',	// post type
			'side',
			'core'
		);
	
}
	
add_action ('add_meta_boxes', 'quick_summary_meta_box');

function quick_summary_meta_box_fields( $post ) {
		// Use nonce for verification
		wp_nonce_field( plugin_basename( __FILE__ ), 'quicksummary_noncename' );

		$title    = get_post_meta( $post->ID, 'quicksummary_title', true );
		$textarea = get_post_meta( $post->ID, 'quicksummary_textarea', true );
		
		?>	
		<p>
				<label for="quicksummary_title">Title</label><br />
				<input type="text" class="all-options" name="quicksummary_title" id="quicksummary_title" value="<?php echo esc_attr( $title ); ?>" />
				<span class="description">Title you wanna label, e.g Quick Summary</span>
		</p>
		
		<p>
				<label for="quicksummary_textarea">Textarea</label><br />
				<textarea name="quicksummary_textarea" id="quicksummary_textarea" cols="60" rows="4" style="width:97%" ><?php echo esc_attr( $textarea ); ?></textarea> <br />
				
				<span class="description">The excerpt or summary of the post</span>
		</p>

		<?php 
	}

function quick_summary_meta_box_save ( $post_id ) {
        // verify if this is an auto save routine.
        // If it is the post has not been updated, so we don't want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return $post_id;
        }
 
        // verify this came from the screen and with proper authorization,
        // because save_post can be triggered at other times
        if ( !isset( $_POST['quicksummary_noncename'] ) || !wp_verify_nonce( $_POST['quicksummary_noncename'], plugin_basename( __FILE__ ) ) ) {
                return $post_id;
        }
 
        // Get the post type object.
        global $post;
        $post_type = get_post_type_object( $post->post_type );

        // Check if the current user has permission to edit the post.
        if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
                return $post_id;
        }
 
        // Get the posted data and pass it into an associative array for ease of entry
        $metadata['quicksummary_title'] = ( isset( $_POST['quicksummary_title'] ) ? $_POST['quicksummary_title'] : '' );
		$metadata['quicksummary_textarea'] = ( isset( $_POST['quicksummary_textarea'] ) ? $_POST['quicksummary_textarea'] : '' );
 
        // add/update record (both are taken care of by update_post_meta)
        foreach( $metadata as $key => $value ) {
                // get current meta value
                $current_value = get_post_meta( $post_id, $key, true);
 
                if ( $value && '' == $current_value ) {
                        add_post_meta( $post_id, $key, $value, true );
                } elseif ( $value && $value != $current_value ) {
                        update_post_meta( $post_id, $key, $value );
                } elseif ( '' == $value && $current_value ) {
                        delete_post_meta( $post_id, $key, $current_value );
                }
        }
}
 
add_action ('save_post', 'quick_summary_meta_box_save');
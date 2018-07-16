<?php
/* Class last_five_films_widget */
class LastFiveFilms_Widget extends WP_Widget {
	function LastFiveFilms_Widget() {
		parent::__construct (
			'last_five_films_widget', // id widget
			'Last five films Widget', // name widget
			array(
				'description' => 'Last five films Widget' // description
			)
		);
    }

    function form( $instance ) {
		$default = array(
        	'title' => 'Last five films Widget'
		);
		$instance = wp_parse_args( (array) $instance, $default);
		$title = esc_attr( $instance['title'] );
		echo "Title <input class='widefat' type='text' name='".$this->get_field_name('title')."' value='".$title."' />";
    }

    function update( $new_instance, $old_instance ) {
    	parent::update( $new_instance, $old_instance );
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function widget( $args, $instance ) {
    	echo "<aside id='last5films' class='widget'>
			<div class='list-group'>
				<h1 class='list-group-item active'>Last 5 films</h1>".do_shortcode('[last_five_films]')."
			</div>
		</aside>";
    }
}


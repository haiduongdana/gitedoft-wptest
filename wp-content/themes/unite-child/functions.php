<?php
/* Create custom_post_type function */
function custom_post_type() {
	/* Variable $label include text show of Post Type in Admin */
	$label = array(
        'name' => 'Films', 			//	The post type is plural
        'singular_name' => 'Film'	//	The post type is singular_name
    );
 
	/* Variable $args are important parrams in Post Type */
    $args = array(
        'labels' => $label, 						// Call label in $label Variable above
        'description' => 'Post type Films', 		// Post type description
        'supports'   => array(
        	'title', 
        	'editor', 
        	'comments', 
        	'thumbnail', 
        ),	// Custom Post Type features will be displayed
        'taxonomies' => array( 
        	'Genre', 
        	'Country', 
        	'Year', 
        	'Actors' 
        ), 	// Taxonomies will be use
        'public' => true, 											   	// Activated post type
        'show_ui' => true, 												// Show in admin as Post/Page
        'show_in_menu' => true, 										// Show in Admin Left-Menu
        'show_in_nav_menus' => true, 									// Show in Appearance -> Menus
        'show_in_admin_bar' => true, 									// Show in Admin bar (black color)
        'menu_position' => 5, 											// Order number in admin left-menu
        'menu_icon' => get_stylesheet_directory_uri().'/icon/film.png',	// Icon url
        'can_export' => true, 											// Exportable by Tools -> Export
        'has_archive' => true, 											// Allow archire (month, date, year)
        'exclude_from_search' => false, 								// Do not allow google search
        'publicly_queryable' => true, 									// Parrams show in query, default is true
        'capability_type' => 'post'							
    );
 	// register post type with slug is films with parrams $args
    register_post_type('films', $args); 
}

// Activated custom_post_type
add_action( 'init', 'custom_post_type' );

// Show films post type in home page
add_filter('pre_get_posts','lay_custom_post_type');
function lay_custom_post_type($query) {
  if (is_home() && $query->is_main_query ())
    $query->set ('post_type', array ('post','films'));
    return $query;
}


// Activated my_admin
add_action( 'admin_init', 'my_admin' );

function my_admin() {
    add_meta_box( 'films_meta_box',
        'Custome Fields',
        'display_films_meta_box',
        'films', 'normal', 'high'
    );
}

// Display 2 input fields ticket_price & release_date in add/edit post
function display_films_meta_box( $film_fields ) {
    // Retrieve current name of the Ticket_price and Release_date based on review ID
    $ticket_price = esc_html( get_post_meta( $film_fields->ID, 'ticket_price', true ) );
    $release_date = esc_html( get_post_meta( $film_fields->ID, 'release_date', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 150px">Ticket Price</td>
            <td><input type="text" size="100" name="ticket_price_name" value="<?php echo $ticket_price; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 150px">Release Date</td>
            <td><input type="date" size="600" name="release_date_name" value="<?php echo $release_date; ?>" /></td>
        </tr>
    </table>
    <?php
}

// Activated add_film_fields
add_action( 'save_post', 'add_film_fields', 10, 2 );

// Save data of 2 new fields ticket_price & release_date
function add_film_fields( $film_field_id, $film_fields ) {
    // Check post type for movie reviews
    if ( $film_fields->post_type == 'films' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['ticket_price_name'] ) && $_POST['ticket_price_name'] != '' ) {
            update_post_meta( $film_field_id, 'ticket_price', $_POST['ticket_price_name'] );
        }
        if ( isset( $_POST['release_date_name'] ) && $_POST['release_date_name'] != '' ) {
            update_post_meta( $film_field_id, 'release_date', $_POST['release_date_name'] );
        }
    }
}


add_action( 'custom_fields_after_content', 'show_custom_fields' );

function show_custom_fields(){
	$post  = get_post();
	echo list_posts_by_taxonomy( 'films', 'genre', $post->ID )."<br/>";
	echo list_posts_by_taxonomy( 'films', 'year', $post->ID )."<br/>";
    echo "<strong>Ticket Price: </strong>".esc_html( get_post_meta( get_the_ID(), 'ticket_price', true ))."<br/>";
    echo "<strong>Release Date: </strong>".esc_html( get_post_meta( get_the_ID(), 'release_date', true ))."<br/><br/>";
}

function create_shortcode() {
	$last_five_fims_query = new WP_Query(array(
        'posts_per_page' => 5,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_type' => 'films',
    ));

    ob_start();
    if ( $last_five_fims_query->have_posts() ) :
        while ( $last_five_fims_query->have_posts() ) :
            $last_five_fims_query->the_post();?>
			<a href="<?php the_permalink(); ?>" class="list-group-item"><?php the_title(); ?></a>
        <?php endwhile;
    endif;
    $list_post = ob_get_contents(); // Get all content above put to $list_post then return

    ob_end_clean();

    return $list_post;
}

add_shortcode( 'last_five_films', 'create_shortcode' );

if ( ! function_exists( 'create_last_five_films_widget' ) ) :
function create_last_five_films_widget() {
	register_widget('LastFiveFilms_Widget');
}
endif;

add_action( 'widgets_init', 'create_last_five_films_widget' );
include(get_template_directory() . "/../unite-child/inc/widgets/last-five-films-widget.php");


/*  */
add_action('init', 'create_custom_taxonimies');

function create_custom_taxonimies() {
    register_taxonomy('genre', 'films', array(
            'label' => 'Genre',
            'labels' => array(
                'name'          => __('Genres'),
                'singular_name' => __('Genre'),
                'add_new_item'  => __('Add New Genre'),
                'new_item'      => __('New Genre'),
                'add_new'       => __('Add Genre'),
                'edit_item'     => __('Edit Genre')
            ),
            'public' => true,
            'hierarchical' => true
        )
    );
    
    register_taxonomy('country', 'films', array(
            'label' => 'Country',
            'labels' => array(
                'name'          => __('Countries'),
                'singular_name' => __('Country'),
                'add_new_item'  => __('Add New Country'),
                'new_item'      => __('New Country'),
                'add_new'       => __('Add Country'),
                'edit_item'     => __('Edit Country')
            ),
            'public' => true,
            'hierarchical' => true
        )
    );
    
    register_taxonomy('year', 'films', array(
            'label' => 'Year',
            'labels' => array(
                'name'          => __('Years'),
                'singular_name' => __('Year'),
                'add_new_item'  => __('Add New Year'),
                'new_item'      => __('New Year'),
                'add_new'       => __('Add Year'),
                'edit_item'     => __('Edit Year')
            ),
            'public' => true,
            'hierarchical' => true,
			'meta_box_cb'       => 'year_meta_box',
        )
    );
    
    register_taxonomy('actors', 'films', array(
            'label' => 'Actors',
            'labels' => array(
                'name'          => __('Actors'),
                'singular_name' => __('Year'),
                'add_new_item'  => __('Add New Actor'),
                'new_item'      => __('New Actor'),
                'add_new'       => __('Add Actor'),
                'edit_item'     => __('Edit Actor')
            ),
            'public' => true,
            'hierarchical' => true
        )
    );
}

/* Custom taxonomy year with single select */
function show_required_field_error_msg( $post ) {
	if ( 'films' === get_post_type( $post ) && 'auto-draft' !== get_post_status( $post ) ) {
	    $year = wp_get_object_terms( $post->ID, 'year', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
        if ( is_wp_error( $year ) || empty( $year ) ) {
			printf(
				'<div class="error below-h2"><p>%s</p></div>',
				esc_html__( 'Year is mandatory for creating a new movie post' )
			);
		}
	}
}
// Unfortunately, 'admin_notices' puts this too high on the edit screen
add_action( 'edit_form_top', 'show_required_field_error_msg' );

/* Display Year meta box */
function year_meta_box( $post ) {
	$terms = get_terms( 'year', array( 'hide_empty' => false ) );
	$post  = get_post();
	$year = wp_get_object_terms( $post->ID, 'year', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
	$name  = '';
    if ( ! is_wp_error( $year ) ) {
    	if ( isset( $year[0] ) && isset( $year[0]->name ) ) {
			$name = $year[0]->name;
	    }
    }
	foreach ( $terms as $term ) {
?>
		<label title='<?php esc_attr_e( $term->name ); ?>'>
		    <input type="radio" name="year" value="<?php esc_attr_e( $term->name ); ?>" <?php checked( $term->name, $name ); ?>>
			<span><?php esc_html_e( $term->name ); ?></span>
		</label><br>
<?php
    }
}


/**
 * Save the movie meta box results.
 *
 * @param int $post_id The ID of the post that's being saved.
 */
function save_year_meta_box( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['year'] ) ) {
		return;
	}
	$year = sanitize_text_field( $_POST['year'] );
	// A valid year is required, so don't let this get published without one
	if ( empty( $year ) ) {
		// unhook this function so it doesn't loop infinitely
		remove_action( 'save_post_films', 'save_year_meta_box' );
		$postdata = array(
			'ID'          => $post_id,
			'post_status' => 'draft',
		);
		wp_update_post( $postdata );
	} else {
		$term = get_term_by( 'name', $year, 'year' );
		if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
			wp_set_object_terms( $post_id, $term->term_id, 'year', false );
		}
	}
}
add_action( 'save_post_films', 'save_year_meta_box' );


function list_posts_by_taxonomy( $post_type, $taxonomy, $post_id, $get_terms_args = array(), $wp_query_args = array() ){
    $tax_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
    if( $tax_terms ){
    	echo "<strong>".ucfirst($taxonomy).": </strong>";
    	
    	$i=0;
        foreach( $tax_terms  as $tax_term ){
        	echo (($i)? ', ':''). $tax_term->name;
    		$i++;
        }
    }
}

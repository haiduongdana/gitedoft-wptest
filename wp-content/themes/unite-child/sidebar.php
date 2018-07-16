<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package unite-child
 */
?>
	<div id="secondary" class="widget-area col-sm-12 col-md-4" role="complementary">
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="last5films" class="widget">
				<div class="list-group">
					<h1 class="list-group-item active">Last 5 films</h1>
					<?php echo do_shortcode('[last_five_films]'); ?>
				</div>
			</aside>
			
			<aside id="archives" class="widget">
				<h1 class="widget-title"><?php _e( 'Archives', 'unite' ); ?></h1>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget">
				<h1 class="widget-title"><?php _e( 'Meta', 'unite' ); ?></h1>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
	</div><!-- #secondary -->

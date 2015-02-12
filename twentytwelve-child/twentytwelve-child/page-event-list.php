<?php
/**
 *
 * Template Name: Event Page, List
 *
 * A template for displaying an events page.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
get_header();
?>

<div id="primary" class="site-content">
    <div id="content" role="main">
        <?php 
	while ( have_posts() ) : the_post();
        ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php
                    
                    the_content();
                    
                    // WP_Query arguments
                    $args = array(
                        'post_type' => 'am_event',
                        'post_status' => 'publish',
                        'orderby' => 'meta_value',
                        'meta_key' => 'am_startdate',
                        'order' => 'ASC',
                        'meta_query' => array(
                            array(
                            'key' => 'am_enddate',
                            'value' => date('Y-m-d H:i:s', time()), //don't change date format here!
                            'compare' => ">",
                            ),
                        ),
                    );
                    $the_query = new WP_Query($args);

                    // Display the page content and
                    ?>

                    <?php // Display the event table ?>
                    <ul>
                        <?php
                        // The Loop
                        if ($the_query->have_posts()) {
                            while ($the_query->have_posts()) {
                                $the_query->the_post();
                                $postId = $post->ID;

                                the_title('<li>', '</li>');

                                echo '<li style="list-style-type:none"><ul>';
                                    am_the_startdate('Y-m-d H:i', '<li> Start date: ', '</li>');
                                    am_the_enddate('Y-m-d H:i', '<li> End date: ', '</li>');

                                    the_title('<li>', '</li>');
                                    echo '<li>Categories: ' . am_get_the_event_category_list(',', 'multiple') . '</li>';
                                    echo '<li>Venues: ' . am_get_the_venue_list(',', 'multiple') . '</li>';
                                echo '</ul></li>';
                            }
                        }
                        ?>
                    </ul>

                    <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>

                </div><!-- .entry-content -->

                <footer class="entry-meta">
                        <?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
                </footer><!-- .entry-meta -->

            </article><!-- #post -->
            
            <?php comments_template( '', true ); ?>
            
        <?php endwhile; // end of the loop. ?>
    </div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
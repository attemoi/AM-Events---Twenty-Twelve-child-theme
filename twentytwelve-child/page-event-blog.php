<?php
/**
 *
 * Template Name: Event Page, Blog
 *
 * A template for displaying upcoming events in a blog format.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
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

                    // The Loop
                    if ($the_query->have_posts()) {
                        while ($the_query->have_posts()) {
                            $the_query->the_post();
                            $postId = $post->ID;
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
                                <div class="featured-post">
                                    <?php _e( 'Featured post', 'twentytwelve' ); ?>
                                </div>
                                <?php endif; ?>
                                <header class="entry-header">
                                    <?php the_post_thumbnail(); ?>
                                    <?php if ( is_single() ) : ?>
                                    <h1 class="entry-title"><?php the_title(); ?></h1>
                                    <?php else : ?>
                                    <h1 class="entry-title">
                                            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                                    </h1>
                                    <?php endif; // is_single() ?>
                                    <div class="event-data">
                                        <p>
                                            <?php
                                            am_the_startdate('Y-m-d H:i', 'Start date: ', '<br/>');
                                            am_the_enddate('Y-m-d H:i', 'End date: ', '<br/>');

                                            echo 'Categories: ' . am_get_the_event_category_list(',', 'multiple') . '<br/>';
                                            echo 'Venues: ' . am_get_the_venue_list(',', 'multiple');
                                            ?>
                                        </p>
                                    </div>
                                    <?php if ( comments_open() ) : ?>
                                        <div class="comments-link">
                                            <?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentytwelve' ) . '</span>', __( '1 Reply', 'twentytwelve' ), __( '% Replies', 'twentytwelve' ) ); ?>
                                        </div><!-- .comments-link -->
                                    <?php endif; // comments_open() ?>
                                </header><!-- .entry-header -->

                                <?php if ( is_search() ) : // Only display Excerpts for Search ?>
                                <div class="entry-summary">
                                        <?php the_excerpt(); ?>
                                </div><!-- .entry-summary -->
                                <?php else : ?>
                                <div class="entry-content">
                                        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
                                        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
                                </div><!-- .entry-content -->
                                <?php endif; ?>

                                <footer class="entry-meta">
                                    <?php twentytwelve_entry_meta(); ?>
                                    <?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
                                    <?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
                                        <div class="author-info">
                                            <div class="author-avatar">
                                                <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentytwelve_author_bio_avatar_size', 68 ) ); ?>
                                            </div><!-- .author-avatar -->
                                            <div class="author-description">
                                                <h2><?php printf( __( 'About %s', 'twentytwelve' ), get_the_author() ); ?></h2>
                                                <p><?php the_author_meta( 'description' ); ?></p>
                                                <div class="author-link">
                                                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                                                        <?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentytwelve' ), get_the_author() ); ?>
                                                    </a>
                                                </div><!-- .author-link	-->
                                            </div><!-- .author-description -->
                                        </div><!-- .author-info -->
                                    <?php endif; ?>
                                </footer><!-- .entry-meta -->
                            </article><!-- #post -->
                    <?php
                        }
                    }
                    ?>

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
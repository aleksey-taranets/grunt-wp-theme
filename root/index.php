<?php get_header(); ?>
<section>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <em class="author">by <?php the_author(); ?>, <?php the_time('d.m.Y') ?></em>
                <?php the_content('Подробнее...'); ?>
            </article>
        <?php endwhile; ?>
        <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?>
    <?php else : ?>
        <?php get_template_part( 'templates/not-found' ); ?>
    <?php endif; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

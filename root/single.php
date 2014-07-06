<?php get_header(); ?>
<section>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </article>
            <?php comments_template(); ?>
        <?php endwhile; ?>
    <?php else : ?>
        <?php get_template_part( 'templates/not-found' ); ?>
    <?php endif; ?>
</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

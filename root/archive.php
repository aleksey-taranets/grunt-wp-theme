<?php get_header(); ?>
	<section>
        <?php get_template_part( 'templates/breadcrumbs' ); ?>
		<?php if (have_posts()) : ?>
			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
			<?php /* If this is a category archive */ if (is_category()) { ?>
			<h1>Рубрика статей "<?php single_cat_title(); ?>"</h1>
			<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
			<h1>Метка статей "<?php single_tag_title(); ?>"</h1>
			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<h1>Архив <?php the_time('F jS, Y'); ?></h1>
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h1>Архив <?php the_time('F, Y'); ?></h1>
			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h1>Архив <?php the_time('Y'); ?></h1>
			<?php /* If this is an author archive */ } elseif (is_author()) { ?>
			<h1>Авторский архив</h1>
			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h1>Архив статей</h1>
			<?php } while (have_posts()) : the_post(); ?>
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

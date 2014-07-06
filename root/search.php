<?php get_header(); ?>
<div id="container">
	<div id="content">
		<?php if (have_posts()) : ?>
			<h1>Результат поиска</h1>
			<?php while (have_posts()) : the_post(); ?>
				<div class="block" id="post-<?php the_ID(); ?>">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<em class="author">by <?php the_author(); ?>, <?php the_time('d.m.Y') ?></em>
					<?php the_content('Подробнее...'); ?>
				</div>
			<?php endwhile; ?>
			<div class="navigation">
				<div class="next"><?php next_posts_link('Старые статьи &raquo;') ?></div>
				<div class="prev"><?php previous_posts_link('&laquo; Новые статьи') ?></div>
			</div>
		<?php else : ?>
			<div class="block">
				<h2>Не найдено</h2>
				<p>Попробуйте другой запрос:</p>
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>
	</div> 
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
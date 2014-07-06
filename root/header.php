<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="page">
		<header>
            <strong><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></strong>
				<?php
					if ( has_nav_menu( 'main-menu' ) ) {
						$nav_args = array(
							'container'       => false, 
							'menu_class'      => '', 
							'menu_id'         => 'nav',
							'link_before'          => '<span><em>',
							'link_after'           => '</em></span>',
							'theme_location'  => 'main-menu'
						);
						wp_nav_menu($nav_args);	
					}
				?>
		</header>


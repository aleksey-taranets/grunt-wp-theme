<?php
function the_breadcrumb() {
    global $post;
    $sep = '<li class="separator"> / </li>';
    echo '<ul id="breadcrumbs">';
    if (!is_home()) {
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
        echo 'Главная';
        echo '</a></li>'.$sep;
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li>'.$sep.'<li> ');
            if (is_single()) {
                echo '</li>'.$sep.'<li>';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<li><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li>' . $sep ;
                }
                echo $output;
                echo '<strong title="'.$title.'"> '.$title.'</strong>';
            } else {
                echo '<li>'.get_the_title().'</li>';
            }
        }
    }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"<li>Архивы за "; the_time('F jS, Y'); echo'</li>';}
    elseif (is_month()) {echo"<li>Архивы за "; the_time('F, Y'); echo'</li>';}
    elseif (is_year()) {echo"<li>Архивы за "; the_time('Y'); echo'</li>';}
    elseif (is_author()) {echo"<li>Архивы автора"; echo'</li>';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Архивы блога"; echo'</li>';}
    elseif (is_search()) {echo"<li>Результаты поиска"; echo'</li>';}
    echo '</ul>';
}
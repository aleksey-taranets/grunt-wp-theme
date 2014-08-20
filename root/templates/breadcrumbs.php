<?php if(!is_front_page() && function_exists('bcn_display_list')) {
    echo '<ul class="breadcrumb">';
    bcn_display_list();
    echo '</ul>';
}
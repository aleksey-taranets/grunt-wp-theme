<?php if(!is_front_page() && function_exists('the_breadcrumb')) {
    the_breadcrumb();
}
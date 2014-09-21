<?php
/**
 * Adds Foo_Widget widget.
 */
class Comment_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'comment_widget', // Base ID
            'Случайный отзыв', // Name
            array( 'description' => __( 'Случайный отзыв с определенной страницы', 'text_domain' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $page_id = $instance['page_id'];

        $comments = get_comments("post_id=".$page_id."&status=approve");

        if ($page_id && $comments) {
            echo $before_widget;
            if ( ! empty( $title ) )
                echo $before_title . $title . $after_title;
            ?>
            <div>
                <?php
                $ndx = mt_rand(1,sizeof($comments)) - 1;
                $comment = $comments[$ndx];
                ?>
                <span class="data"><?= date("d.m.y", strtotime($comment->comment_date)) ?></span>
                <span class="name"><?= $comment->comment_author ?>:</span>
                <p><?= apply_filters( 'comment_text', $comment->comment_content); ?></p>
                <div class="at-bottom">
                    <a href="<?php get_the_permalink($page_id); ?>" class="button">Все отзывы</a>
                </div>
            </div>
            <?php
            echo $after_widget;
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['page_id'] = strip_tags( $new_instance['page_id'] );
        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        $val = '';
        if ( isset( $instance[ 'page_id' ] ) ) {
            $val = $instance[ 'page_id' ];
        }
        // Pull all the pages into an array
        $options_pages = array();
        $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
        $options_pages[''] = 'Выберите страницу';
        foreach ($options_pages_obj as $page) {
            $options_pages[$page->ID] = $page->post_title;
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php _e( 'Страница отзывов:' ); ?></label>
            <?php
            $output = '<select class="widefat" name="' . $this->get_field_name( 'page_id' ) . '" id="' . $this->get_field_id( 'page_id' ) . '">';

            foreach ($options_pages as $key => $option ) {
                $selected = '';
                if ( $val != '' ) {
                    if ( $val == $key) { $selected = ' selected="selected"';}
                }
                $output .= '<option'. $selected .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
            }
            $output .= '</select>';
            echo $output;
            ?>
        </p>
    <?php
    }
}

// register Foo_Widget widget
function register_my_widget() {
    register_widget( 'comment_widget' );
}
add_action( 'widgets_init', 'register_my_widget' );

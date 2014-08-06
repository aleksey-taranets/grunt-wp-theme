<?php
/**
 * Adds Foo_Widget widget.
 */
class AlirtaPosts_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'alirtaposts_widget', // Base ID
            'Статьи', // Name
            array( 'description' => __( 'Виджет статей', 'text_domain' ), ) // Args
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
        $archiveLinkEn = $instance['archive_link'];
        $archiveLinkText = $instance['archive_link_text'] ? $instance['archive_link_text'] : 'Статьи';
        $num = $instance['num'] ? $instance['num'] : 3;
        $cat = $instance['cat'];

        $args = array(
            'posts_per_page' => $num,
            'status' => 'published'
        );

        if ($cat) {
            $args['cat'] = $cat;
        }

        query_posts($args);
        if (have_posts()) {

            if ($archiveLinkEn) {
                $href = $cat ? get_category_link($cat) : get_post_type_archive_link('post');
                $archiveLink = '<a class="link" href="'.$href.'">'.$archiveLinkText.'</a>';
            } else {
                $archiveLink = '';
            }

            echo $before_widget;
            if ( ! empty( $title ) )
                echo $before_title . $title . $archiveLink . $after_title;

            ?>
            <ul class="news">
                <?php while (have_posts()) : the_post(); ?>
                    <li>
                        <span class="data"><?php the_time('d.m.Y'); ?>г.</span>
                        <h4><a href="#"><?php the_title(); ?></a> </h4>
                        <?php the_excerpt(); ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php
            echo $after_widget;
        }
        wp_reset_query();

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
        $instance['num'] = (int)$new_instance['num'];
        $instance['cat'] = (int)$new_instance['cat'];
        $instance['archive_link'] = $new_instance['archive_link'];
        $instance['archive_link_text'] = $new_instance['archive_link_text'];
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
        if ( isset( $instance[ 'archive_link_text' ] ) ) {
            $archiveLinkText = $instance[ 'archive_link_text' ];
        }
        if ( isset( $instance[ 'num' ] ) ) {
            $numVal = $instance[ 'num' ];
        } else {
            $numVal = 3;
        }
        $nums = array(1,2,3,4,5,6,7,8,9);

        // Pull all the categories into an array
        $options_categories = array();
        $options_categories_obj = get_categories();
        $options_categories[''] = 'Выберите категорию';
        foreach ($options_categories_obj as $category) {
            $options_categories[$category->cat_ID] = $category->cat_name;
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'num' ); ?>"><?php _e( 'Кол-во статей:' ); ?></label>
            <?php
            $output = '<select class="widefat" name="' . $this->get_field_name( 'num' ) . '" id="' . $this->get_field_id( 'num' ) . '">';
            foreach ($nums as $num ) {
                $output .= '<option '.selected( $numVal, $num , false).' value="' . esc_attr( $num ) . '">' . esc_html( $num ) . '</option>';
            }
            $output .= '</select>';
            echo $output;
            ?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Категория:' ); ?></label>
            <?php
            $output = '<select class="widefat" name="' . $this->get_field_name( 'cat' ) . '" id="' . $this->get_field_id( 'cat' ) . '">';
            foreach ($options_categories as $catId => $catTitle ) {
                $output .= '<option '.selected( $instance[ 'cat' ], $catId , false).' value="' . esc_attr( $catId ) . '">' . esc_html( $catTitle ) . '</option>';
            }
            $output .= '</select>';
            echo $output;
            ?>
        </p>
        <p>
            <input class="checkbox" type="checkbox" name="<?php echo $this->get_field_name('archive_link'); ?>" id="<?php echo $this->get_field_id('archive_link'); ?>" value="true" <?php checked('true', $instance['archive_link']);?> />
            <label for="<?php echo $this->get_field_id('archive_link'); ?>"> <?php _e('Ссылка на архив'); ?></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'archive_link_text' ); ?>"><?php _e( 'Текст ссылки:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'archive_link_text' ); ?>" name="<?php echo $this->get_field_name( 'archive_link_text' ); ?>" type="text" value="<?php echo esc_attr( $archiveLinkText ); ?>" />
        </p>
    <?php
    }
}

// register Foo_Widget widget
function register_my_widget() {
    register_widget( 'alirtaposts_widget' );
}
add_action( 'widgets_init', 'register_my_widget' );
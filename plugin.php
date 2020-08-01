<?php

class Givinggrid_Widget extends WP_Widget {

  public function __construct() {
    $widget_options = array( 'classname' => 'givinggrid_widget', 'description' => 'This is the Giving Grid Widget' );
    parent::__construct( 'givinggrid_widget', 'Giving Grid Widget', $widget_options );
  }

  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance[ 'title' ] );
    $givinggrid_id = $instance[ 'givinggrid_id' ];
    $blog_title = get_bloginfo( 'name' );
    $tagline = get_bloginfo( 'description' );

    echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; ?>

    <div id="givinggrid-widget" data-gid="<?php echo $givinggrid_id ?>" data-wol="0"></div>

    <?php echo $args['after_widget'];
  }

  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $givinggrid_id = ! empty( $instance['givinggrid_id'] ) ? $instance['givinggrid_id'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label> <br/>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'givinggrid_id' ); ?>">Giving Grid ID:</label><br/>
      <input type="number" id="<?php echo $this->get_field_id( 'givinggrid_id' ); ?>" name="<?php echo $this->get_field_name( 'givinggrid_id' ); ?>" value="<?php echo esc_attr( $givinggrid_id ); ?>" />
    </p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    $instance[ 'givinggrid_id' ] = strip_tags( $new_instance[ 'givinggrid_id' ] );
    return $instance;
  }

}

function gg_widget_enqueue_scripts() {

    wp_register_script( 'givinggrid-js', 'https://www.givinggrid.com/g/gin.js', array(), null, true );
    wp_enqueue_script( 'givinggrid-js' );
}
add_action( 'wp_enqueue_scripts', 'gg_widget_enqueue_scripts' );

function register_givinggrid_widget() {
  register_widget( 'Givinggrid_Widget' );
}
add_action( 'widgets_init', 'register_givinggrid_widget' );

?>

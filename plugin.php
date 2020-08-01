<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Givinggrid_Widget extends WP_Widget {

  public function __construct() {
    parent::__construct( 'givinggrid_widget',
                         'Giving Grid Widget',
                         array( 'classname' => 'givinggrid_widget',
                                'description' => 'This is the Giving Grid Widget' ) );

    add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
  }

  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance[ 'title' ] );
    $givinggrid_id = $instance[ 'givinggrid_id' ];
    $blog_title = get_bloginfo( 'name' );
    $tagline = get_bloginfo( 'description' );

    echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
    echo <<<"EOT"

    <div id="givinggrid-widget" data-gid="{$givinggrid_id}" data-wol="0"></div>
EOT;
    echo $args['after_widget'];
  }

  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
    $givinggrid_id = ! empty( $instance['givinggrid_id'] ) ? $instance['givinggrid_id'] : '';
    $attr_title = esc_attr( $title );
    $title_id = $this->get_field_id( 'title' );
    $title_name = $this->get_field_name( 'title' );
    $gg_id = $this->get_field_id( 'givinggrid_id' );
    $gg_id_name = $this->get_field_name( 'givinggrid_id' );
    $attr_gg_id = esc_attr( $givinggrid_id );
    echo <<<"EOT"
    <p>
      <label for="{$title_id}">Title:</label> <br/>
      <input type="text" id="{$title_id}" name="{$title_name}" value="{$attr_title}" />
    </p>
    <p>
      <label for="{$gg_id}">Giving Grid ID:</label><br/>
      <input type="number" id="{$gg_id}" name="{$gg_id_name}" value="{$attr_gg_id}" />
    </p>
EOT;
  }

  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    $instance[ 'givinggrid_id' ] = strip_tags( $new_instance[ 'givinggrid_id' ] );
    return $instance;
  }

  public function register_scripts() {
      wp_register_script( 'givinggrid-js', 'https://www.givinggrid.com/g/gin.js', array(), null, true );
      wp_enqueue_script( 'givinggrid-js' );
  }

}

add_action( 'widgets_init', function() {
    register_widget( 'Givinggrid_Widget' );
});

?>

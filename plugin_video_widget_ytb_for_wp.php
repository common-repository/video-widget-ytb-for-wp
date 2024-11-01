<?php
/**
* Plugin Name: [Enqtran] Video Widget YTB For WP
* Plugin URI: http://enqtran.com/
* Description: [Enqtran] Video Widget YTB For WP
* Author: enqtran
* Version: 1.0
* Author URI: http://enqtran.com/
* Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EU3YV2GB9434U
* License: GPLv3
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
* Tags: enqtran, enq, enqpro, youtube, widget, video, custom, css, plugin
*/

/*
* register function plugin
* Last update: 09/12/2015
*/
add_action( 'widgets_init', 'youtube_enqtran_widget' );
if ( !function_exists('youtube_enqtran_widget') ) {
	function youtube_enqtran_widget() {
		register_widget('Youtube_Enqtran_Widget');
	}
}
class Youtube_Enqtran_Widget extends WP_Widget {

/**
 * config widget
 */
function __construct() {
	$widget_ops = array(
            'youtube_enqtran_widget',
			'description'=>'[Enqtran] Video Widget YTB For WP'
        );
	 parent::__construct( '', '[Enqtran] Video Widget YTB For WP', $widget_ops );
}

/**
 * [form admin]
 */
function form( $instance ){
	$defaults = array(
			'title' => '',
			'link' => '',
			'width' => '',
			'height' => '',
			'autoplay' => 'off',
			'ytb_caption' => '',
			'customs_css' => ''
			);
	$instance = wp_parse_args( $instance, $defaults );
	$title = esc_attr($instance['title']);
	$link = esc_attr($instance['link']);
	$width = esc_attr($instance['width']);
	$height = esc_attr($instance['height']);
	$autoplay = esc_attr($instance['autoplay']);
	$customs_css = esc_attr($instance['customs_css']);
	$ytb_caption = esc_attr($instance['ytb_caption']);
?>
<!-- show form admin -->
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
	</p>
	<p>
		<input type="text" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" placeholder="Title for Widget">
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Youtube Link ' ); ?></label>
	</p>
	<p>
		<input type="text" class="widefat" name="<?php echo $this->get_field_name('link'); ?>" value="<?php echo $link; ?>" placeholder="Youtube Link Video">
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'width' ); ?>"><?php _e( 'Width' ); ?></label>
	</p>
	<p>
		<input type="text" class="widefat" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $width; ?>" placeholder="Width Video">
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'width' ); ?>"><?php _e( 'Height' ); ?></label>
	</p>
	<p>
		<input type="text" class="widefat" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $height; ?>" placeholder="Height Video">
	</p>
</div>
<div class="box-w">
	<p>
		<input type="checkbox" name="<?php echo $this->get_field_name('autoplay'); ?>" <?php checked($instance['autoplay'], 'on');?> />
		<label for="<?php echo $this->get_field_name( 'autoplay' ); ?>"><?php _e( 'AutoPlay' ); ?></label>
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'ytb_caption' ); ?>"><?php _e( 'Caption' ); ?></label>
	</p>
	<p>
		<textarea class="widefat" name="<?php echo $this->get_field_name('ytb_caption'); ?>"><?php echo $ytb_caption; ?></textarea>
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'customs_css' ); ?>"><?php _e( 'Custom css' ); ?></label>
	</p>
	<p>
		<textarea class="widefat" name="<?php echo $this->get_field_name('customs_css'); ?>" placeholder=".ytb_caption{ //css here; }"><?php echo $customs_css; ?></textarea>
	</p>
</div>

<div class="box-w">
	<p>Default null don't show</p>
</div>


<?php
}

/*
* [update]
*/
function update( $new_instance, $old_instance ) {
	$instance = $old_instance;
	$instance['title'] = esc_attr($new_instance['title']);
	$instance['link'] = esc_attr($new_instance['link']);
	$instance['width'] = esc_attr($new_instance['width']);
	$instance['height'] = esc_attr($new_instance['height']);
	$instance['autoplay'] = esc_attr($new_instance['autoplay']);
	$instance['customs_css'] = esc_attr($new_instance['customs_css']);
	$instance['ytb_caption'] = esc_attr($new_instance['ytb_caption']);
	return $instance;
}

/**
* [widget content]
*/
function widget( $args, $instance ) {
	extract($args);
	$title = apply_filters( 'widget_title', $instance['title'] );
	$autoplay = $instance['autoplay'] ? 'true' : 'false';
	$re_url = str_replace("watch?v=", "embed/", $instance['link']);
	echo $before_widget;
	if ( !empty( $title ) ) {
		echo $before_title;
		echo $title;
		echo $after_title;
	} ?>
	<div class="content-sidebar-widget">
		<div class="youtube_enqtran_plugin">
			<iframe
			width="<?php echo ($instance['width']) ? $instance['width'] : '100%' ; ?>" 
			height="<?php echo ($instance['height']) ? $instance['height'] : 'auto' ; ?>" 
			src="<?php echo $re_url; ?><?php if('on' == $instance['autoplay'] ) { echo "?autoplay=1"; } ?>"
			frameborder="0" allowfullscreen  >
			</iframe>
			<?php if ( isset($instance['ytb_caption']) ) : ?>
				<div class="ytb_caption">
					<?php echo $instance['ytb_caption']; ?>
				</div>
			<?php endif; ?>
			<style>
				<?php echo $instance['customs_css']; ?>
				@media only screen and (min-width: 320px) and (max-width: 768px) {
					.youtube_enqtran_plugin iframe {
				        max-width: 100%;
				        height: auto;
			    	}
				}
			</style>
		</div>
	</div>
<?php
	echo $after_widget;
	}
}
// End Plugin Youtube Video Widget

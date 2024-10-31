<?php
/*  Copyright 2013 Xplore, Inc. 

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/*
Plugin Name: Tellmequotes Widget
Plugin URI: http://www.tellmequotes.com/link/wordpress_plugin.html
Description: Show a quote of the day in your site's sidebar. To install, click activate and then go to Appearance > Widgets and look for the 'Tellmequotes Widget'. Next, drag the widget to your sidebar.
Version: 1.6
Author: Tellmequotes
Author URI: http://www.tellmequotes.com
*/

/**
 * Adds Tellmequotes_Widget widget.
 */
class TellmeQuotes_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			__('TellmeQuotes Widget', 'text_domain'), // Name
			array( 'description' => __( 'Display a quote of the day in your blog.', 'text_domain' ), ) // Args
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
		$qtype = apply_filters( 'widget_title', $instance['qtype'] );

                $title_hash = array(
                     "dailyquote" => "Quote of the Day"

                 );

		echo $args['before_widget'];
		if ( ! empty( $qtype) )
			echo $args['before_title'] . $title_hash[$qtype]. $args['after_title'];
		echo __( '<script type="text/javascript" src="http://www.tellmequotes.com/js/'.$qtype.'.js"></script><small><i><a href="http://www.tellmequotes.com?utm_source=wordpress_onsite&utm_medium=feeds&utm_campaign=' . $qtype . '" target="_blank">More Quotes</a></i></small>', 'text_domain' );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'qtype' ] ) ) {
			$qtype = $instance[ 'qtype' ];
		}
		else {
			$qtype = "qotd";
		}
		?>
	         <p>
			<label for="<?php echo $this->get_field_id( 'qtype' ); ?>">What type of quotes would you like?</label> 
			<select id="<?php echo $this->get_field_id( 'qtype' ); ?>" name="<?php echo $this->get_field_name( 'qtype' ); ?>" class="widefat" style="width:100%;">
				<option value="dailyquote" <?php if ( 'dailyquote' == $qtype ) echo 'selected="selected"'; ?>>Quote of the Day</option>
			</select>
		</p>
		<?php 
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
		$instance['qtype'] = ( ! empty( $new_instance['qtype'] ) ) ? strip_tags( $new_instance['qtype'] ) : '';

		return $instance;
	}

} // class TellmeQuotes_Widget

// register TellmeQuotes_Widget widget
function register_foo_widget() {
    register_widget( 'TellmeQuotes_Widget' );
}
add_action( 'widgets_init', 'register_foo_widget' );
?>

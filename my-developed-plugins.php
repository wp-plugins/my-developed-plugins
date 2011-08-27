<?php
/*
Plugin Name: My developed plugins
Plugin URI: http://www.tammax.it
Description: You are a developer of plugins for wordpress? Check how many downloads were made on your work.
Author: tammax
Version: 1.0
Author URI: http://www.tammax.it



Copyright 2011  tammax  (tammax@tammax.it)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


class mydevelopedplugins extends WP_Widget {
    
    function mydevelopedplugins() {
        parent::WP_Widget(false, $name = 'My developed plugings', array('description' => __('Use this widget to list your plugins that you\'ve developed and that are present in the official directory of wordpress')));
    }
	
    function widget($args, $instance) {		
        extract( $args );
		
        $title = apply_filters('widget_title', $instance['title']);
		$devname = apply_filters('widget_title', $instance['devname']);
		$limit_view = apply_filters('widget_title', $instance['limit_view']);
        echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		require_once('simple_html_dom.php');
    
		$html = file_get_html('http://profiles.wordpress.org/users/'. __($devname).'/');

		foreach($html->find('div#main-plugins') as $aul) {
		
			$aul->find('ul', 0)->id = 'mwp_ul';
		
			
			foreach( $aul->find('.clearer') as $adiv) {

				$adiv->outertext = '';	
				
			}			
			
			foreach( $aul->find('li') as $mul=>$ali) {
				
				if ($mul <= $limit_view-1)  {
						$ali->class = $mul;	
				}else{
					$ali->outertext = "";
				}
				
			}
					
			foreach( $aul->find('h3') as $ah3) {

				$ah3->class = 'mwp_h3';	
				
			}
			
			foreach( $aul->find('span') as $aspan) {

				$aspan->class = 'mwp_span';	
				
			}
			


			
			foreach($aul->find('h4') as $ah4) {

				$ah4->outertext = '';
	
			}
			echo $aul->outertext;
		}
		
		echo $after_widget;
		$html->clear(); 
		unset($html);
    }
	
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['devname'] = strip_tags($new_instance['devname']);
	$instance['limit_view'] = strip_tags($new_instance['limit_view']);
	
        return $instance;
    }
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$devname = esc_attr( $instance[ 'devname' ] );
			$limit_view = esc_attr( $instance[ 'limit_view' ] );
		}
		else {
			$title = __( 'New title', 'text_domain' );
			$devname = __( 'New name', 'text_domain' );
			$limit_view = __( '5', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('devname'); ?>"><?php _e('Developer name:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('devname'); ?>" name="<?php echo $this->get_field_name('devname'); ?>" type="text" value="<?php echo $devname; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('limit_view'); ?>"><?php _e('Max plugings to show:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('limit_view'); ?>" name="<?php echo $this->get_field_name('limit_view'); ?>" type="text" value="<?php echo $limit_view; ?>" />
		</p>
		<?php 
	}
} 

add_action('widgets_init', create_function('', 'return register_widget("mydevelopedplugins");'));




/*contenuto della dashboard*/
function custom_dashboard_help() {

$widget_options = MainFunction_Options();

$dev_name = $widget_options['developer'];

$illimite = $widget_options['limitview'];


 include('simple_html_dom.php');
    
    # this is the global array we fill with article information
  
    $html = file_get_html('http://profiles.wordpress.org/users/'.__($dev_name).'/');

	//echo $html;
	

		
		foreach($html->find('div#main-plugins') as $aul) {
		
			$aul->find('ul', 0)->id = 'mwp_ul';
		
			$aul->find('ul', 0)->style = 'margin:10px 0 10px 10px';
			/* foreach( $aul->find('.clearer') as $adiv) {

				$adiv->outertext = '';	
				
			}			
			 */
			foreach( $aul->find('li') as $mul=>$ali) {
				
				if ($mul <= $illimite-1)  {
						$ali->class = $mul;	
				}else{
					$ali->outertext = "";
				}
				
			}
					
			foreach( $aul->find('h3') as $ah3) {

				$ah3->class = 'mwp_h3';	
				$ah3->style = 'background-image:none; border-bottom:1px solid #CECECE; background-color:transparent; margin:15px 0 9px 0; ';
			}
			
			foreach( $aul->find('a') as $aa) {
				
				$aa->style = 'text-decoration:none;';
			}
			
			
			
			foreach( $aul->find('span') as $aspan) {

				$aspan->class = 'mwp_span';	
				$aspan->style = 'margin:10px 0 10px 25px';
			}
			


			
			foreach($aul->find('h4') as $ah4) {

				$ah4->outertext = '';
	
			}
			
			echo $aul->outertext;
		}
		
		

}


/**
 * add Dashboard Widget via function wp_add_dashboard_widget()
 */
function my_custom_dashboard_widgets() {
	wp_add_dashboard_widget('custom_dashboard_help', 'My plugins hosted on wordpress', 'custom_dashboard_help', 'custom_dashboard_help_setup' );
}

function MainFunction_Options() {
	$defaults = array( 'developer' => '', 'limitview' => 5);
	if ( ( !$options = get_option( 'custom_dashboard_help' ) ) || !is_array($options) )
		$options = array();
	return array_merge( $defaults, $options );
}

function custom_dashboard_help_setup() {
 	$options = MainFunction_Options();
 	if ( 'post' == strtolower($_SERVER['REQUEST_METHOD']) && isset( $_POST['widget_id'] ) && 'custom_dashboard_help' == $_POST['widget_id'] ) {
		foreach ( array( 'developer', 'limitview' ) as $key )
				$options[$key] = $_POST[$key];
		update_option( 'custom_dashboard_help', $options );
	}
 ?>
 		<label for="developer">
			<?php _e('Developer name', 'custom_dashboard_help' ); ?>
			<input id="developer" name="developer" type="text" value="<?php echo $options['developer']; ?>" />
		</label>
		<br /><br />
		<label for="limitview">
			<?php _e('Max items to show', 'custom_dashboard_help' ); ?>
			<input id="limitview" name="limitview" type="text" value="<?php echo $options['limitview']; ?>" />
		</label> 
<?php
 }
/**
 * use hook, to integrate new widget
 */
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

?>
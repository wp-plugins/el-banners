<?php
/*
Plugin Name: EL Banners
Plugin URI: http://english-learner.tk/el-banners-plugin/
Description: This plugin allow you to create widgets which will show banners, links or any other code from specified folder or file into sidebar automatically
Author: english-learner
Author URI: http://english-learner.tk/
Version: 0.2
Disclaimer: Use at your own risk. No warranty expressed or implied is provided.

Copyright 2011  english-learner  (email : englishhlearner@gmail.com)
 
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
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

//namespace elbanners;

class elbanners_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
			'elbanners-widget', 'EL Banners',
			array(
				'description' => 'Add banners into sidebars',
				'classname' => 'elbanners'
			),
			array('id_base' => 'elbanners-widget')
		);
		$this->elbanners_options = array(
			'title' => 
				array(
					'default' => '',
					'description' => 'Widget title',
					'html' => false
				),
			'banners_path' =>
				array(
					'default' => dirname(__FILE__).'/banners/',
					'description' => 'Banners path',
					'html' => false
				),
			'container' => 
				array(
					'default' => '<ul>%_BANNERS_%</ul>',
					'description' => 'Template for banners container',
					'html' => true
				),
			'banner' => 
				array(
					'default' => '<li>%_BANNER_%</li>',
					'description' => 'Template for banner',
					'html' => true
				),
		);
	}

	function widget( $args, $instance ) {
		extract( $args );
		$instance = $this->test_instance($instance);
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if(!empty($title))
			echo $before_title . $title . $after_title;
		$path = str_replace('\\', '/', $instance['banners_path']);
		$banners = array();
		if(is_dir($path))
		{
			if($path[strlen($path) - 1] != '/')
				$path .= '/';
			if(($dh = @opendir($path)) !== false)
			{
				while (($file = @readdir($dh)) !== false)
					if($file != '.' && $file != '..')
					{
						$banner = @file_get_contents($path.$file);
						if($banner !== false)
							array_push($banners, $banner);
					}
				@closedir($dh);
			}
		}
		else
		{
			$f = @fopen($path, 'r');
			if($f !== false)
			{
				$banner = '';
				while(!feof($f))
				{
					$s = rtrim(fgets($f), "\r\n");
					if(!empty($s))
						$banner .= $s . "\n";
					else if(!empty($banner))
					{
						array_push($banners, $banner);
						$banner = '';
					}
				}
				fclose($f);
				if(!empty($banner))
					array_push($banners, $banner);
			}
		}
		$banners_html = '';
		foreach($banners as $banner)
			$banners_html .= str_replace('%_BANNER_%', $banner, $instance['banner']);
		echo str_replace('%_BANNERS_%', $banners_html, $instance['container']);
		echo $after_widget;
	}

	function test_instance($instance)
	{
		foreach($this->elbanners_options as $key => $option)
			if(!isset($instance[$key]) || empty($instance[$key]))
				$instance[$key] = $option['default'];
		return $instance;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		foreach($this->elbanners_options as $key => $option)
		{
			if(!$option['html'])
				$instance[$key] = strip_tags($new_instance[$key]);
			else if(current_user_can('unfiltered_html'))
				$instance[$key] = $new_instance[$key];
			else
				$instance[$key] = stripslashes(wp_filter_post_kses(addslashes($new_instance[$key])));
			if(empty($instance[$key]))
				$instance[$key] = $option['default'];
		}
		return $instance;
	}

	function form($instance)
	{
		foreach($this->elbanners_options as $name => $option)
		{
			$field_id = $this->get_field_id($name);
			$field_name = $this->get_field_name($name);
			$value = esc_attr($instance ? $instance[$name] : $option['default']);
?>
<p>
<label for="<?php echo $field_id; ?>"><?php echo $option['description']; ?></label> 
<input class="widefat" id="<?php echo $field_id; ?>" name="<?php echo $field_name; ?>" type="text" value="<?php echo $value; ?>">
</p>
<?php
		}
	}

	private $elbanners_options;

} // class elbanners_widget

add_action( 'widgets_init', create_function( '', 'register_widget("elbanners_widget");' ) );

//add_action('widgets_init', function(){ return register_widget('elbanners\elbanners_widget'); });


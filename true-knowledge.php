<?php
/*
Plugin Name: True Knowledge Direct Answer Widget
Plugin URI: http://www.robstacey.com/true-knowledge-wordpress-widget
Description: Allows asking questions of the True Knowledge Direct Answer API.
Version: 0.1
Author: Rob Stacey
Author URI: http://www.robstacey.com

    Copyright 2009  Rob Stacey  (email : rob@robstacey.com)

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

// Register the widget
add_action("widgets_init", array('true_knowledge_widget', 'register'));

// Register the activation/deactivation hooks to setup options
register_activation_hook( __FILE__, array('true_knowledge_widget', 'activate'));
register_deactivation_hook( __FILE__, array('true_knowledge_widget', 'deactivate'));

/**
 * Widget class
 */
class true_knowledge_widget {

  	/**
  	 * Setup the option.
  	 */
  	function activate()
  	{
		$data = array( 'username' => '' ,'password' => '');
    	if ( ! get_option('tk_api_details')){
      		add_option('tk_api_details' , $data);
    	} else {
      		update_option('tk_api_details' , $data);
    	}
  	}
  
  	/**
  	 * Delete the options.
  	 */
  	function deactivate(){
    	delete_option('tk_api_details');
  	}

  	/**
  	 * Print the control panel to the screen.
  	 */
  	function control(){
    	$data = get_option('tk_api_details');
  		?>
  		<p><label>API User<input name="tk_api_username"
		type="text" value="<?php echo $data['username']; ?>" /></label></p>
  		<p><label>Password<input name="tk_api_password"
		type="password" value="<?php echo $data['password']; ?>" /></label></p>
    	<?php
     	if (isset($_POST['tk_api_username'])){
       		$data['username'] = attribute_escape($_POST['tk_api_username']);
       		$data['password'] = attribute_escape($_POST['tk_api_password']);
        	update_option('tk_api_details', $data);
		}
	}
  
	/**
	 * Print the widget to the screen.
 	 */
	function widget($args){
    	echo $args['before_widget'];
    	echo $args['before_title'] . '<a href="http://www.trueknowledge.com">Ask True Knowledge something!</a>' . $args['after_title'];
    	?>
		<p><input style="width:140px" id="tk_question" name="tk_question" type="text" /></p>
	    <div id="tk_answer"></div>
		<button id="tk_btnLoad">Ask!</button>
        
		<script type="text/javascript">
			function ask_tk_question() {
				
				// Put an animated GIF image insight of content
	                        jQuery("#tk_answer").empty().html('<img src="<?php echo get_option('siteurl')?>/wp-content/plugins/true-knowledge/loader.gif" />');
	
	                         // Make AJAX call
	                        var question = encodeURI(jQuery('#tk_question').val());
	
				jQuery.get("<?php echo get_option('siteurl')?>/wp-content/plugins/true-knowledge/ajax.php?question=" + question, function(data){
	  				
					var status = jQuery(data).find('tk\\:status').text(); // search all 
					var answer = '';

					if(status != 'error'){
						answer = jQuery(data).find('tk\\:text_result').text();
					}else{
						if(jQuery(data).find('tk\\:error_code').text() == 'ambiguous'){
							answer = 'The question was to ambiguous, try being more specific';
						}
					}

					if(status == 'error' && answer == '')
					{
						answer = 'TK didn\'t understand the question, try a different wording';
					}
					else if(answer == '')
					{
						answer = 'TK understood but it didn\'t have any answers';
					}
	
					jQuery('#tk_answer').empty().html('<a href="' + jQuery(data).find('tk\\:tk_question_url').text() + '">' + answer + '</a>');
					
				});
			}
			jQuery("#tk_question").keypress(function(key){
				if(key.which == 13)
				{
					ask_tk_question();
				}
			});
			jQuery("#tk_btnLoad").click(function(){
	
	  			ask_tk_question();
			});
		</script>
    	<?php
    	echo $args['after_widget'];
	}
  
	/**
	 * Register the Widget with the Wordpress system.
	 */
	function register(){
    	register_sidebar_widget('True Knowledge', array('true_knowledge_widget', 'widget'));
    	register_widget_control('True Knowledge', array('true_knowledge_widget', 'control'));
	}
}

?>
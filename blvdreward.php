<?php 
/*
Plugin Name: Blvd Media accessTool
Plugin URI: http://blvd-media.com
Description: Gives blvd-media users access to over 500 offers available on blvd-media via the accessTool widget.
Author: Blvd-Media
Version: 1.0.1
Author URI: http://blvd-media.com
*/	

function blvdmedia_at_widget($content) {
	$blvdmedia_load 	= get_option('blvdmedia_load', 'loadall');
	$blvdmedia_pub_id 	= get_option('blvdmedia_pub_id', '1');
	$blvdmedia_status 	= get_option('blvdmedia_status', 'disabled');
	$blvdmedia_remove 	= get_option('blvdmedia_remove', 'yes');
	if ( !is_admin() ) {
		if ($blvdmedia_status == "enabled") {
			if ($blvdmedia_load  == "loadindividual") {
			
				$blvd_html_var  = '';
				$blvd_html_var .= '<div style="margin:0;padding:0;position:fixed;width:100%;height:100%;" id="accessToolContainer">';
				$blvd_html_var .= '<div style="margin:0;padding:0;position:fixed;width:100%;height:100%;">';
				$blvd_html_var .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="myFlashContent"><param name="movie" value="http://www.blvd-media.com/AccessTool/AccessTool.swf"/>';
				$blvd_html_var .= '<param name="quality" value="high" />';
				$blvd_html_var .= '<param name="scale" value="ExactFit" />';
				$blvd_html_var .= '<param name="mode" value="transparent" />';
				$blvd_html_var .= '<param name="allowScriptAccess" value="always" />';
				$blvd_html_var .= '<object type="application/x-shockwave-flash" id="blvdflash" style="position:fixed;" data="http://www.blvd-media.com/AccessTool/AccessTool.swf" width="100%" height="100%"><param name="quality" value="high" />';
				$blvd_html_var .= '<param name="scale" value="ExactFit" />';
				$blvd_html_var .= '<param name="mode" value="transparent" />';
				$blvd_html_var .= '<param name="allowScriptAccess" value="always" />';
				$blvd_html_var .= '<div id="atOverlay" style="width:100%;height:100%;filter:alpha(opacity=70);-moz-opacity:70%;opacity:.7;">';
				$blvd_html_var .= '<a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />';
				$blvd_html_var .= '</a>';
				$blvd_html_var .= '</div>';
				$blvd_html_var .= '</object>';
				$blvd_html_var .= '</object>';
				$blvd_html_var .= '</div>';
				$blvd_html_var .= '</div>';
				if (is_singular()) {
				    $tag = '[blvdmedia tool=at]';
					$string_search = strpos($content, $tag);
					if ($string_search == true) {
						if(isset($_GET['pubid'])) { 
							$content = str_replace("[blvdmedia tool=at]", $blvd_html_var, $content);
							add_action('get_footer',
							function() {
							echo '
										<script type="text/javascript" src="http://www.blvd-media.com/AccessTool/accessTool.js"></script>
										<script type="text/javascript" src="http://www.blvd-media.com/AccessTool/swfobject.js"></script>
										<noscript><meta http-equiv=\'refresh\' content=\'0;url=http://www.blvd-media.com/nojava.html\' /></noscript>
										<style type="text/css">
										#blvdflash {
										margin: 0px;
										padding: 0px;
										position: absolute;
										top: 0px;
										left: 0px;
										right: 0px;
										z-index: 9999;
										}
										</style>';
							} 
							);
							
						} else {
						echo "pub id stored is : ".$blvdmedia_pub_id."";
						
						 // function redirect here
						 add_action('get_footer',
						 function() { 
						 $blvdmedia_pub_id 	= get_option('blvdmedia_pub_id', '1');
						 echo '
							<script type="text/javascript">
							var prefix = window.location;
							window.location = prefix + \'?pubid='.$blvdmedia_pub_id.'\';
							</script>';
						 }
						 );
						}
					} 		
				}
			}
			elseif ($blvdmedia_remove == "yes") {
				if (is_singular()) {
					$tag = '[blvdmedia tool=at]';
					$string_search = strpos($content, $tag);
					if ($string_search == true) {
						$content = str_replace("[blvdmedia tool=at]", " ", $content);
					}
				}				
			}
		}
		elseif ($blvdmedia_remove == "yes") {
			if (is_singular()) {
				$tag = '[blvdmedia tool=at]';
				$string_search = strpos($content, $tag);
				if ($string_search == true) {
					$content = str_replace("[blvdmedia tool=at]", " ", $content);
				}
			}				
		}
	}
	return $content;
}

add_filter( 'the_content', 'blvdmedia_at_widget' );

function blvd_at_ext_js() {
	if ( !is_admin() ) {
		$blvdmedia_status = get_option('blvdmedia_status', 'disabled');
		$blvdmedia_load   = get_option('blvdmedia_load', 'loadall');
		if ($blvdmedia_status == "enabled") {
			?>
<script type="text/javascript" src="http://www.blvd-media.com/AccessTool/accessTool.js"></script>
<script type="text/javascript" src="http://www.blvd-media.com/AccessTool/swfobject.js"></script>
<noscript><meta http-equiv='refresh' content='0;url=http://www.blvd-media.com/nojava.html' /></noscript>
<style type="text/css">
#blvdflash {
margin: 0px;
padding: 0px;
position: absolute;
top: 0px;
left: 0px;
right: 0px;
z-index: 9999; 
}
</style>
			<?php
			if(isset($_GET['pubid'])) { 
				if ($blvdmedia_load  == "loadall") {
					echo '
					<div style="margin:0;padding:0;position:fixed;width:100%;height:100%;" id="accessToolContainer">
					<div style="margin:0;padding:0;position:fixed;width:100%;height:100%;">
					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="myFlashContent"><param name="movie" value="http://www.blvd-media.com/AccessTool/AccessTool.swf"/>
					<param name="quality" value="high" />
					<param name="scale" value="ExactFit" />
					<param name="mode" value="transparent" />
					<param name="allowScriptAccess" value="always" />
					<object type="application/x-shockwave-flash" id="blvdflash" style="position:fixed;" data="http://www.blvd-media.com/AccessTool/AccessTool.swf" width="100%" height="100%"><param name="quality" value="high" />
					<param name="scale" value="ExactFit" />
					<param name="mode" value="transparent" />
					<param name="allowScriptAccess" value="always" />
					<div id="atOverlay" style="width:100%;height:100%;position:fixed;filter:alpha(opacity=70);-moz-opacity:70%;opacity:.7;">
					<a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
					</a>
					</div>
					</object>
					</object>
					</div>
					</div>';
				}
			}
		}
	}
}

function blvd_at_chk_load() {
	if ( !is_admin() ) {
		$blvdmedia_status 	= get_option('blvdmedia_status', 'disabled');
		$blvdmedia_pub_id 	= get_option('blvdmedia_pub_id', '12345');
		$blvdmedia_load		= get_option('blvdmedia_load', 'loadall');
		if ($blvdmedia_status == "enabled") {
			if ($blvdmedia_load  == "loadall") {
				if(!isset($_GET['pubid'])) { 
					echo '
					<script type="text/javascript">
					var prefix = window.location;
					window.location = prefix + \'?pubid='.$blvdmedia_pub_id.'\';
					</script>';
				}
				else {
				add_action('init', 'blvd_at_ext_js', 1);
				}
			}
		}
	}
}

add_action('init', 'blvd_at_chk_load', 0);

//*************** Admin function ***************
function blvdmedia_at_admin() {
	include('blvdreward_import_admin.php'); 
}

function blvdmediatool_admin_actions() {  
add_menu_page( "Blvd-Media accessTool&#174; Configuration", "Blvd-Media accessTool&#174;", 1, "blvd-media-access-tool", "blvdmedia_at_admin", plugins_url( 'blvdmediaplugin/images/blvdicon.jpg' , dirname(__FILE__) ) );
}

add_action( 'admin_menu', 'blvdmediatool_admin_actions' );  
?>
<?php
/*
Plugin Name: LCG Player For Wordpress
Plugin URI: https://www.lion-r.cn
Description: LCGPlyr是一款HTML5的视频播放器，界面简单、简洁。
Version: 1.2
Author: LCG
Author URI: https://www.lion-r.cn
License: A "Slug" license name e.g. GPL2
*/

// 定义插件路径
 if( ! defined( 'PLYR_URL' ) )define( 'PLYR_URL', plugin_dir_url( __FILE__ ) );

// 调用插件文件
function themtuts_plyr_css_and_js_files() {
    echo "<link href='https://cdn.bootcss.com/plyr/1.5.20/plyr.css' rel='stylesheet'>";
    echo "<script type='text/javascript' src='https://cdn.bootcss.com/plyr/1.5.20/plyr.js'></script>";
    echo "<script type='text/javascript' src='".PLYR_URL."src/plyr.js'></script>";
}

add_action( 'wp_footer', 'themtuts_plyr_css_and_js_files' );

//短代码
function themetuts_plyr_player($atts, $content=null) {
    extract(shortcode_atts(array("poster" => ''), $atts));
    $return = '<div class="plyr">';
    $return .= '<video poster="'.$poster.'" controls>';
    $return .= '<source src="'.$content.'" type="video/mp4">';
    $return .= '</video>';
    $return .= '</div> ';
    return $return;
}

add_shortcode('plyr' , 'themetuts_plyr_player' );

//添加按钮功能
function plyr_tinymce_button() {
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
		add_filter( 'mce_buttons', 'plyr_register_tinymce_button' );
		add_filter( 'mce_external_plugins', 'plyr_tinymce_button_script' );
	}
}

add_action( 'admin_init', 'plyr_tinymce_button' );

function plyr_register_tinymce_button( $buttons ) {
	array_push( $buttons, 'plyr_button' );
	return $buttons;
}

function plyr_tinymce_button_script( $plugin_array ) {
	$plugin_array['plyr_button_script'] =PLYR_URL. '/src/button.js';  // Change this to reflect the path/filename to your js file
	return $plugin_array;
}

//短代码使用示例
//[plyr poster="封面地址"]视频地址[/plyr]
?>
<?php

/*
@package sp-video

Plugin Name: SP-Video Plugin
Description: SP-Video Plugin is a plugin that alow user to post a video from youtube without using embed code. It`s very easy to use: 1 - Copy link of your youtube video  2 - Insert "[video] Youtube link [/video]" in your post.
Author: Sergiu Falcusan
Version: 0.1
License: GPLv2
 
SP-Video
Copyright (C) 2010  Falcusan Sergiu

This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 

 */

 define( PLUGIN_DIR, plugin_dir_path( __FILE__ ) );

add_action( 'admin_menu', 'spvideo_menu' );
add_filter( 'the_content', 'spvideo_edit_content' );
function spvideo_menu()
{
    add_menu_page('SP-Video Plugin', 'SP-Video', 'manage_options', 'sp-video', 'sp_video_admin');
}

function sp_video_admin()
{
    if (!current_user_can('manage_options'))  
    {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    require_once( PLUGIN_DIR . '/admin.php' );
}

function spvideo_edit_content()
{
    function getVideo($text)
    {
        preg_match_all('/\[video\]([^\]]*)\[\/video\]/i', $text, $matches);

        $videos = array();
        if(isset($matches[1]) && is_array($matches[1]))
        {
            foreach($matches[1] as $video)
            {
                array_push($videos, trim($video));
            }
        }
        return $videos;
    }
    $content = get_the_content();
    
    $url =  getVideo($content);
    $url = $url[0];
    
    if (!empty($url))
    {
        $parsed_url = parse_url($url);
        $parsed_url = $parsed_url['query'];
        parse_str($parsed_url, $a_data);
        $parsed_url = $a_data['v'];
        $sp_video_options = get_option('sp_video_options');
        $width = $sp_video_options['width'];
        $height = $sp_video_options['height'];
        
        $sp_video = '<iframe title="YouTube video player" class="youtube-player" type="text/html" width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$parsed_url.'" frameborder="0"></iframe><br />';
    }
    
    $regex = "/(\[video\])(.*)(\[\/video\])/";
    $content = preg_replace($regex, "$sp_video", $content);
    
    echo $content;
}
?>



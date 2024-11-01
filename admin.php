<?
/*
@package sp-video 

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
echo '<div class="wrap">';    
    echo '<form method="post" action="">';

    if ( !get_option( 'sp_video_options' ))
{
    $sp_video_options =  array (
                                'width' => "380",
                                'height' => "275"
                                );
    add_option( 'sp_video_options', $sp_video_options ); 
    $width = $sp_video_options['width'];
    $height = $sp_video_options['height'];
}
else {
    if (empty($_POST['width']) || empty($_POST['height'])) 
    {
        $sp_video_options = get_option('sp_video_options');
        $width = $sp_video_options['width'];
        $height = $sp_video_options['height'];
    } 
    else 
    {
        if (is_numeric($_POST['width']) && is_numeric($_POST['height'])) {
            $sp_video_options =  array (
                                'width' => $_POST['width'],
                                'height' => $_POST['height']
                                );
            update_option('sp_video_options', $sp_video_options);
            $width = $_POST['width'];
            $height = $_POST['height'];
        } else {
            echo '<span style="color:red;">The width and height needs to be a valid number!</span><br />';
            $sp_video_options = get_option('sp_video_options');
            $width = $sp_video_options['width'];
            $height = $sp_video_options['height'];
        }
    }
}
    echo '<br /><input id="width" type="text" style="width:100px;" name="width" value="'.$width.'" /> <i> video width</i>';
    echo '<br /><input id="height" type="text" style="width:100px;" name="height" value="'.$height.'" /> <i> video height</i>';
    echo '<br /><br /><input type="submit" name="Submit" value="Save Changes!" />';
    echo '</form>'; 
echo '</div>';
?>  
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Inc URL
 *
 * Returns the "inc_url" item from your config file
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('inc_url'))
{
	function inc_url()
	{
		$CI =& get_instance();
		return $CI->config->slash_item('inc_url');
	}
}

/**
 * Theme URL
 *
 * Returns the path to your active theme
 *
 * @access	public
 * @return	string
 * @param   string  The theme name
 * @return  string  The url to the theme folder
 */
if ( ! function_exists('theme_url'))
{
	function theme_url( $theme_name = '')
	{
        $CI =& get_instance();
        
        if ($theme_name)
        {
            $CI->config->set_item('theme_name', $theme_name);
        }
        else
        {
            return $CI->config->slash_item('theme_url').$CI->config->slash_item('theme_name');
        }
		
	}
}


/* End of file MY_url_helper.php */
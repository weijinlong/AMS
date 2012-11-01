<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Yield  ::  HOOKS
 *
 * Adds layout support :: Similar to RoR <%= yield =>
 * '{yield}' will be replaced with all output generated by the controller/view.
 */
class Yield {

    function doYield() {
        global $OUT;

        $CI = & get_instance();
        $output = $CI->output->get_output();
        //$in_canvas = $CI->config->item('in_canvas');
        $default = APPPATH . 'views/layouts/default.php';

        if (isset($CI->layout)) {
            if (!preg_match('/(.+).php$/', $CI->layout)) {
                $CI->layout .= '.php';
            }
            $requested = APPPATH . 'views/layouts/' . $CI->layout;

            if (file_exists($requested)) {
                $layout = $CI->load->file($requested, true);
                $view = str_replace("{yield}", $output, $layout);
            }
        } else if (file_exists($default)) {
            $layout = $CI->load->file($default, true);
            $view = str_replace("{yield}", $output, $layout);
        } else {
            $view = $output;
        }
        $OUT->_display($view);
    }

}

?>

<?php

namespace ArtifyForm\Integration\WordPress;

use ArtifyForm\ArtifyForm;

class ArtifyFormWP
{
    /**
     * Registers a WordPress shortcode to output an ArtifyForm form.
     * 
     * @param string $tag The shortcode tag name (e.g., 'artifyform_form')
     * @param callable $callback The callback generating and returning the ArtifyForm instance
     */
    public static function registerShortcode(string $tag, callable $callback)
    {
        if (function_exists('add_shortcode')) {
            add_shortcode($tag, function ($atts) use ($callback) {
                // Buffer output just in case the callback tries to echo natively
                ob_start();
                
                $form = call_user_func($callback, $atts);
                
                if ($form instanceof ArtifyForm) {
                    // Extract styles and scripts directly into the DOM block.
                    // For more intensive setups, developers might wire generateCss() to wp_enqueue_scripts
                    $html = $form->generateCss() . $form->generateForm();
                    echo $html;
                }
                
                return ob_get_clean();
            });
        }
    }
}

<?php

if (!function_exists('get_file_path')) {
    /**
     * @param  string  $url
     * @return string
     */
    function get_file_path(string $url): string
    {
        return str_replace(config('app.storage_url'), '', $url);
    }
}

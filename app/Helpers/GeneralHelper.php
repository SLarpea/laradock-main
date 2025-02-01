<?php

if (!function_exists('get_authorized_user')) {
    function get_authorized_user()
    {
        return auth()->user();
    }
}
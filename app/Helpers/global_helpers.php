<?php

// check user has permission

if (!function_exists('hasPermission')) {
    function hasPermission(array $permissions): bool
    {
        return auth('admin')->user()->hasAnyPermission($permissions);
    }
}

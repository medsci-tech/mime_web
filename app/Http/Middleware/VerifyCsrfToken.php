<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/thyroid-class/course/timer',
        '/thyroid-class/enter',
        '/admin/teacher*',
        '/admin/thyroid*',
        '/admin/phase*',
        '/admin/course*',
        '/admin/banner*',
        '/file/upload*',
        '/user/send*',
        '/user/pwd_reset*',
    ];
}

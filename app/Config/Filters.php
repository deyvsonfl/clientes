<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf' => \CodeIgniter\Filters\CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'auth'          => \App\Filters\Auth::class, // filtro de autenticação customizado
    ];

    public array $required = [
        'before' => [
            // 'forcehttps',
            // 'pagecache',
        ],
        'after' => [
            // 'pagecache',
            // 'performance',
            'toolbar',
        ],
    ];

    public array $globals = [
        'before' => [
            //'csrf',
        ],
        'after' => [
            'toolbar',
        ],
    ];


    public array $methods = [];

    public array $filters = [
        'auth' => ['before' => [
            'clientes*',
            'dashboard',
            'pedidos*',
            'configuracoes*',
        ]]
    ];
}

<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    // Use var_dump() for debugging

// Or use print_r() for a more readable output

    /**
     * --------------------------------------------------------------------------
     * Templates
     * --------------------------------------------------------------------------
     *
     * Pagination links are rendered out using views to configure their
     * appearance. This array contains aliases and the view names to
     * use when rendering the links.
     *
     * Within each view, the Pager object will be available as $pager,
     * and the desired group as $pagerGroup;
     *
     * @var array<string, string>
     */
    // app/Config/Pager.php
    public $templates = [
        
        'default'         => 'CodeIgniter\Pager\Views\default_template',
        'default_full'    => 'CodeIgniter\Pager\Views\default_full',
        'default_simple'  => 'CodeIgniter\Pager\Views\default_simple',
        'custom_pagination' => 'app/Views/custom_pagination', // Add this line        
    ];


    /**
     * --------------------------------------------------------------------------
     * Items Per Page
     * --------------------------------------------------------------------------
     *
     * The default number of results shown in a single page.
     */
    public int $perPage = 20;
}

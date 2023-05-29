<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */
    'title' => 'AL BORJ ERP',
    // 'title' => 'Employes Management System',
    // 'title_prefix' => 'AL BORJ ERP',
    // 'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>AL BORJ ERP</b>',
    'logo_img' => 'vendor/adminlte/dist/img/Al logo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Employes Management System',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-white',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'text' => 'Dashboard',
            'url'  => 'dashboard',
            'icon' => 'nav-icon fas fa-fw fa-home',
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'text' => 'Accounts',
            'url'  => '',
            'icon' =>'nav-icon fas fa-fw fa-calculator',
            'submenu' => [
                [
                    'text' => 'Client Master',
                    'url'  => 'clientmaster',
                    'icon' => 'nav-icon fas fa-fw fa-users'

                ],
                // [
                //     'text' => 'Petty Cash',
                //     'url'  => 'account',
                //     'icon' => 'fas fa-sharp fa-regular fa-money-bill',
                // ],
                [
                    'text' => 'Payment Receivables',
                    'url'  => 'account',
                    'icon' => 'nav-icon fas fa-fw fa-receipt',
                ],
                [
                    'text' => 'Payment Payables',
                    'url'  => 'account',
                    'icon' => 'nav-icon fas fa-fw fa-wallet',
                ],
                [
                    'text' => 'Expenses Category Master',
                    'url'  => 'expensescategorymaster',
                    'icon' => 'nav-icon fas fa-fw fa-tag',
                ],
                [
                    'text' => 'Daily Expenses-Payment Voucher',
                    'url'  => 'expenses',
                    'icon' => 'nav-icon fas fa-fw fa-shopping-bag',
                ],
            ],
        ],
        [
            'text' => 'HR',
            'url'  => '',
            'icon' => 'nav-icon fas fa-user-tie',
            'submenu' => [
                [
                    'text' => 'Employee Master',
                    'url'  => 'employeemaster',
                    'icon' => 'nav-icon fas fa-fw fa-user-circle',

                ],
                [
                    'text' => 'Timesheet-Sitewise',
                    'url'  => 'timesheet',
                    'icon' => 'nav-icon fas fa-fw fa-clock',

                ],
                [
                    'text' => 'Payroll Option-Salary Employee Wise',
                    'url'  => 'account',
                    'icon' => 'nav-icon fas fa-money-bill',

                ],
            ],
        ],
        [
            'text' => 'Project Management ',
            'url'  => '',
            'icon' => 'nav-icon fas fa-fw fa-tasks',
            'submenu' => [
                [
                    'text' => 'Site Master',
                    'url'  => 'sitemaster',
                    'icon' => 'nav-icon fas fa-fw fa-building',
                ],
                [
                    'text' => 'Project Master',
                    'url'  => 'projectmaster',
                    'icon' => 'nav-icon fas fa-fw fa-project-diagram fa-sm',

                ],
                [
                    'text' => 'Item Master',
                    'url'  => 'itemmaster',
                    'icon' => 'nav-icon fas fa-shopping-basket',

                ],
            ],
        ],
        [
            'text' => 'Purchase',
            'url'  => '',
            'icon' => 'nav-icon fas fa-fw fa-shopping-cart ',
            'submenu' => [
                [
                    'text' => 'Supplier Master',
                    'url'  => 'suppliermaster',
                    'icon' => 'nav-icon fas fa-fw fa-truck',

                ],
                [
                    'text' => 'Material Requisition',
                    'url'  => 'materialrequisition',
                    'icon' => 'nav-icon fas fa-dolly',

                ],
                [
                    'text' => 'Purchase Order',
                    'url'  => 'purchaseorder',
                    'icon' => 'nav-icon fas fa-cart-arrow-down',

                ],
                [
                    'text' => 'Goods Receiving Note',
                    'url'  => 'goodsreceivingnote',
                    'icon' => 'nav-icon fas fa-warehouse',

                ],
                [
                    'text' => 'Purchase Return',
                    'url'  => 'purchasereturn',
                    'icon' => 'nav-icon fas fa-retweet',

                ],
                [
                    'text' => 'Material Issue/Return',
                    'url'  => 'MaterialIssue',
                    'icon' => 'nav-icon fas fa-exclamation-triangle',

                ],
                // [
                //     'text' => 'Audit Inventory',
                //     'url'  => 'account',
                //     'icon' => 'nav-icon far fa-circle text-danger',

                // ],
            ],
        ],
        [
            'text' => 'Reports',
            'url'  => '',
            'icon' =>  'nav-icon fas fa-fw fa-book',
            'submenu' => [
                [
                    'text' => 'Project Reports',
                    'url'  => 'account',
                    'icon' => 'nav-icon fas fa-fw fa-regular fa-star text-warning',

                ],
                [
                    'text' => 'Inventory Reports',
                    'url'  => 'account',
                    'icon' => 'nav-icon fas fa-fw fa-regular fa-star text-danger',

                ],
                [
                    'text' => 'Accounting Balance Reports',
                    'url'  => 'account',
                    'icon' => 'nav-icon fas fa-fw fa-regular fa-star text-primary',

                ],
                [
                    'text' => 'User Defined Reports',
                    'url'  => 'account',
                    'icon' => 'nav-icon fas fa-fw fa-regular fa-star text-success',

                ],

            ],
        ],
        [
            'text' => 'Logout',
            'url'  => '',
            'icon' => 'nav-icon fas fa-fw fa-sign-out-alt',

        ]


    ],


    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.datatables.net/v/bs4/dt-1.10.24/b-1.7.0/b-colvis-1.7.0/b-html5-1.7.0/b-print-1.7.0/r-2.2.7/datatables.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.datatables.net/v/bs4/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/r-2.2.7/datatables.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11.0.12/dist/sweetalert2.all.min.js',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];

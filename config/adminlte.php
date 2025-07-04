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

    'title' => 'Venta de Timbres Fiscales',
    'title_prefix' => '',
    'title_postfix' => ' | SETA',

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
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => 'Principal',
    // 'logo2' => 'J-00000000-1',
    'logo_img' => 'vendor/adminlte/dist/img/M2.svg',
    'logo_img_class' => 'brand-image img-circle elevation-3 fs-6',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-lg',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/M2.svg',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/M2.svg',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 100,
            'height' => 100,
        ],
    ],

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

    'usermenu_enabled' => false,
    'usermenu_header' => false,
    'usermenu_header_class' => 'fw-bold bg-gradient-navy',
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
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
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

    'classes_auth_card' => 'card-outline card-success',
    'classes_auth_header' => 'fw-bold',
    'classes_auth_body' => 'bg-dark',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-success',

    // 'classes_auth_card' => '',
    // 'classes_auth_header' => 'bg-gradient-info',
    // 'classes_auth_body' => '',
    // 'classes_auth_footer' => 'text-center',
    // 'classes_auth_icon' => 'fa-lg text-info',
    // 'classes_auth_btn' => 'btn-flat btn-primary',

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
    'classes_brand' => 'bg-gradient-navy', //// logo e inicio 
    'classes_brand_text' => '',
    'classes_content_wrapper' => 'bg-white', /////content
    'classes_content_header' => '',
    'classes_content' => '',
    // 'classes_sidebar' => 'sidebar-white bg-gradient-navy elevation-1',
    // 'classes_sidebar' => 'main-sidebar elevation-4 sidebar-navy text-sm',    
    'classes_sidebar' => 'text-sm sidebar-dark bg-gradient-navy elevation-2 ',
    'classes_sidebar_nav' => 'text-sm sideba-white',
    // 'classes_topnav' => 'navbar-navy bg-gradient-navy navbar-dark', /////clases para el nav top

    // 'classes_sidebar_nav' => 'sidebar-light-navy text-sm',
    'classes_topnav' => 'text-sm sidebar-light-navy', /////clases para el nav top
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

    'sidebar_mini' => false,
    'sidebar_collapse' => true,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-dark',
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
    'right_sidebar_push' => false,
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
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => false,
        ],
        //CONSULTA
        [   'header' => 'Timbres Fiscales',
            'can' => ['consulta'],
        ],
        [
            'text'        => 'Consulta',
            'route'         => 'consulta',
            'can' => ['consulta'],
            'icon'       => 'fas fa-angle-right pe-2',   
        ],
        [
            'text'        => 'Ventas',
            'route'         => 'historial_ventas',
            'can' => ['historial_ventas'],
            'icon'       => 'fas fa-angle-right pe-2',   
        ],
        [
            'text'        => 'Anulación',
            'route'         => 'anular',
            'can' => ['anular'],
            'icon'       => 'fas fa-angle-right pe-2',   
        ],
        //CIERRE
        [   'header' => 'Cierre',
            'can' => ['cierre','historial_cierre','reporte_anual'],
        ],
        [
            'text'        => 'Diario',
            'route'         => 'cierre',
            'can' => ['cierre'],
            'icon'       => 'fas fa-angle-right pe-2', 
        ],
        [
            'text'        => 'Historial',
            'route'         => 'historial_cierre',
            'can' => ['historial_cierre'],
            'icon'       => 'fas fa-angle-right pe-2',  
        ],
        [
            'text'        => 'Anual',
            'route'         => 'reporte_anual',
            'can' => ['reporte_anual'],
            'icon'       => 'fas fa-angle-right pe-2',  
        ],
        //PAPEL DE SEGURIDAD
        [   'header' => 'Papel de Seguridad',
            'can' => ['emision_papel','inventario_papel','inventario_ut'],
        ],
            
        [
            'text'        => 'Emisión',
            'route'         => 'emision_papel',
            'can' => ['emision_papel'],
            'icon'       => 'fas fa-angle-right pe-2',   
        ],
        [
            'text'        => 'Inventario',
            'can' => ['inventario_papel','inventario_ut'],
            'icon'       => 'fas fa-angle-right pe-2', 
            'submenu' => [
                            [
                                'text' => 'Papel de Seguridad',
                                'route'  => 'inventario_papel',
                                'can' => ['inventario_papel'],
                            ], 
                            [
                                'text' => 'Estampillas U.T.',
                                'route'  => 'inventario_ut',
                                'can' => ['inventario_ut'],
                            ],
                        ],
        ],
        [
            'text'        => 'Proveedores',
            'route'         => 'proveedores',
            'can' => ['proveedores'],
            'icon'       => 'fas fa-angle-right pe-2',   
        ],
        //ESTAMPILLAS
        [   'header' => 'Estampillas',
            'can' => ['emision_ucd'],
        ],
        [
            'text'        => 'Asignación UCD | Inventario',
            'route'         => 'emision_ucd',
            'can' => ['emision_ucd'],
            'icon'       => 'fas fa-angle-right pe-2',   
        ],
        //ASIGNACIONES
        [   'header' => 'Asignaciones',
            'can' => ['asignar','timbres_asignados','historial_asignaciones'],
        ],
        [
            'text'        => 'Asignar Timbres',
            'route'         => 'asignar',
            'can' => ['asignar'],
            'icon'       => 'fas fa-angle-right pe-2', 
        ],
        [
            'text'        => 'Timbres asignados',
            'route'         => 'timbres_asignados',
            'can' => ['timbres_asignados'],
            'icon'       => 'fas fa-angle-right pe-2',  
        ],
        [
            'text'        => 'Historial',
            'route'         => 'historial_asignaciones',
            'can' => ['historial_asignaciones'],
            'icon'       => 'fas fa-angle-right pe-2',  
        ],
        //TAQUILLAS        
        [   'header' => 'Taquillas',
            'can' => ['apertura','inventario_taquillas'],
        ],
        [
            'text'        => 'Aperturar',
            'route'         => 'apertura',
            'can' => ['apertura'],
            'icon'       => 'fas fa-angle-right pe-2',  
        ],
        [
            'text'        => 'Inventario',
            'route'         => 'inventario_taquillas',
            'can' => ['inventario_taquillas'],
            'icon'       => 'fas fa-angle-right pe-2',  
        ],
        //SEDES-TAQUILLAS
        [   'header' => 'Sedes | Taquillas ',
            'can' => ['sede_taquilla'],
        ],
        [
            'text'        => 'Agregar y/o Modificar',
            'route'         => 'sede_taquilla',
            'can' => ['sede_taquilla'],
            'icon'       => 'fas fa-angle-right pe-2',  
        ],
        //CONFIGURACIONES
        [   'header' => 'Configuraciones',
            'can' => ['ajustes','usuarios','roles','rol_usuario','bitacora'],
        ],
        [
            'text'        => 'Ajustes',
            'route'         => 'ajustes',
            'can' => ['ajustes'],
            'icon'       => 'fas fa-angle-right pe-2',  
        ],
        [
            'text' => 'Usuarios',
            'url'  => '/usuarios',
            'can' => ['usuarios'],
            'icon'       => 'fas fa-angle-right pe-2',
        ],
        [
            'text' => 'Permisos',
            'can' => ['roles','rol_usuario'],
            'icon'       => 'fas fa-angle-right pe-2', 
            'submenu' => [
                [
                    'text' => 'Roles',
                    'icon' => 'fas fa-angle-right ps-3 pe-2', 
                    'route'  => 'roles',
                    'can' => ['roles'],
                ],
                [
                    'text' => 'Usuarios',
                    'icon' => 'fas fa-angle-right ps-3 pe-2', 
                    'route'  => 'rol_usuario',
                    'can' => ['rol_usuario'],
                ],
            ],
        ],
        [
            'text' => 'Bitácoras',
            'url'  => '/bitacora',
            'can' => ['bitacora'],
            'icon'       => 'fas fa-angle-right pe-2',
        ],
        // MI CUENTA
        [   'header' => 'Mi Cuenta',
            'can' => ['new_pass'],
        ],         
        [
            'text' => 'Nueva Contraseña',
            'url'  => '/new_pass',
            'can' => ['new_pass'],
            'icon'       => 'fas fa-angle-right pe-2',
        ],



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
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
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
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
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

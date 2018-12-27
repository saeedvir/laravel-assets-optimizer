<?php
return [
    'base_path'=>'public/',
    'profiles'=>[
        'frontend'=>[
            'css_files'=>[
                
                //'assets/vendor/bootstrap3/bootstrap.rtl.full.css', //Bootstrap 3
                
                // 'assets/vendor/bootstrap4/litera-theme/bootstrap.css', //Bootstrap 4
                // 'assets/vendor/bootstrap4/bootstrap-rtl.css', //Bootstrap 4
                
                // 'assets/vendor/fontawesome/4.7/css/font-awesome.css', //fontawesome 4.7
                
                // 'assets/vendor/fontawesome/5.0/css/all.css', //fontawesome 5.0
                // 'assets/vendor/fontawesome/5.0/css/v4-shims.css', //fontawesome 5.0

                // 'assets/vendor/slick/slick.css',
                // 'assets/vendor/slick/slick-theme.css',

                // 'assets/vendor/jquery-ui/jquery-ui.min.css',

                // 'assets/css/fonts.css',
                // 'assets/css/custom.css',
                // 'assets/css/responsive.css',
            ],
            'js_files'=>[
                
                // 'assets/vendor/jquery/jquery-3.3.1.min.js', //Jquery 3
                //'assets/vendor/jquery/jquery-3.3.1.slim.min.js', //Jquery 3 Slim (No Ajax And Effects)
                
                // 'assets/vendor/jquery/jquery-migrate-1.4.1.min.js', //Jquery 1+ migrate
                
                // 'assets/vendor/jquery/jquery-migrate-3.0.0.min.js', //Jquery 3+ migrate

                // 'assets/vendor/jquery-ui/jquery-ui.min.js',
                // 'assets/js/custom.js',

            ],
            'skip_css_complie'=>[
                //'assets/css/fonts.css'
            ],
            'skip_js_complie'=>[
            ],
            'css_compile_path'=>'css/',
            'css_compile_name'=>'frontend.css',
            'js_compile_path'=>'js/',
            'js_compile_name'=>'frontend.js',
            'add_filename_title'=>true,
            'minify_css'=>true,
            'optimize_css'=>true,
            'minify_js'=>true,
        ],//end frontend
        'backend'=>[
            'css_files'=>[
                // 'panel/vendors/iconfonts/mdi/css/materialdesignicons.min.css',
                // 'panel/vendors/css/vendor.bundle.base.css',
                // 'panel/css/custom.css',
            ],
            'js_files'=>[
                // 'panel/vendors/js/vendor.bundle.base.js',
                // 'panel/vendors/js/vendor.bundle.addons.js',
                // 'panel/js/off-canvas.js',
            ],
            'skip_css_complie'=>[
            ],
            'skip_js_complie'=>[
            ],
            'css_compile_path'=>'css/',
            'css_compile_name'=>'backend.css',
            'js_compile_path'=>'js/',
            'js_compile_name'=>'backend.js',
            'add_filename_title'=>true,
            'minify_css'=>true,
            'optimize_css'=>true,
            'minify_js'=>true,
        ],
        //Other Profiles ...
        
    ]
];

?>
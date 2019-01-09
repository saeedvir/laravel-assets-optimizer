<?php

namespace LaravelAssetsOptimizer;

use Illuminate\Console\Command;
use MatthiasMullie\Minify;

class LaravelAssetsOptimizerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assets:optimize {options?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merge css and javascripts files and optimize them ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
        @options = help

         */

        if ($this->argument('options') == 'help') {
            echo 'please visit the homepage : '."\r\n".'https://github.com/saeedvir/laravel-assets-optimizer'."\r\n";

            return true;
        }

        $base_path = config('assets.base_path');

        foreach (config('assets.profiles') as $profile => $data) {
            echo 'scanning `'.$profile.'`'."\r\n";

            //CSS
            echo '--> merge css files'."\r\n";
            $compile_css_path = config("assets.profiles.$profile.css_compile_path");
            $compile_css_filename = config("assets.profiles.$profile.css_compile_name");
            file_put_contents($base_path.$compile_css_path.$compile_css_filename, '');
            foreach ($data['css_files'] as $css_file) {
                if (in_array($css_file, config("assets.profiles.$profile.skip_css_complie"))) {
                    echo '--> skip css : '.$css_file."\r\n";
                    continue;
                }
                if (config("assets.profiles.$profile.add_filename_title")) {
                    file_put_contents($base_path.$compile_css_path.$compile_css_filename, "\r\n".'/* File : '.$css_file.' */'."\r\n", FILE_APPEND);
                }
                file_put_contents($base_path.$compile_css_path.$compile_css_filename, @file_get_contents($base_path.$css_file), FILE_APPEND);
            }
            echo '--> merged : '.$base_path.$compile_css_path.$compile_css_filename."\r\n";

            if (config("assets.profiles.$profile.minify_css")) {
                echo '--> minify '.$base_path.$compile_css_path.$compile_css_filename."\r\n";

                $cssMinifier = new Minify\CSS();
                $cssMinifier->add($base_path.$compile_css_path.$compile_css_filename);
                $cssminifiedPath = $base_path.$compile_css_path.$compile_css_filename;
                $cssMinifier->minify($cssminifiedPath);

                echo '--> minified : '.$base_path.$compile_css_path.$compile_css_filename."\r\n";
            }

            if (config("assets.profiles.$profile.optimize_css")) {
                echo '--> optimizing '.$base_path.$compile_css_path.$compile_css_filename."\r\n";

                $this->cssFileOptimizer($base_path.$compile_css_path.$compile_css_filename);

                echo '--> optimized : '.$base_path.$compile_css_path.$compile_css_filename."\r\n";
            }

            //JS
            echo '--> merge js files'."\r\n";
            $compile_js_path = config("assets.profiles.$profile.js_compile_path");
            $compile_js_filename = config("assets.profiles.$profile.js_compile_name");
            file_put_contents($base_path.$compile_js_path.$compile_js_filename, '');
            foreach ($data['js_files'] as $js_file) {
                if (in_array($js_file, config("assets.profiles.$profile.skip_js_complie"))) {
                    echo '--> skip js : '.$js_file."\r\n";
                    continue;
                }

                if (config("assets.profiles.$profile.add_filename_title")) {
                    file_put_contents($base_path.$compile_js_path.$compile_js_filename, "\r\n".'/* File : '.$js_file.' */'."\r\n", FILE_APPEND);
                }
                file_put_contents($base_path.$compile_js_path.$compile_js_filename, @file_get_contents($base_path.$js_file), FILE_APPEND);
            }
            echo '--> merged : '.$base_path.$compile_js_path.$compile_js_filename."\r\n";

            if (config("assets.profiles.$profile.minify_js")) {
                echo '--> minify '.$base_path.$compile_js_path.$compile_js_filename."\r\n";

                $jsMinifier = new Minify\JS();
                $jsMinifier->add($base_path.$compile_js_path.$compile_js_filename);
                $jsminifiedPath = $base_path.$compile_js_path.$compile_js_filename;
                $jsMinifier->minify($jsminifiedPath);

                echo '--> minified : '.$base_path.$compile_js_path.$compile_js_filename."\r\n";
            }
        }
    }

    protected function cssFileOptimizer($file)
    {
        if (!is_file($file) || empty($file)) {
            return false;
        }
        $css = file_get_contents($file);

        $css = preg_replace('#([^\\\\]\:|\s)0(?:em|ex|ch|rem|vw|vh|vm|vmin|cm|mm|in|px|pt|pc|%)#iS', '${1}0', $css);
        //
        // Replace 0 0; or 0 0 0; or 0 0 0 0; with 0
        //
        $css = preg_replace('#\:0(?: 0){1,3}(;|\}| \!)#', ':0$1', $css);
        //
        // Remove leading zeros from integer and float numbers preceded by : or a white-space
        // -0.5 to -.5; 1.050 to 1.05
        //
        $css = preg_replace('#((?<!\\\\)\:|\s)(\-?)0+(\.?\d+)#S', '$1$2$3', $css);
        //
        // Optimize hex colors: #999999 to #999; #ffdd88 to #fd8;
        //
        $css = preg_replace('#([^=])\#([a-f\\d])\\2([a-f\\d])\\3([a-f\\d])\\4([\\s;\\}])#i', '$1#$2$3$4$5', $css);
        //
        // Remove the spaces, if a curly bracket, colon, semicolon or comma is placed before or after them
        //
        $css = preg_replace('#\s*([\{:;,]) *#', '$1', $css);
        //
        // Remove newline characters and tabs
        //
        $css = str_replace(["\r\n", "\r", "\n", "\t"], '', $css);
        //
        // Remove last semicolon
        //
        $css = preg_replace('#\s*(\;\s*\})#', '}', $css);
        //
        // Remove two or more consecutive spaces
        //
        $css = preg_replace('# {2,}#', '', $css);
        //

        return file_put_contents($file, $css);
    }
}

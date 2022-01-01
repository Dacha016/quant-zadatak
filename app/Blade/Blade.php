<?php

namespace App\Blade;

use Jenssegers\Blade\Blade as JBlade;
class Blade
{
    public static function render($template, $data = [])
    {
        echo self::returnTemplate($template, $data);
    }
    public static function  returnTemplate($template, $data = []) {
        $views = dirname(__DIR__, 2) . "/resources/views/";
        $cache = dirname(__DIR__, 2) . "/storage/views/cache/";

        $blade = new JBlade($views, $cache);
        $file = realpath(dirname(__DIR__, 2)) . "/resources/views/" . $template . ".blade.php";

        if(file_exists($file)) {

            return $blade->render($template, $data);
        } else {
            echo "View not exist!!!";
        }

    }
}
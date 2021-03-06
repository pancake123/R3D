<?php

namespace app\commands;

use ReflectionMethod;
use yii\console\Controller;
use yii\helpers\StringHelper;

class DiplomaController extends Controller {

    public function actionClass() {
        $path = substr(__DIR__, 0, strrpos(__DIR__, '\\')).DIRECTORY_SEPARATOR;
        ob_start();
        foreach (static::$dirs as $dir) {
            foreach ($this->listFiles($path.$dir) as $d) {
                $this->printClass($d, 'app\\'.$dir.'\\'.basename($d, '.php'));
            }
        }
        file_put_contents('class.txt', ob_get_clean());
    }

    public function actionCode($folder) {
        $path = substr(__DIR__, 0, strrpos(__DIR__, '\\')).DIRECTORY_SEPARATOR.$folder;
        $counter = 1;
        ob_start();
        foreach ($this->listFiles($path) as $file) {
            $f = $file;
            $p = strrpos($file, '\\');
            $old = substr($file, 0, $p);
            $file = substr($old, strrpos($old, '\\') + 1).'/'.substr($file, $p + 1);
            print 'Листинг В.'.$counter.' – Исходный код файла '.$file."\r\n";
            print preg_replace('/[\r\n]+/', "\r\n", file_get_contents($f))."\r\n";
            print 'Листинг В.'.$counter.' – Конец'."\r\n";
            $counter++;
        }
        file_put_contents('code.txt', mb_convert_encoding(ob_get_clean(), 'Windows-1251', 'UTF-8'));
    }

    private function printClass($path, $class) {
        try {
            $parent = get_parent_class($class);
        } catch (\Exception $e) {
            return ;
        }
        $name = basename($path, '.php');
        print "Класс {$name}\r\n";
        print "Класс объявлен в файле «{$name}.php». Класс является наследником класса {$parent}.\r\n";
        $ref = new \ReflectionClass($class);
        $list = [
            ReflectionMethod::IS_PUBLIC => 'Public',
            ReflectionMethod::IS_PRIVATE => 'Private',
            ReflectionMethod::IS_PROTECTED => 'Protected',
        ];
        foreach ($list as $t => $n) {
            $m = '';
            foreach ($ref->getMethods($t) as $method) {
                if (preg_match('/__.*/', $method->getName())) {
                    continue;
                }
                if ($method->class != $ref->getName()) {
                    continue;
                }
                $m .= $method->getName()."\r\n";
            }
            if (strlen($m) > 0) {
                print "$n-методы класса:\r\n";
                print $m;
            }
        }
    }

    private function listFiles($from = '.', $ext = 'php')  {
        $files = [];
        if (!is_dir($from)) {
            return [];
        }
        if (!($dh = opendir($from))) {
            return $files;
        }
        while (false !== ($file = readdir($dh))) {
            if($file == '.' || $file == '..') {
                continue;
            }
            $path = $from . '\\' . $file;
            if (is_dir($path)) {
                $files += $this->listFiles($path);
            } else if (substr($path, strrpos($path, '.') + 1) == $ext) {
                $files[] = $path;
            }
        }
        closedir($dh);
        return $files;
    }

    private static $dirs = [
        'assets',
        'controllers',
        'core',
        'filters',
        'forms',
        'grids',
        'models',
        'validators',
        'widgets',
    ];
}
<?php
class NitroDb {
    public static $singleton;
    public static $created_nitro_product_cache = false;
    private $link = false;

    public static function getInstance() {
        if (empty(self::$singleton)) self::$singleton = new NitroDb();
        return self::$singleton->getLink();
    }

    public function __construct() {
        $file = $this->vqmod_resolve(DIR_DATABASE . DB_DRIVER . '.php');

        if (file_exists($file)) {
            require_once ($file);

            if (class_exists('DB' . DB_DRIVER)) {
                $class = 'DB' . DB_DRIVER;
            } else {
                $class = DB_DRIVER;
            }

            $this->link = new $class(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        }
    }

    public function getLink() { return $this->link; }

    private function vqmod_resolve($file) {
        if (class_exists('VQMod')) {
            $is_static = false;

            $folder = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'vqmod' . DIRECTORY_SEPARATOR;
            $vqmod_file_contents = file_get_contents($folder . 'vqmod.php');

            $is_static = 
                stripos($vqmod_file_contents, 'public static function modCheck') !== FALSE || 
                stripos($vqmod_file_contents, 'public function modCheck') === FALSE;

            if ($is_static) {
                $file = VQMod::modCheck($file);
            } else {
                $vqmod = new VQMod();
                $file = $vqmod->modCheck($file);
                unset($vqmod);
            }
        }

        return $file;
    }
}

class NitroDBClass {
    private $driver;

    public function __construct($driver, $hostname, $username, $password, $database) {
        $file = $this->vqmod_resolve(DIR_DATABASE . $driver . '.php');

        if (file_exists($file)) {
            require_once ($file);

            if (class_exists('DB' . $driver)) {
                $class = 'DB' . $driver;
            } else {
                $class = $driver;
            }

            $this->driver = new $class($hostname, $username, $password, $database);
            $this->driver->query("SET NAMES 'utf8'");
            $this->driver->query("SET CHARACTER SET utf8");
            $this->driver->query("SET CHARACTER_SET_CONNECTION=utf8");
            $this->driver->query("SET SQL_MODE = ''");
        } else {
            exit('Error: Could not load database driver type ' . $driver . '!');
        }
    }

    public function vqmod_resolve($file) {
        if (class_exists('VQMod')) {
            $is_static = false;

            $folder = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'vqmod' . DIRECTORY_SEPARATOR;
            $vqmod_file_contents = file_get_contents($folder . 'vqmod.php');

            $is_static = 
                stripos($vqmod_file_contents, 'public static function modCheck') !== FALSE || 
                stripos($vqmod_file_contents, 'public function modCheck') === FALSE;

            if ($is_static) {
                $file = VQMod::modCheck($file);
            } else {
                $vqmod = new VQMod();
                $file = $vqmod->modCheck($file);
                unset($vqmod);
            }
        }

        return $file;
    }

    public function query($sql) {
        return $this->driver->query($sql);
    }

    public function escape($value) {
        return $this->driver->escape($value);
    }

    public function countAffected() {
        return $this->driver->countAffected();
    }

    public function getLastId() {
        return $this->driver->getLastId();
    }
}

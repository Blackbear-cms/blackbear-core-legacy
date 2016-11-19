<?php
if (!class_exists('files')) {
  /**
   *
   */
  class files {

    function __construct() {
      # code...
    }

    //TODO pedir en vez de la carpeta el path
    public function create_file($name='noname', $extension='no', $ondir) {
      if ($ondir == null) {
        file_put_contents('data/' . $name . '.' . $extension);
      } else {
        file_put_contents('data/'. $ondir . '/' . $name . '.' . $extension);
      }
    }

    public function remove_file($name='noname', $extension='no', $ondir) {
      if ($ondir == null) {
        unlink('data/' . $name . '.' . $extension);
      } else {
        unlink('data/'. $ondir . '/' . $name . '.' . $extension);
      }
    }

    public function rename_file($oldname='noname', $extension='no', $newname, $ondir) {
      rename('data/'. $ondir .'/'. $oldname .'.'. $extension, 'data/'. $ondir .'/'. $newname .'.'. $extension);
    }

    public function list_dir($dir) {
      if ($dir == null) {
        return scandir('data/');
      } else {
        return scandir('data/' . $dir);
      }
    }

    public function create_dir($name) {
      mkdir('data/' . $name);
    }

    public function remove_dir($name) {
      rmdir('data/' . $name);
    }

    public function read_data($file='noname', $extension='no', $ondir) {
      if (isset($ondir)) {
        return file_get_contents('data/' . $ondir . '/' . $file . '.' . $extension);
      } else {
        return file_get_contents('data/' . $file . '.' . $extension);
      }

    }

    public function put_data($file='noname', $extension='no', $ondir, $data) {
      if (isset($ondir)) {
        return file_put_contents('data/' . $ondir . '/' . $file . '.' . $extension, $data);
      } else {
        return file_put_contents('data/' . $file . '.' . $extension, $data);
      }
    }

    public function factory_data($zip_name) {
      $zip = new ZipArchive;
      if ($zip->open($zip_name) == true) {
        $zip->extractTo('data/');
        $zip->close();

        return true;
      } else {
        global $fuel;
        $fuel->error('Zip cant openend');

        return false;
      }
    }

    public function public_content($name='unknow', $engine, $data) {
      return file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/public/' . $engine . '/' . $name, $data);
    }

    public function remove_public_content($name='unknow', $engine) {
      return unlink($_SERVER['DOCUMENT_ROOT'] . '/public/' . $engine . '/' . $name);
    }

    public function link_public_content($name, $engine) {
      return symlink('data/' . $name, $_SERVER['DOCUMENT_ROOT'] . '/public/' . $engine . '/' . $name);
    }
  }

}



 ?>

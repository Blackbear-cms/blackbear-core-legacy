<?php

if (!class_exists('emid')) {
  /**
   *
   */
  class emid {
    public $disables = array();

    function __construct() {
      # code...
    }

    public function install($name, $version) {
      # code...
      //TODO terminar funcion
    }

    public function install_from_local($path, $name) {
      rename($path,'../' . $name);

      global $fuel;
      $fuel->engines_list[] = $name;
      $fuel->setup_engines();
    }

    public function remove($name='core') {
      include '../' . $name . 'setup.php';
      $f = new $name;
      $f->remove();

      rmdir('../' . $name);
    }

    public function update($name) {
      # code...
      //TODO teminar funcion
    }
    //TODO update_from_local

    public function enable($name) {
      global $fuel;

      $fuel->engines_list[] = $name;
    }

    public function disable($name='core') {
      global $fuel;

      if(($key = array_search($name, $fuel->engines_list)) !== false) {
        unset($fuel->engines_list[$key]);
      }
    }

    public function get_all() {
      global $fuel;

      return array_merge($fuel->$engines_list, $disables);
    }

    public function get_disable() {
      return $this->disables;
    }
  }

}


 ?>

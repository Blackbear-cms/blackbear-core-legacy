<?php
if (!class_exists('db')) {
  /**
   *
   */
  class db{
    private $dbmanager;

    function __construct() {
      global $fuel;
      $settings = $fuel->read_file('dbmanager', 'json');

      if ($settings == null) {

      } else {
        $this->dbmanager = $fuel->load_class($settings[0], $settings[1]);
      }
    }

    public function put_data($collection, $data) {
      # code...
    }

    public function put_collect($collection, $data) {
      # code...
    }

    public function get_all_data($collection) {
      # code...
    }

    public function create_collect($name, $structure) {
      # code...
    }

    public function remove_collect($name) {
      # code...
    }

    public function get_data($collection, $select, $where) {
      # code...
    }

    public function update_data($collection, $where, $set) {
      # code...
    }

    public function remove_data($collection, $where) {
      # code...
    }

    public function is_sql() {
      # code...
    }
  }

}




 ?>

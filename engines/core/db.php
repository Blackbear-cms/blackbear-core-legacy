<?php
if (!class_exists('db')) {
  /**
   *
   */
  class db{
    private $dbmanager;

    function __construct() {
      global $fuel;
      $settings = $fuel->read_file('config', 'json');

      if ($settings == null) {
        $fuel->error('no config file or empty');
      } else {
        $this->dbmanager = $fuel->load_class($settings[0], $settings[1]);
      }
    }

    public function put_data($collection, $data) {
      return $this->dbmanager->put_data($collection, $data);
    }

    public function put_various($collection, $data) {
      return $this->dbmanager->put_various($collection, $data);
    }

    public function get_all_data($collect) {
      return $this->dbmanager->get_all($collection);
    }

    public function create_collect($name, $structure) {
      return $this->dbmanager->new_collect($name, $structure);
    }

    public function remove_collect($name) {
      return $this->dbmanager->remove_collect($name);
    }

    public function get_data($collection, $where_and, $where_or) {
      return $this->dbmanager->new_collect($collection, $where_and, $where_or);
    }

    public function update_data($collection, $where, $set) {
      return $this->dbmanager->update($collection, $where, $set);
    }

    public function remove_data($collection, $where) {
      return $this->dbmanager->remove($collection, $where);
    }

    public function is_sql() {
      return $this->dbmanager->is_sql();
    }
  }

}




 ?>

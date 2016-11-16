<?php
/**
 *
 */
if (!class_exists('hook')) {
  global $hooks;

  include 'internal/php-hooks.php';

  class hook extends Hooks {
    //TODO nuevas funciones
    function __construct() {
      parent::__construct();
      $this->filters = unserialize(file_get_contents('/data/engineshook.ini'));
    }

    public function __destruct() {
      $filters = serialize($this->filters);
      file_put_contents('/data/engineshook.ini', $filters);
    }

  }
}


 ?>

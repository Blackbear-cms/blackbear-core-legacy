<?php
/**
 *
 */
class core extends files {
  public $engines_list = array();
  public $core_called_by = "";

  function __construct($render) {
    $this->core_called_by = $render;
    $this->engines_list = $this->load_engines_list();
    if ($this->engines_list == null) {
      $this->setup_engines();
      $this->setup_renders();
      $this->engines_list = $this->load_engines_list();
    }
    $this->load_cores_cron();
  }

  private function load_engines_list($Rescan=false) {
    $list = file_get_contents("/data/engineslist.json");

    if ($Rescan == false && $list != null) {
      return json_decode($list);
    } else {
      $list = scandir($_SERVER['DOCUMENT_ROOT'] . '/engines/');
      file_put_contents('data/engineslist.json', $list);
      return $list;
    }
  }

  private function load_cores_cron() {
    global $cron;
    $cron = json_decode(file_get_contents("data/cron.json"));
    $this->load_class('core', 'cron');

  }

  public function setup_engines() {
    $this->load_engines_list($Rescan=true);

    file_put_contents('data/engineshook.json', null);
    file_put_contents("data/engineslist.json", null);

    foreach ($this->engines_list as $key => $engine) {
      if (!@include $_SERVER['DOCUMENT_ROOT'] . '/engines/' . $engine . '/setup.php') {
        unset($this->engines_list[$key]);
      } else {
        $f = new $engine();
        $f->init();
      }
    }
  }

  public function setup_renders() {
    $renders = scandir($_SERVER['DOCUMENT_ROOT'] . '/renders/');

    foreach ($renders as $render) {
      if (@include $_SERVER['DOCUMENT_ROOT'] . '/renders/' . $render . '/setup.php') {
        $f = new $render();
        $f->init();
      }
    }
  }

  private function error($Msg = 'Error msg is null') {
    $this->log($Msg, "Error>");
  }

  private function log($Msg = 'Log msg is null', $before = "") {
    // TODO mejorar sistema de logs con un archivo csv
    if (is_writable("data/logs/" . $this->core_called_by . ".log")) {
      $logFile = file_get_contents("data/logs/" . $this->core_called_by . ".log");
      $logFile .= $before . "[" . date("Y-m-d h:i:sa") . "][" . $this->core_called_by . "]" . $Msg ;
      file_put_contents("data/logs/" . $this->core_called_by . ".log", $logFile);
    }
  }

  public function get_log($engine='core') {
    return file_get_contents("data/logs/" . $engine . ".log");
  }

  public function is_engine_exist($engine='core') {
    if (array_search($engine, $this->engines_list)) {
      return true;
    } else {
      return false;
    }
  }

  function load_engine($engine) {
    if (in_array($this->engines_list, $engine)) {
      $this->error("The engine isnt in the engines list");
    } else {
      $dir = $_SERVER['DOCUMENT_ROOT'] . "/engines/" . $engine;
      $list = scandir($dir);

      foreach ($list as $file) {
        if (strpos($file, ".php")) {
          include $_SERVER['DOCUMENT_ROOT'] . '/engines/' . $engine . '/' . $file;
        }
      }
    }
  }

  function load_class($engine, $class) {
    if (in_array($this->engines_list, $engine)) {
      $this->error("The engine isnt in the engines list");
    } else {
      include $_SERVER['DOCUMENT_ROOT'] . '/engines/' . $engine . '/' . $class . '.php';
      return new $class();
    }
  }
  //TODO añadir funcion de dir_to_engine para trasportar una carpeta de internal a la carpeta de engines
}


 ?>

<?php
/**
 *
 */
if (!class_exists('cron')) {
class cron {

  private $cron_jobs;

  function __construct($cron_list) {
    $this->cron_jobs                = $cron_list;
    if ($cron_list == null) {
      $cron_list[0] = date(DATE_ATOM);
    }

    $now                            = new DateTime();
    $last                           = new DateTime($cron_list[0]);
    $interval                       = $now->diff($last)->format('%s');

    foreach ($cron_list as $value) {
      if (!$value == '0') {
        if ($value[0] >= $interval) {
          $engine                   = $value[1];
          $class                    = $value[2];
          $function                 = $value[3];
          //TODO cargar array con argumentos para la funcion y pasarlos por call_user_func

          include $_SERVER['DOCUMENT_ROOT'] . "/engines/" . $engine . '/' . $class . '.php';
          $foo                      = new $class();
          call_user_func(array($foo, $function));
        }
      }
    }

    $this->cron_jobs['0']           = $now->format(DateTime::ATOM);
  }

  public function new_job($interval = '0', $engine, $class, $function) {
    if ($engine == null || $class == null || $function == null) {
      $fuel->error('no path, class or function specified.');
    } else {
      $this->cron_jobs[]            = array(0 => $interval, 1 => $engine, 2 => $class, 3 => $function);
    }
  }

  public function remove_job($engine, $class, $function) {
    //TODO mejorar para que borre una tarea especifica con la key
    if ($path == null || $class == null) {
      $fuel->error('no path or class specified.');
    } else {
      if ($function == null) {
        foreach ($this->cron_jobs as $key => $value) {
          if ($engine == $value[1] && $class == $value[2]) {
            unset($this->cron_jobs[$key]);
          }
        }
        } else {
          foreach ($this->cron_jobs as $key => $value) {
            if ($engine == $value[1] && $class == $value[2] && $function == $value[3]) {
              unset($this->cron_jobs[$key]);
            }
          }
        }
      }
    }
  //TODO añadir funcion para editar

  function __destruct() {
    file_put_contents('data/cron.json', json_encode($this->cron_jobs));
  }
}
}

?>

<?php
/**
 *
 */
class websockets{
  private $server;
  public $status = false;

  function __construct() {
    global $fuel;
    $settings = json_decode($fuel->read_data('config', 'json'), true);
    include 'internal/WrenchSplClassLoader.php';

    if ($settings == null) {
      $fuel->error('no config file or empty');
    } else {
      $this->server = new \Wrench\Server('wss://' . $settings[2], array(
        'connection_manager_options' => array(
          'socket_master_options' => array(
              'server_ssl_local_cert'        => 'data/websocket.pem',
              'server_ssl_passphrase'        => $settings[3],
              'server_ssl_allow_self_signed' => $settings[4],
              'server_ssl_verify_peer'       => $settings[5]
          ),
        'allowed_origins' => $this->allow($settings[6])
        )
      ));

      foreach (json_decode($fuel->read_data('apps', 'ws'), true) as $app) {
        include $_SERVER['DOCUMENT_ROOT'] . '/engines/' . $app[1] . '/data/' . $app[0] . '.php';
        $this->server->registerApplication($app[0], new $app[0]);
      }

      $this->server->run();
      $this->status = true;
    }
  }

  public function register_app($name='unknow', $engine='unknow') {
    global $fuel;
    $apps = json_decode($fuel->read_data('apps', 'ws'));

    $apps[] = array(0 => $name, 1 => $engine);

    $fuel->put_data('apps', 'ws', json_encode($apps));
  }

  public function remove_app($name='unknow', $engine='unknow') {
    global $fuel;
    $apps = json_decode($fuel->read_data('apps', 'ws'));

    foreach ($apps as $app) {
      if ($app[0] == $name) {
        if ($app[1] == $engine) {
          $app = null;
        }
      }
    }

    $fuel->put_data('apps', 'ws', json_encode($apps));
  }

  private function restart() {
    exit;
  }

  private function allow($use) {
    if ($use == true) {
      global $fuel;
      $host = $fuel->load_class('core', 'index_table');
      return array_merge($host->get_host_list(), json_decode($fuel->read_file('extrahosts', 'ws')));
    } else {
      return null;
    }
  }

  function __destruct() {

  }
}


 ?>

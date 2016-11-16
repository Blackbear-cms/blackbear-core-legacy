<?php
if (!class_exists('index_table')) {
  /**
   *
   */
  class index_table {
    private $index;

    function __construct() {
      $this->index = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/settings.json'), true);
    }

    public function add_url($id, $host, $path, $render) {
      foreach ($this->index as $page) {
        if ($page[1] == $host && $page[2] == $path) {
          $conflict == true;
          global $fuel;
          $fuel->error('Failed try of conflict in index table');
        }
      }

      if (!$conflict == true) {
        $this->index[] = array('0' => false, '1' => $host, '2' => $path, '3' => $render, '4' => $id );

        return true;
      } else {
        return false;
      }
    }

    public function add_regex($id, $host, $path, $render) {
      foreach ($this->index as $page) {
        if ($page[1] == $host && $page[2] == $url) {
          $conflict == true;
          global $fuel;
          $fuel->error('Failed try of conflict in index table');
        }
      }

      if (!$conflict == true) {
        $this->index[] = array('0' => true, '1' => $host, '2' => $path, '3' => $render, '4' => $id );

        return true;
      } else {
        return false;
      }
    }

    public function remove($id, $render) {
      foreach ($this->index as $key => $page) {
        if ($page[4] == $id && $page[3] == $render) {
          unset($this->index[$key]);

          return true;
          break;
        }
      }
    }

    public function edit($id, $render, $newhost, $newpath, $newrender, $newid) {
      foreach ($this->index as $key => $page) {
        if ($page[4] == $id && $page[3] == $render) {
          $this->index[$key] = array('1' => $newhost, '2' => $newpath, '3' => $newrender, '4' => $newid );

          return true;
          break;
        }
      }
    }

    public function is_exist($host, $path) {
      foreach ($this->index as $page) {
        if ($page[2] == $path) {
          if ($page[1] == $host) {
            return true;
            break;
          }
        }
      }
    }

    public function is_host_exist($host) {
      foreach ($this->index as $page) {
        if ($page[1] == $host) {
          return true;
          break;
        }
      }
    }

    public function get_table() {
      return $this->index;
    }

    public function get_host_list() {
      // TODO: mejorar para almacenar un cache
      $hosts = array();
      $exist = false;
      foreach ($this->index as $page) {
        foreach ($hosts as $host) {
          if ($host == $page[1]) {
            $exist = true;
            break;
          }
        }

        if ($exist == false) {
          $hosts[] = $page[1];
        } else {
          $exist = false;
        }
      }
      return $hosts;
    }

    public function get_pages_from_host($host) {
      $pages = array();
      foreach ($this->index as $page) {
        if ($page[1] == $host) {
          $pages[] = $page[2];
        }
      }
      return $pages;
    }

    function __destruct() {
      file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/settings.json', json_encode($this->index));
    }
  }
}

 ?>

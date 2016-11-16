<?php
$url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$url = parse_url($url);
$pages = json_decode(file_get_contents('settings.json'), true);
$found = false;

foreach ($pages as $page) {
  // TODO: mejorar con un regex
if ($page[0] == 'true') {
  if (preg_match('/'. $page[1] .'/i', $url['host'])) {
    if (preg_match('/'. $page[2] .'/i', $url['path'])) {
      init($page[3], $page[4], $url);

      $found = true;
      break;
    }
  }
} else {
  if ($page[1] == $url['host']) {
    if ($page[2] == $url['path']) {
      init($page[3], $page[4], $url);

      $found = true;
      break;
    }
  }
}
}

if ($found == false) {
  echo "error:";
  echo "no page for:" . $url['host'] . ' ' . $url['path'];
  var_dump($pages);
}

function init($render, $id, $url) {
  include 'renders/' . $render . '/init.php';
  include 'engines/core/core.php';
  include 'engines/core/files.php';
  global $fuel;

  $fuel = new core($render);
  $render = new $render($url, $id);
}

 ?>

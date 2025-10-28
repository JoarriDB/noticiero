<?php
// Fallback static file handler for images placed inside api/secciones/imagenes
// If a request path starts with /images/ we try:
// 1) api/secciones/imagenes/<path>
// 2) ../public/images/<path>
// If found, return the file with appropriate Content-Type and exit.
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH);
if (strpos($path, '/images/') === 0) {
  $rel = substr($path, strlen('/images/'));
  $candidate1 = __DIR__ . "/secciones/imagenes/" . $rel;
  if (is_file($candidate1)) {
    $mime = function_exists('mime_content_type') ? mime_content_type($candidate1) : null;
    if (!$mime) {
      $ext = pathinfo($candidate1, PATHINFO_EXTENSION);
      $map = ['jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','svg'=>'image/svg+xml','gif'=>'image/gif'];
      $mime = $map[strtolower($ext)] ?? 'application/octet-stream';
    }
    header('Content-Type: ' . $mime);
    header('Cache-Control: public, max-age=31536000');
    readfile($candidate1);
    exit;
  }
  $candidate2 = __DIR__ . "/../public/images/" . $rel;
  if (is_file($candidate2)) {
    $mime = function_exists('mime_content_type') ? mime_content_type($candidate2) : null;
    if (!$mime) {
      $ext = pathinfo($candidate2, PATHINFO_EXTENSION);
      $map = ['jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','svg'=>'image/svg+xml','gif'=>'image/gif'];
      $mime = $map[strtolower($ext)] ?? 'application/octet-stream';
    }
    header('Content-Type: ' . $mime);
    header('Cache-Control: public, max-age=31536000');
    readfile($candidate2);
    exit;
  }
  // Not found
  header("HTTP/1.1 404 Not Found");
  echo "Not found";
  exit;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://getbootstrap.com/favicon.ico">

    <title>NOTICIAS SON NOTICIAS 2025</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/4.1/examples/blog/blog.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">
      <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
          <div class="col-12 text-center">
            <a class="blog-header-logo text-dark" href="#">ACONTECIMIENTOS 2025</a>
          </div>
        </div>
      </header>

      <?php
        include("secciones/portada.php");
      ?>
      <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
        <div class="col-md-12 px-0">
          <h1 class="display-4 font-italic">
            <?php
              echo $portada["titulo"];
            ?>
          </h1>
          <p class="lead my-3">
            <?php
              echo $portada["resumen"];
            ?>
          </p>
        </div>
      </div>

      <!-- Fila 1 -->
      <?php
  include("secciones/internacional.php");
  <?php if (!empty($internacional["imagen"])): ?>
  <img src="<?php echo $internacional["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
  include("secciones/nacional.php");
  <?php if (!empty($nacional["imagen"])): ?>
  <img src="<?php echo $nacional["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
      ?>
      <div class="row mb-2">
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <?php if (!empty($internacional["imagen"])): ?>
            <img src="<?php echo $internacional["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
            <?php endif; ?>
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-primary">Internacional</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $internacional["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $internacional["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $internacional["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <?php if (!empty($nacional["imagen"])): ?>
            <img src="<?php echo $nacional["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
            <?php endif; ?>
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-success">Nacional</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $nacional["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $nacional["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $nacional["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin Fila 1 -->

      <!-- Fila 2 -->
      <?php
  include("secciones/economia.php");
  <?php if (!empty($economia["imagen"])): ?>
  <img src="<?php echo $economia["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
  include("secciones/opinion.php");
  <?php if (!empty($opinion["imagen"])): ?>
  <img src="<?php echo $opinion["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
      ?>
      <div class="row mb-2">
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-secondary">Economía</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $economia["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $economia["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $economia["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-warning">Opinión</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $opinion["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $opinion["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $opinion["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin Fila 2 -->

      <!-- Fila 3 -->
      <?php
  include("secciones/tecnologia.php");
  <?php if (!empty($tecnologia["imagen"])): ?>
  <img src="<?php echo $tecnologia["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
  include("secciones/ciencia.php");
  <?php if (!empty($ciencia["imagen"])): ?>
  <img src="<?php echo $ciencia["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
      ?>
      <div class="row mb-2">
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <?php if (!empty($tecnologia["imagen"])): ?>
            <img src="<?php echo $tecnologia["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
            <?php endif; ?>
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-primary">Tecnología</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $tecnologia["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $tecnologia["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $tecnologia["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-success">Ciencia</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $ciencia["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $ciencia["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $ciencia["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin Fila 3 -->

      <!-- Fila 4 -->
      <?php
  include("secciones/cultura.php");
  <?php if (!empty($cultura["imagen"])): ?>
  <img src="<?php echo $cultura["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
  include("secciones/gente.php");
  <?php if (!empty($gente["imagen"])): ?>
  <img src="<?php echo $gente["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
      ?>
      <div class="row mb-2">
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-secondary">Cultura</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $cultura["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $cultura["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $cultura["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-warning">Gente</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $gente["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $gente["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $gente["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin Fila 4 -->      

      <!-- Fila 5 -->
      <?php
  include("secciones/deportes.php");
  <?php if (!empty($deportes["imagen"])): ?>
  <img src="<?php echo $deportes["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
  include("secciones/television.php");
  <?php if (!empty($television["imagen"])): ?>
  <img src="<?php echo $television["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
  include("secciones/video.php");
  <?php if (!empty($video["imagen"])): ?>
  <img src="<?php echo $video["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
      ?>
      <div class="row mb-2">
        <div class="col-md-4">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-primary">Deportes</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $deportes["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $deportes["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $deportes["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-success">Televisión</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $television["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $television["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $television["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-success">Televisión</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $video["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $video["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $video["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin Fila 5 -->

      <!-- Fila 6 -->
      <?php
  include("secciones/formacion.php");
  <?php if (!empty($formacion["imagen"])): ?>
  <img src="<?php echo $formacion["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
  include("secciones/empleo.php");
  <?php if (!empty($empleo["imagen"])): ?>
  <img src="<?php echo $empleo["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
  include("secciones/sociedad.php");
  <?php if (!empty($sociedad["imagen"])): ?>
  <img src="<?php echo $sociedad["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
      ?>
      <div class="row mb-2">
        <div class="col-md-4">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-primary">Formación</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $formacion["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $formacion["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $formacion["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-success">Empleo</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $empleo["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $empleo["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $empleo["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-success">Sociedad</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $sociedad["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $sociedad["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $sociedad["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin Fila 6 -->

      <!-- Fila 7 -->
      <?php
  include("secciones/openstack.php");
  <?php if (!empty($openstack["imagen"])): ?>
  <img src="<?php echo $openstack["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
  include("secciones/git.php");
  <?php if (!empty($git["imagen"])): ?>
  <img src="<?php echo $git["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
      ?>
      <div class="row mb-2">
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-primary">OpenStack</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $openstack["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $openstack["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $openstack["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-success">Git</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $git["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $git["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $git["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin Fila 7 -->

      <!-- Fila 8 -->
      <?php
  include("secciones/contenedores.php");
  <?php if (!empty($contenedores["imagen"])): ?>
  <img src="<?php echo $contenedores["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
  include("secciones/openshift.php");
  <?php if (!empty($openshift["imagen"])): ?>
  <img src="<?php echo $openshift["imagen"]; ?>" class="card-img-left flex-auto d-none d-md-block" style="width:200px; object-fit:cover;">
  <?php endif; ?>
      ?>
      <div class="row mb-2">
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-secondary">Contenedores</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $contenedores["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $contenedores["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $contenedores["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 shadow-sm ">
            <div class="card-body d-flex flex-column align-items-start col-md-12">
              <strong class="d-inline-block mb-2 text-warning">OpenShift</strong>
              <h3 class="mb-0">
                <a class="text-dark" href="#">
                  <?php
                    echo $openshift["titulo"];
                  ?>
                </a>
              </h3>
              <div class="mb-1 text-muted">
                <?php
                  echo $openshift["autor"];
                ?>
              </div>
              <p class="card-text mb-auto">
                <?php
                  echo $openshift["resumen"];
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin Fila 8 -->
    </div>


    <footer class="blog-footer">
      <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.1/dist/js/bootstrap.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/holder.min.js"></script>
    <script>
      Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
      });
    </script>
  </body>
</html>

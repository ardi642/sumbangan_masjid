<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sumbangan Masjid</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
  <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg sticky-top bg-primary navbar-dark">
    <div class="container">
      <a class="navbar-brand mb-0 h1" href="#">Sumbangan Masjid</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <?php foreach ($menus as $menu => $label_menu) : ?>
            <li class="nav-item">
              <a class="nav-link <?= ($menu_aktif == $menu) ? "active" : "" ?>" href="<?= base_url($menu) ?>">
                <?= $label_menu ?>
              </a>
            </li>
          <?php endforeach ?>
        </ul>
      </div>
    </div>
  </nav>

  <?= $konten ?>

  <div class="container mt-4">
    <div class="row">
      <div class="col-12">
        <p class="text-center">Created with <span>❤️</span> By Original Team</p>
      </div>
    </div>
  </div>
  <script>
    <?php
    if (!isset($js)) $js = "";
    echo $js;
    ?>
  </script>
</body>

</html>
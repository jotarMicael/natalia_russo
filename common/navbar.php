<nav class="main-header navbar navbar-expand navbar-white navbar-light">

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="index3.html" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">

    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>
      <div class="navbar-search-block">
        <form class="form-inline">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">3</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="#" class="dropdown-item">

          <div class="media">
            <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Brad Diesel
                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">Call me whenever you can...</p>
              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>

        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">

          <div class="media">
            <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                John Pierce
                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">I got your message bro</p>
              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>

        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">

          <div class="media">
            <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Nora Silvester
                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">The subject goes here</p>
              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>

        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
      </div>
    </li>

    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
      </a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->


<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link">
    <img src="<?php echo BASE_URL; ?>/dist/img/dance.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light" style="color: #d81b60;"><b><?php echo substr(SYSTEM_NAME, 0, 7); ?></b><?php echo substr(SYSTEM_NAME, 7); ?></span>
  </a>

  <!-- Sidebar user panel (optional) -->
  <div class="sidebar">

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo BASE_URL; ?>/dist/img/user.png" class="img-circle elevation-4" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['user'] ?></a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?php echo BASE_URL; ?>views/home.php" class="nav-link <?php echo $nav == 'h' ? 'bg-orange' : ''; ?>" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Inicio
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link active bg-maroon">
            <i class="nav-icon fas fa-users"></i>
            <p> Alumnos <i class=" fas fa-angle-left right"></i></p>
          </a>

          <ul class="nav nav-treeview" style="display: <?php echo in_array($nav, array('ce','aa')) ? 'block' : 'none'; ?>;">
            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>views/students/create_student.php" class="nav-link <?php echo $nav == 'ce' ? 'bg-orange' : ''; ?>">
                <i class="nav-icon fas fa-user"></i>
                <p>Alta de alumno</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>views/students/students.php" class="nav-link <?php echo $nav == 'aa' ? 'bg-orange' : ''; ?>">
                <i class="nav-icon fas fa-user"></i>
                <p>Ver alumnos</p>
              </a>
            </li>

          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link active bg-maroon">
            <i class="nav-icon fas fa-users"></i>
            <p> Profesores <i class=" fas fa-angle-left right"></i></p>
          </a>

          <ul class="nav nav-treeview" style="display: <?php echo in_array($nav, array('ct')) ? 'block' : 'none'; ?>;">
            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>views/teachers/create_teacher.php" class="nav-link <?php echo $nav == 'ct' ? 'bg-orange' : ''; ?>">
                <i class="nav-icon fas fa-user"></i>
                <p>Alta de profesor</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // make it as accordion for smaller screens
      if (window.innerWidth > 992) {

        document.querySelectorAll('.navbar .nav-item').forEach(function(everyitem) {

          everyitem.addEventListener('mouseover', function(e) {

            let el_link = this.querySelector('a[data-bs-toggle]');

            if (el_link != null) {
              let nextEl = el_link.nextElementSibling;
              el_link.classList.add('show');
              nextEl.classList.add('show');
            }

          });
          everyitem.addEventListener('mouseleave', function(e) {
            let el_link = this.querySelector('a[data-bs-toggle]');

            if (el_link != null) {
              let nextEl = el_link.nextElementSibling;
              el_link.classList.remove('show');
              nextEl.classList.remove('show');
            }


          })
        });

      }
      // end if innerWidth
    });
  </script>
</aside>
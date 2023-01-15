<nav class="main-header navbar navbar-expand navbar-white navbar-light">

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
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
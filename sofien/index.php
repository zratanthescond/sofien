<html>

<head>
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
  <title>Sofien | Administration</title>
  <link rel="icon" type="image/jpg" href="assets/img/icon.jpg">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/sidebar.css">
  <link rel="stylesheet" href="assets/css/custom.css">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="assets/js/sidebar.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link href="assets/css/all.css" rel="stylesheet">
  <link href="assets/css/dark-mode.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</head>

<body>
  <div class="page-wrapper chiller-theme toggled">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
      <a class="navbar-brand" id="show-sidebar" href="#"><i class="fas fa-bars"></i></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search">
          <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>



    <nav id="sidebar" class="sidebar-wrapper">
      <div class="sidebar-content">
        <div class="sidebar-brand">
          <a href="#">Administration</a>
          <div id="close-sidebar">
            <i class="fas fa-times"></i>
          </div>
        </div>
        <div class="sidebar-search">
          <div>
            <div class="input-group">
              <input type="text" class="form-control search-menu" placeholder="Search...">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <!-- sidebar-search  -->
        <div class="sidebar-menu">
          <ul>
            <li class="header-menu">
              <span>General</span>
            </li>
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fa fa-tachometer-alt"></i>
                <span>Dashboard</span>
                <span class="badge badge-pill badge-warning">New</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="#">Dashboard 1
                      <span class="badge badge-pill badge-success">Pro</span>
                    </a>
                  </li>
                  <li>
                    <a href="#">Dashboard 2</a>
                  </li>
                  <li>
                    <a href="#">Dashboard 3</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>E-commerce</span>
                <span class="badge badge-pill badge-danger">3</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="#">Products

                    </a>
                  </li>
                  <li>
                    <a href="#">Orders</a>
                  </li>
                  <li>
                    <a href="#">Credit cart</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="far fa-gem"></i>
                <span>Components</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="#">General</a>
                  </li>
                  <li>
                    <a href="#">Panels</a>
                  </li>
                  <li>
                    <a href="#">Tables</a>
                  </li>
                  <li>
                    <a href="#">Icons</a>
                  </li>
                  <li>
                    <a href="#">Forms</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fa fa-chart-line"></i>
                <span>Statistiques</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="javascript:route.setCurrenView('stats').dispalyView('views');">Vente Statistiques</a>
                  </li>
                  <li>
                    <a href="#">Line chart</a>
                  </li>
                  <li>
                    <a href="#">Bar chart</a>
                  </li>
                  <li>
                    <a href="#">Histogram</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="sidebar-dropdown">
              <a href="#">
                <i class="fa fa-globe"></i>
                <span>Maps</span>
              </a>
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <a href="#">Google maps</a>
                  </li>
                  <li>
                    <a href="#">Open street map</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="header-menu">
              <span>Extra</span>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-book"></i>
                <span>Documentation</span>
                <span class="badge badge-pill badge-primary">Beta</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-calendar"></i>
                <span>Calendar</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-folder"></i>
                <span>Examples</span>
              </a>
            </li>
          </ul>
        </div>
        <!-- sidebar-menu  -->
      </div>
      <!-- sidebar-content  -->
      <div class="sidebar-footer">
        <a href="#">
          <i class="fa fa-bell"></i>
          <span class="badge badge-pill badge-warning notification">3</span>
        </a>
        <a href="#">
          <i class="fa fa-envelope"></i>
          <span class="badge badge-pill badge-success notification">7</span>
        </a>
        <a href="#">
          <i class="fa fa-cog"></i>
          <span class="badge-sonar"></span>
        </a>
        <a href="#">
          <i class="fa fa-power-off"></i>
        </a>
      </div>
    </nav>




    <div class="container-fluid">
      <div class="row">

        <div class="material-button-anim mb-4 float-right" id="draggable" style="z-index: 20; display:flex;max-height:1rem;">
          <button type="button" id="entrepriseSettings" class="btn-floating  btn-outline-danger btn-lg" title="ajout market"><i class="fas fa-cogs fa-2x"></i></button>
          <ul class="list-inline" id="options">
            <li class="option">
              <button type="button" id="marketsControle" class="btn-floating  btn-outline-primary btn-lg option1" title="ajout market"><i class="fas fa-store fa-2x"></i></button>
            </li>
            <li class="option">
              <button type="button" id="productControle" class="btn-floating btn-outline-success btn-lg option2" title="ajour produit"> <i class="fas fa-cart-arrow-down fa-2x"></i></button>
            </li>
            <li class="option">
              <button type="button" id="employerControle" class="btn-floating btn-outline-danger btn-lg option3" title="Ajout ouvrier"> <i class="fas fa-users-cog fa-2x"></i></button>
            </li>
          </ul>


        </div>

        <div class="col-md-12 mt-4" id="root">

        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
  <script>
    class Route {
      constructor() {
        if (localStorage.getItem('Route') == null) {
          this.view = 'stast';
          localStorage.setItem('Route', JSON.stringify(this))
        }else{
          this.view=JSON.parse(localStorage.getItem('Route')).view
        }
      }
      getCurrentView() {
       
        if ( typeof this.view == 'undefined') {
           alert(this.view)
          this.view = 'stats';
          localStorage.setItem('Route', JSON.stringify(this))
          return this.view
        } else {
          return this.view
        }
      }
      setCurrenView(view){
        this.view = view;
          localStorage.setItem('Route', JSON.stringify(this))
          return this
      }
      dispalyView(folder){
        $("#root").load(folder+'/'+ this.getCurrentView() + '.html');
      }
    }

    var route = new Route();

    $(document).ready(function() {

      $('#entrepriseSettings').on("click", function() {
        $(this).toggleClass('open');
        $('.option').toggleClass('scale-on');
      });


      var route = new Route();
      //testDark()
     route.dispalyView('views')

    })
    $("#marketsControle").click(function() {
      var route = new Route();
      route.setCurrenView('market')
      route.dispalyView('views');

    })
    $("#productControle").click(function() {
      var route = new Route();
      route.setCurrenView('article')
      route.dispalyView('views');

    })
    $("#employerControle").click(function() {
      var route = new Route();
      route.setCurrenView('ouvrier')
      route.dispalyView('views');

    })
    $("#editMarket").click(function() {
      $("#root").load('views/marketController.html');

    })
  </script>

</body>

</html>
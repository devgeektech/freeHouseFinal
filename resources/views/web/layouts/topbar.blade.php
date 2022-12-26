<header>
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand mr-5" href="#"> 
          <img src="{{URL::to('/public/images/FreeHouseDesigD01aR01a.jpg')}}" height="50" width="50">
        </a>
        <h4 class="nav-heading">Free House Design</h4>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end menu-navigation" id="navbarSupportedContent">
          <ul class="navbar-nav">
           
            @auth
              <li class="nav-item">
                <a class="nav-link goals mr-4" href="#" data-toggle="modal" data-target="#logoutModal">
                  LOGOUT
              </a>
              </li>
            @endauth
          </ul>
        </div>
      </nav>
    </div>
  </header>
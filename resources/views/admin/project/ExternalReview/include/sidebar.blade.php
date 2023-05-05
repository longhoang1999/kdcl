<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="metismenu" id="side-menu">
            <li class="nav-header ">

                <div class="dropdown profile-element img-rounded">

                    @if( Sentinel::getUser()->csdt)
                        <img alt="image" class="img-rounded img-responsive"
                             src="https://bloganh.net/wp-content/uploads/2020/06/dung-nghieng-nguoi-voi-hoa.jpg" width="100rem">

                    @else
                        <img alt="image" class="img-rounded img-responsive" src="https://bloganh.net/wp-content/uploads/2020/06/dung-nghieng-nguoi-voi-hoa.jpg" width="100rem">
                    @endif
                </div>
            </li>
          @include("admin.project.ExternalReview.include.sidebar-menu")

        </ul>

    </div>
</nav>



<nav class="navbar navbar-expand-md navbar-light" style="position: relative; z-index: 9999;">

   <a class="navbar-brand" href="{{ route('index') }}">
      <img src="{{ asset('assets/img/logo.png') }}" class="logo-one" alt="Logo">
      <img src="{{ asset('assets/img/logo.png') }}" class="logo-two" alt="Logo">
   </a>

   <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">

      <ul class="navbar-nav">

         <li class="nav-item">
            <a href="{{ route('index') }}" class="nav-link">Home</a>
         </li>

         <li class="nav-item">
            <a href="{{ route('index') }}#donasi" class="nav-link">Donasi</a>
         </li>

         <li class="nav-item">
            <a href="#" class="nav-link dropdown-toggle">
               Blog
               <i class="icofont-simple-down"></i>
            </a>

            <ul class="dropdown-menu">
               @foreach($categories as $category)
                  <li class="nav-item">
                     <a href="{{ route('blog.category', $category->slug) }}" class="nav-link">
                        {{ $category->name }}
                     </a>
                  </li>
               @endforeach
            </ul>
         </li>

         <li class="nav-item">
            <a href="{{ route('contact') }}" class="nav-link">Kontak</a>
         </li>

      </ul>

      <div class="side-nav ml-auto" style="position: relative; z-index: 99999; pointer-events: auto;">

         @guest

            <a href="{{ route('login') }}" class="common-btn" style="position: relative; z-index: 99999;">
               Login
            </a>

            <a href="{{ route('register') }}" class="common-btn two" style="margin-left: 10px; position: relative; z-index: 99999;">
               Register
            </a>

         @else

            @if(auth()->user()->role === 'admin')

               <button type="button"
                       onclick="window.location.href='{{ route('admin.dashboard') }}'"
                       class="common-btn"
                       style="
                           border: none;
                           cursor: pointer;
                           display: inline-flex;
                           align-items: center;
                           gap: 7px;
                           position: relative;
                           z-index: 99999;
                           pointer-events: auto;
                       ">
                  <i class="icofont-dashboard-web"></i>
                  Dashboard Admin
               </button>

            @else

               <button type="button"
                       onclick="window.location.href='{{ route('donatur.profile') }}'"
                       class="common-btn"
                       style="
                           border: none;
                           cursor: pointer;
                           display: inline-flex;
                           align-items: center;
                           gap: 7px;
                           position: relative;
                           z-index: 99999;
                           pointer-events: auto;
                       ">
                  <i class="icofont-user-alt-3"></i>
                  {{ auth()->user()->name }}
               </button>

            @endif

         @endguest

      </div>

   </div>

</nav>
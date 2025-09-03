  <div class="floating-button-container d-flex" onclick="window.location.href = 'create-service'">
      <button class="floating-button">
          <i class="fa-solid fa-add"></i>
      </button>
  </div>
  <nav class="nav-mobile d-flex">
      <a href="{{route('home')}}" class="{{ request()->is('/')? 'active' : ''}}">
          <i class="fas fa-house"></i>
          Beranda
      </a>
      <a href="{{ route('service.index') }}"
          class="{{ request()->routeIs('service.index') ? 'active' : '' }}">
          <i class="fas fa-solid fa-clipboard-list"></i>
          Pengajuan
      </a>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <a href="{{ route('service.myservice', ['status' => 'delivered']) }}"
          class="{{ request()->routeIs('service.myservice') ? 'active' : '' }}">
          <i class="fas fa-solid fa-bars-progress"></i>
          Progress
      </a>
      @auth
      <a href="{{ route('profile') }}" class="{{ request()->is('profile*')? 'active' : ''}}">
          <i class="fas fa-user"></i>
          Profil
      </a>
      @else
      <a href="{{ route('register') }}" class="">
          <i class="fas fa-right-to-bracket"></i>
          Daftar
      </a>
      @endauth
  </nav>
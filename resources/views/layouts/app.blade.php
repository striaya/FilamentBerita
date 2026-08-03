<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Moco - Portal Berita')</title>
  <link href="{{ asset('css/output.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
  <div class="w-full">
    {{-- Nav --}}
    <div class="sticky top-0 z-50 flex justify-between py-5 px-4 lg:px-14 bg-white shadow-sm">
      <div class="flex gap-10 w-full">
        <div class="flex items-center justify-between w-full lg:w-auto">
          <a href="{{ route('landing') }}">
            <div class="flex items-center gap-2">
              <img src="{{ asset('img/Logo.png') }}" alt="Logo" class="w-8 lg:w-10">
              <p class="text-lg lg:text-xl font-bold">Moco</p>
            </div>
          </a>
          <button class="lg:hidden text-primary text-2xl focus:outline-none" id="menu-toggle">☰</button>
        </div>

        <div id="menu" class="hidden lg:flex flex-col lg:flex-row lg:items-center lg:gap-10 w-full lg:w-auto mt-5 lg:mt-0">
          <ul class="flex flex-col lg:flex-row items-start lg:items-center gap-4 font-medium text-base w-full lg:w-auto">
            <li><a href="{{ route('landing') }}" class="hover:text-primary {{ request()->routeIs('landing') ? 'text-primary' : '' }}">Beranda</a></li>
            <li><a href="{{ route('news.index') }}" class="hover:text-primary {{ request()->routeIs('news.index') ? 'text-primary' : '' }}">Semua Berita</a></li>
          </ul>
        </div>
      </div>

      {{-- Search --}}
      <div class="hidden lg:flex items-center gap-2 mt-4 lg:mt-0 w-full lg:w-auto relative">
        <form action="{{ route('news.index') }}" method="GET" class="relative w-full lg:w-auto">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..."
            class="border border-slate-300 rounded-full px-4 py-2 pl-8 w-full text-sm font-normal lg:w-auto focus:outline-none focus:ring-primary focus:border-primary" />
          <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
            <img src="{{ asset('img/search.png') }}" alt="search" class="w-4">
          </span>
        </form>
        <a href="/admin" class="bg-primary px-8 py-2 rounded-full text-white font-semibold h-fit text-sm lg:text-base">
          Masuk
        </a>
      </div>
    </div>

    {{-- Menu Dropdown Mobile --}}
    <div id="dropdown-menu" class="hidden absolute top-0 left-0 w-full h-screen bg-white z-40 flex flex-col items-start gap-4 px-8 py-12 text-lg font-semibold shadow-md">
      <a href="{{ route('landing') }}" class="hover:text-primary">Beranda</a>
      <a href="{{ route('news.index') }}" class="hover:text-primary">Semua Berita</a>
      <form action="{{ route('news.index') }}" method="GET" class="w-full">
        <input type="text" name="search" placeholder="Cari berita..." class="border border-slate-300 rounded-full px-4 py-2 w-full text-sm">
      </form>
      <a href="/admin" class="hover:text-primary">Masuk</a>
    </div>

    <main>
      @yield('content')
    </main>

    {{-- Footer sederhana --}}
    <footer class="border-t border-slate-200 mt-16 py-8 px-4 lg:px-14 text-sm text-slate-400 flex justify-between flex-col md:flex-row gap-2">
      <p>&copy; {{ date('Y') }} Moco. Semua hak dilindungi.</p>
      <p>Portal Berita Terpercaya</p>
    </footer>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const menuToggle = document.getElementById("menu-toggle");
      const dropdownMenu = document.getElementById("dropdown-menu");
      menuToggle?.addEventListener("click", () => dropdownMenu.classList.toggle("hidden"));
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  @stack('scripts')
</body>

</html>

@extends('layouts.app')

@section('title', 'Moco - Beranda')

@section('content')

  {{-- Swiper Banner --}}
  @if($banners->count())
    <div class="swiper mySwiper mt-9">
      <div class="swiper-wrapper">
        @foreach($banners as $banner)
          <div class="swiper-slide">
            <a href="{{ route('news.show', $banner->news->slug) }}" class="block">
              <div class="relative flex flex-col gap-1 justify-end p-3 h-72 rounded-xl bg-cover bg-center overflow-hidden"
                style="background-image: url('{{ $banner->news->thumbnail_url }}')">
                <div class="absolute inset-x-0 bottom-0 h-full bg-gradient-to-t from-[rgba(0,0,0,0.4)] to-[rgba(0,0,0,0)] rounded-b-xl"></div>
                <div class="relative z-10 mb-3" style="padding-left: 10px;">
                  <div class="bg-primary text-white text-xs rounded-lg w-fit px-3 py-1 font-normal mt-3">{{ $banner->news->category->title }}</div>
                  <p class="text-3xl font-semibold text-white mt-1">{{ $banner->news->title }}</p>
                  <div class="flex items-center gap-1 mt-1">
                    <img src="{{ asset('img/User.png') }}" alt="" class="w-5">
                    <p class="text-white text-xs">{{ $banner->news->author->name }}</p>
                  </div>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  {{-- Berita Unggulan --}}
  <div class="flex flex-col px-4 lg:px-14 mt-10">
    <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
      <div class="font-bold text-2xl text-center md:text-left">
        <p>Berita Unggulan</p>
        <p>Untuk Kamu</p>
      </div>
      <a href="{{ route('news.index') }}" class="bg-primary px-5 py-2 rounded-full text-white font-semibold mt-4 md:mt-0 h-fit">
        Lihat Semua
      </a>
    </div>
    <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
      @forelse($featuredNews as $item)
        <a href="{{ route('news.show', $item->slug) }}">
          <div class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out">
            <div class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute">{{ $item->category->title }}</div>
            <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="w-full rounded-xl mb-3 h-40 object-cover">
            <p class="font-bold text-base mb-1">{{ $item->title }}</p>
            <p class="text-slate-400">{{ $item->created_at->translatedFormat('d F Y') }}</p>
          </div>
        </a>
      @empty
        <p class="text-slate-400">Belum ada berita unggulan.</p>
      @endforelse
    </div>
  </div>

  {{-- Berita Terbaru --}}
  <div class="flex flex-col px-4 lg:px-14 mt-10">
    <div class="font-bold text-2xl mb-6">Berita Terbaru</div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
      @foreach($latestNews as $item)
        <a href="{{ route('news.show', $item->slug) }}"
          class="relative flex flex-col h-fit md:flex-row gap-3 border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer">
          <div class="bg-primary text-white rounded-full w-fit px-4 py-1 font-normal ml-2 mt-2 absolute text-sm">{{ $item->category->title }}</div>
          <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="rounded-xl w-full md:w-48 md:max-h-48 object-cover">
          <div class="mt-2 md:mt-0">
            <p class="font-semibold text-lg">{{ $item->title }}</p>
            <p class="text-slate-400 mt-3 text-sm font-normal">{{ Str::limit(strip_tags($item->content), 120) }}</p>
          </div>
        </a>
      @endforeach
    </div>
  </div>

  {{-- Author --}}
  <div class="flex flex-col px-4 md:px-10 lg:px-14 mt-10">
    <div class="flex flex-col md:flex-row justify-between items-center w-full mb-6">
      <div class="font-bold text-2xl text-center md:text-left">
        <p>Kenali Author</p>
        <p>Terbaik Dari Kami</p>
      </div>
      <a href="/admin/register" class="bg-primary px-5 py-2 rounded-full text-white font-semibold mt-4 md:mt-0 h-fit">
        Gabung Menjadi Author
      </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
      @foreach($topAuthors as $author)
        <a href="{{ route('author.show', $author->username) }}">
          <div class="flex flex-col items-center border border-slate-200 px-4 py-8 rounded-2xl hover:border-primary hover:cursor-pointer">
            <img src="{{ $author->avatar_url }}" alt="{{ $author->username }}" class="rounded-full w-24 h-24 object-cover">
            <p class="font-bold text-xl mt-4">{{ $author->name }}</p>
            <p class="text-slate-400">{{ $author->news_count }} Berita</p>
          </div>
        </a>
      @endforeach
    </div>
  </div>

  {{-- Pilihan / Random News --}}
  <div class="flex flex-col px-4 lg:px-14 mt-10 mb-10">
    <div class="font-bold text-2xl mb-6">Pilihan Author</div>
    <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
      @foreach($randomNews as $item)
        <a href="{{ route('news.show', $item->slug) }}">
          <div class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out">
            <div class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute">{{ $item->category->title }}</div>
            <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="w-full rounded-xl mb-3 h-40 object-cover">
            <p class="font-bold text-base mb-1">{{ $item->title }}</p>
            <p class="text-slate-400">{{ $item->created_at->translatedFormat('d F Y') }}</p>
          </div>
        </a>
      @endforeach
    </div>
  </div>

@endsection

@push('scripts')
<script src="{{ asset('js/swiper.js') }}"></script>
@endpush

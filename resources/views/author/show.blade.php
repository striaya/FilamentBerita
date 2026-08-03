@extends('layouts.app')

@section('title', $author->name . ' - Moco')

@section('content')
  {{-- Header Profil --}}
  <div class="flex gap-4 items-center mb-10 text-white p-10 bg-cover bg-center"
    style="background-image: url('{{ asset('img/bg-profile.png') }}')">
    <img src="{{ $author->avatar_url }}" alt="{{ $author->name }}" class="rounded-full w-24 h-24 object-cover border-2 border-white">
    <div>
      <p class="font-bold text-lg lg:text-2xl">{{ $author->name }}</p>
      <p class="text-sm lg:text-base mt-2 max-w-xl">{{ $author->bio }}</p>
      <p class="text-sm mt-2 opacity-80">{{ $author->news_count }} Berita Dipublikasikan</p>
    </div>
  </div>

  {{-- Berita oleh author --}}
  <div class="flex flex-col px-4 lg:px-14 mt-4">
    <p class="font-bold text-xl lg:text-2xl mb-6">Berita dari {{ $author->name }}</p>

    <div class="grid sm:grid-cols-1 gap-5 lg:grid-cols-4">
      @forelse($news as $item)
        <a href="{{ route('news.show', $item->slug) }}">
          <div class="border border-slate-200 p-3 rounded-xl hover:border-primary hover:cursor-pointer transition duration-300 ease-in-out">
            <div class="bg-primary text-white rounded-full w-fit px-5 py-1 font-normal ml-2 mt-2 text-sm absolute">{{ $item->category->title }}</div>
            <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="w-full rounded-xl mb-3 h-40 object-cover">
            <p class="font-bold text-base mb-1">{{ $item->title }}</p>
            <p class="text-slate-400">{{ $item->created_at->translatedFormat('d F Y') }}</p>
          </div>
        </a>
      @empty
        <p class="text-slate-400 col-span-4">Author ini belum mempublikasikan berita.</p>
      @endforelse
    </div>

    {{ $news->links('vendor.pagination.custom') }}
  </div>
@endsection

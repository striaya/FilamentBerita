@extends('layouts.app')

@section('title', $pageTitle . ' - Moco')

@section('content')
  <div class="flex flex-col px-4 lg:px-14 mt-10">
    <div class="font-bold text-xl lg:text-2xl mb-6">
      @if($search)
        <p>Hasil Pencarian untuk "{{ $search }}"</p>
      @else
        <p>{{ $pageTitle }}</p>
      @endif
    </div>

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
        <p class="text-slate-400 col-span-4">Tidak ada berita ditemukan.</p>
      @endforelse
    </div>

    {{ $news->links('vendor.pagination.custom') }}
  </div>
@endsection

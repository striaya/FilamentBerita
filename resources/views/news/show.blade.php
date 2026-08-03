@extends('layouts.app')

@section('title', $newsItem->title . ' - Moco')

@section('content')
  <div class="flex flex-col px-4 lg:px-14 mt-10">
    <div class="font-bold text-xl lg:text-2xl mb-6 text-center lg:text-left">
      <p>{{ $newsItem->title }}</p>
    </div>
    <div class="flex flex-col lg:flex-row w-full gap-10">
      {{-- Konten Utama --}}
      <div class="lg:w-8/12">
        <img src="{{ $newsItem->thumbnail_url }}" alt="{{ $newsItem->title }}" class="w-full max-h-96 rounded-xl object-cover">
        <div class="flex items-center gap-2 mt-4 text-sm text-slate-400">
          <span>{{ $newsItem->category->title }}</span>
          <span>&bull;</span>
          <span>{{ $newsItem->created_at->translatedFormat('d F Y') }}</span>
          <span>&bull;</span>
          <span>{{ $newsItem->author->name }}</span>
        </div>
        <div class="mt-6 text-base lg:text-xl leading-relaxed text-justify">
          {!! $newsItem->content !!}
        </div>
      </div>

      {{-- Berita Terbaru Lainnya --}}
      <div class="lg:w-4/12 flex flex-col gap-10">
        <div class="sticky top-24 z-40">
          <p class="font-bold mb-8 text-xl lg:text-2xl">Berita Terbaru Lainnya</p>
          <div class="gap-5 flex flex-col">
            @foreach($latestNews as $item)
              <a href="{{ route('news.show', $item->slug) }}">
                <div class="flex gap-3 border border-slate-300 hover:border-primary p-3 rounded-xl">
                  <div class="flex gap-3 flex-col lg:flex-row">
                    <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="max-h-36 rounded-xl object-cover">
                    <div>
                      <p class="font-bold text-sm lg:text-base">{{ $item->title }}</p>
                      <p class="text-slate-400 mt-2 text-sm lg:text-xs">{{ Str::limit(strip_tags($item->content), 80) }}</p>
                    </div>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Author --}}
  <div class="flex flex-col gap-4 mb-10 p-4 lg:p-10 lg:px-14 w-full lg:w-2/3">
    <p class="font-semibold text-xl lg:text-2xl mb-2">Author</p>
    <a href="{{ route('author.show', $newsItem->author->username) }}">
      <div class="flex flex-col lg:flex-row gap-4 items-center border border-slate-300 rounded-xl p-6 lg:p-8 hover:border-primary transition">
        <img src="{{ $newsItem->author->avatar_url }}" alt="{{ $newsItem->author->name }}" class="rounded-full w-24 lg:w-28 h-24 lg:h-28 object-cover border-2 border-primary">
        <div class="text-center lg:text-left">
          <p class="font-bold text-lg lg:text-xl">{{ $newsItem->author->name }}</p>
          <p class="text-sm lg:text-base leading-relaxed">
            {{ Str::limit($newsItem->author->bio, 200) }}
          </p>
        </div>
      </div>
    </a>
  </div>
@endsection

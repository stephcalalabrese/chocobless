{{-- ================================================================
     resources/views/shop/catalog.blade.php
     ================================================================ --}}
@extends('shop.layout')
@section('title', isset($category) ? $category->nom.' — ChocoBless' : 'Catálogo — ChocoBless')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">

  {{-- Header --}}
  <div class="mb-10">
    <p class="text-gold text-xs tracking-widest uppercase mb-2" style="letter-spacing:0.2em;">ChocoBless</p>
    <h1 class="font-serif text-4xl text-choco">{{ isset($category) ? $category->nom : 'Todo el catálogo' }}</h1>
    @isset($category)
      @if($category->description)
        <p class="text-choco/60 mt-2 font-light">{{ $category->description }}</p>
      @endif
    @endisset
  </div>

  <div class="flex flex-col md:flex-row gap-8">

    {{-- Sidebar categorías --}}
    <aside class="md:w-56 shrink-0">
      <p class="text-xs font-semibold text-choco/40 uppercase tracking-widest mb-3" style="letter-spacing:0.15em;">Categorías</p>
      <ul class="space-y-1">
        <li>
          <a href="{{ route('shop.catalog') }}"
             class="block px-3 py-2 rounded-lg text-sm transition-colors {{ !isset($category) ? 'bg-gold/20 text-choco font-medium' : 'text-choco/70 hover:bg-gold/10 hover:text-choco' }}">
            Todos los productos
          </a>
        </li>
        @foreach($categories as $cat)
        <li>
          <a href="{{ route('shop.category', $cat->slug) }}"
             class="block px-3 py-2 rounded-lg text-sm transition-colors {{ isset($category) && $category->id === $cat->id ? 'bg-gold/20 text-choco font-medium' : 'text-choco/70 hover:bg-gold/10 hover:text-choco' }}">
            {{ $cat->nom }}
          </a>
        </li>
        @endforeach
      </ul>
    </aside>

    {{-- Grid productos --}}
    <div class="flex-1">
      <div class="grid grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($products as $product)
          @include('shop.partials.product-card', ['product' => $product])
        @empty
          <div class="col-span-3 text-center py-20 text-choco/40">
            <span class="text-4xl block mb-3">🍫</span>
            <p class="font-serif text-xl">No hay productos disponibles</p>
          </div>
        @endforelse
      </div>
      <div class="mt-8">{{ $products->links() }}</div>
    </div>
  </div>
</div>
@endsection

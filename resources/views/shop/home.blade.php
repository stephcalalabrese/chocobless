@extends('shop.layout')
@section('title', 'ChocoBless — Fresas con chocolate y delicias artesanales en Bogotá')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative bg-choco overflow-hidden min-h-screen flex items-center">
  {{-- Textura --}}
  <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"60\" height=\"60\"><circle cx=\"30\" cy=\"30\" r=\"2\" fill=\"%23c9a84c\"/></svg>');"></div>

  <div class="max-w-6xl mx-auto px-4 py-24 grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10">
    <div>
      <p class="text-gold text-xs tracking-widest uppercase mb-4 fade-up" style="letter-spacing:0.2em;">Delicias artesanales · Bogotá</p>
      <h1 class="font-serif text-5xl md:text-7xl text-cream leading-tight mb-6 fade-up-2">
        El lujo<br>del <span class="gold-text italic">chocolate</span><br>para ti
      </h1>
      <p class="text-cream/70 text-lg font-light mb-10 leading-relaxed fade-up-3">
        Fresas con chocolate, osos, corazones y bombones artesanales. Cada pieza es una obra de arte pensada para endulzar tus momentos especiales.
      </p>
      <div class="flex flex-wrap gap-4 fade-up-3">
        <a href="{{ route('shop.catalog') }}" class="btn-gold px-8 py-3.5 rounded-full text-sm">
          Ver catálogo
        </a>
        <a href="{{ route('order.whatsapp') }}" target="_blank"
           class="flex items-center gap-2 border border-gold/40 text-gold hover:border-gold hover:bg-gold/10 px-8 py-3.5 rounded-full text-sm transition-all">
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          Pedir por WhatsApp
        </a>
      </div>
    </div>

    {{-- Grille de produits vedettes --}}
    <div class="grid grid-cols-2 gap-4">
      @foreach($en_vedette->take(4) as $p)
      <a href="{{ route('shop.product', $p->slug) }}"
         class="group relative bg-cream/10 rounded-2xl overflow-hidden aspect-square flex items-center justify-center hover:bg-cream/20 transition-all duration-300 border border-gold/10 hover:border-gold/30">
        @if($p->image_principale)
          <img src="/storage/{{ $p->image_principale }}"
               alt="{{ $p->nom }}"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
          <span class="text-5xl">🍫</span>
        @endif
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-choco/90 to-transparent p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
          <p class="text-cream text-xs font-medium truncate">{{ $p->nom }}</p>
          @php $pmin = $p->variants->min('prix'); @endphp
          <p class="text-gold text-xs">Desde {{ number_format($pmin,0,',','.') }} COP</p>
        </div>
      </a>
      @endforeach
    </div>
  </div>

  {{-- Scroll indicator --}}
  <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-gold/40">
    <span class="text-xs tracking-widest uppercase" style="font-size:10px; letter-spacing:0.2em;">Explorar</span>
    <div class="w-px h-12 bg-gradient-to-b from-gold/40 to-transparent"></div>
  </div>
</section>

{{-- ===== CATEGORÍAS ===== --}}
<section class="max-w-6xl mx-auto px-4 py-20">
  <div class="text-center mb-12">
    <p class="text-gold text-xs tracking-widest uppercase mb-3" style="letter-spacing:0.2em;">Nuestro catálogo</p>
    <h2 class="font-serif text-4xl text-choco">Escoge tu delicia</h2>
  </div>
  <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
    @foreach($categories as $cat)
    <a href="{{ route('shop.category', $cat->slug) }}"
       class="group relative bg-cream-dark rounded-2xl overflow-hidden border border-gold/20 hover:border-gold/50 transition-all duration-300 p-6 flex flex-col items-center gap-3 hover:shadow-xl hover:shadow-gold/10">
      <span class="text-3xl">
        @switch($cat->slug)
          @case('fraises-chocolat') 🍓 @break
          @case('coeurs-ours') 🐻 @break
          @case('cakes-pop-sucettes') 🍭 @break
          @case('chocolats-ronds') 🍪 @break
          @case('coffrets-cadeaux') 🎁 @break
          @default 🍫 @break
        @endswitch
      </span>
      <p class="font-serif text-lg text-choco text-center group-hover:text-gold transition-colors">{{ $cat->nom }}</p>
      <p class="text-xs text-choco/50">
        {{ $cat->products_count ?? $cat->products()->where('actif',1)->count() }} productos
      </p>
      <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-gold to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    </a>
    @endforeach
  </div>
</section>

{{-- ===== PRODUCTOS EN VEDETTE ===== --}}
<section class="bg-cream-dark py-20">
  <div class="max-w-6xl mx-auto px-4">
    <div class="flex items-end justify-between mb-12">
      <div>
        <p class="text-gold text-xs tracking-widest uppercase mb-3" style="letter-spacing:0.2em;">Lo más especial</p>
        <h2 class="font-serif text-4xl text-choco">Productos destacados</h2>
      </div>
      <a href="{{ route('shop.catalog') }}" class="text-sm text-gold hover:text-choco transition-colors border-b border-gold/40 pb-1">
        Ver todo →
      </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="featured-grid">
      @foreach($en_vedette as $p)
      @include('shop.partials.product-card', ['product' => $p])
      @endforeach
    </div>
  </div>
</section>

{{-- ===== BANNER WHATSAPP ===== --}}
<section class="bg-choco py-16">
  <div class="max-w-4xl mx-auto px-4 text-center">
    <p class="text-gold text-xs tracking-widest uppercase mb-4" style="letter-spacing:0.2em;">¿Tienes dudas?</p>
    <h2 class="font-serif text-4xl text-cream mb-6">Pide por WhatsApp<br><span class="gold-text italic">en segundos</span></h2>
    <p class="text-cream/60 mb-8 font-light">Escríbenos, te asesoramos y preparamos tu pedido con todo el amor.</p>
    <a href="https://wa.me/573117899152?text=Hola%20ChocoBless!%20Quiero%20hacer%20un%20pedido%20🍫"
       target="_blank"
       class="inline-flex items-center gap-3 btn-gold px-10 py-4 rounded-full text-base">
      <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      Chatear ahora — 311 789 9152
    </a>
  </div>
</section>

{{-- ===== GARANTÍAS ===== --}}
<section class="max-w-6xl mx-auto px-4 py-16">
  <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
    @foreach([
      ['🍫','Chocolate artesanal','Ingredientes de primera calidad'],
      ['✨','Hecho con amor','Cada pieza preparada a mano'],
      ['🚀','Entrega rápida','Bogotá y alrededores'],
      ['🎁','Empaque especial','Presentación de lujo incluida'],
    ] as $feat)
    <div class="p-6 rounded-2xl border border-gold/20 hover:border-gold/40 transition-colors">
      <span class="text-3xl block mb-3">{{ $feat[0] }}</span>
      <p class="font-serif text-base text-choco mb-1">{{ $feat[1] }}</p>
      <p class="text-xs text-choco/50 font-light">{{ $feat[2] }}</p>
    </div>
    @endforeach
  </div>
</section>

@endsection

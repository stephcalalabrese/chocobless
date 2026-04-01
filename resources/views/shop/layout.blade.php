<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'ChocoBless — Delicias a base de chocolate')</title>
  <meta name="description" content="@yield('description', 'Fresas con chocolate, corazones, osos y más. Endulzando tu día en Bogotá.')">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            choco:  { DEFAULT:'#3d1c02', light:'#6b3a00', dark:'#1e0d00' },
            gold:   { DEFAULT:'#c9a84c', light:'#e2c97e', dark:'#9c7c2a' },
            cream:  { DEFAULT:'#fdf5ee', dark:'#f5e6d3' },
          },
          fontFamily: {
            serif: ['"Cormorant Garamond"', 'Georgia', 'serif'],
            sans:  ['"Jost"', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <style>
    body { font-family: 'Jost', sans-serif; background: #fdf5ee; color: #3d1c02; }
    .font-serif { font-family: 'Cormorant Garamond', Georgia, serif; }
    .gold-text { background: linear-gradient(135deg, #c9a84c, #e2c97e, #9c7c2a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .btn-gold { background: linear-gradient(135deg, #c9a84c, #e2c97e); color: #1e0d00; font-weight: 500; letter-spacing: 0.05em; transition: all 0.3s; }
    .btn-gold:hover { background: linear-gradient(135deg, #9c7c2a, #c9a84c); transform: translateY(-1px); box-shadow: 0 8px 25px rgba(201,168,76,0.4); }
    .btn-choco { background: #3d1c02; color: #e2c97e; font-weight: 500; letter-spacing: 0.05em; transition: all 0.3s; }
    .btn-choco:hover { background: #1e0d00; transform: translateY(-1px); box-shadow: 0 8px 25px rgba(61,28,2,0.4); }
    .product-card { transition: transform 0.3s, box-shadow 0.3s; }
    .product-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(61,28,2,0.15); }
    .nav-link { position: relative; }
    .nav-link::after { content:''; position:absolute; bottom:-2px; left:0; width:0; height:1px; background: #c9a84c; transition: width 0.3s; }
    .nav-link:hover::after { width: 100%; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    .fade-up { animation: fadeUp 0.6s ease forwards; }
    .fade-up-2 { animation: fadeUp 0.6s ease 0.15s forwards; opacity:0; }
    .fade-up-3 { animation: fadeUp 0.6s ease 0.3s forwards; opacity:0; }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #fdf5ee; }
    ::-webkit-scrollbar-thumb { background: #c9a84c; border-radius: 3px; }
  </style>
  @stack('styles')
</head>
<body>

{{-- ===================== NAVBAR ===================== --}}
<nav class="sticky top-0 z-50 bg-cream/95 backdrop-blur-sm border-b border-gold/20">
  <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">

    {{-- Logo --}}
	<a href="{{ route('shop.home') }}" class="flex items-center">
	  <img src="/images/logo-chocobless.png" alt="ChocoBless" style="height:50px; width:auto;">
    </a>
    {{-- Navigation --}}
    <div class="hidden md:flex items-center gap-8 text-sm font-light tracking-wide">
      <a href="{{ route('shop.home') }}" class="nav-link text-choco hover:text-gold transition-colors">Inicio</a>
      <a href="{{ route('shop.catalog') }}" class="nav-link text-choco hover:text-gold transition-colors">Catálogo</a>
      @foreach(\App\Models\Category::where('actif',1)->orderBy('ordre')->take(4)->get() as $cat)
        <a href="{{ route('shop.category', $cat->slug) }}" class="nav-link text-choco hover:text-gold transition-colors">{{ $cat->nom }}</a>
      @endforeach
    </div>

    {{-- Carrito + WhatsApp --}}
    <div class="flex items-center gap-4">
      <a href="https://wa.me/573117899152" target="_blank"
         class="hidden md:flex items-center gap-2 text-xs text-choco hover:text-gold transition-colors">
        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        311 789 9152
      </a>

      <a href="{{ route('cart.show') }}" class="relative flex items-center gap-2 btn-gold px-4 py-2 rounded-full text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 7H4l1-7z"/>
        </svg>
        <span>Carrito</span>
        @php $cartCount = array_sum(array_column(session()->get('cart',[]),'cantidad')); @endphp
        @if($cartCount > 0)
          <span class="absolute -top-2 -right-2 w-5 h-5 bg-choco text-gold text-xs rounded-full flex items-center justify-center font-semibold">
            {{ $cartCount }}
          </span>
        @endif
      </a>
    </div>
  </div>
</nav>

{{-- ===================== CONTENT ===================== --}}
<main>
  @if(session('success'))
    <div class="max-w-6xl mx-auto px-4 mt-4">
      <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
        ✓ {{ session('success') }}
      </div>
    </div>
  @endif
  @if(session('error'))
    <div class="max-w-6xl mx-auto px-4 mt-4">
      <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
        {{ session('error') }}
      </div>
    </div>
  @endif

  @yield('content')
</main>

{{-- ===================== FOOTER ===================== --}}
<footer class="bg-choco text-cream mt-20">
  <div class="max-w-6xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">
    <div>
      <div class="flex items-center gap-3 mb-4">
        <span class="text-2xl">🍫</span>
        <div>
          <p class="font-serif text-xl text-gold">ChocoBless</p>
          <p class="text-xs text-gold/60 tracking-widest uppercase" style="font-size:10px;">Endulzando tu día</p>
        </div>
      </div>
      <p class="text-sm text-cream/70 leading-relaxed">Delicias artesanales a base de chocolate. Fresas, corazones, osos y mucho más para endulzar cada momento especial.</p>
    </div>
    <div>
      <p class="font-semibold text-gold mb-4 tracking-wide text-sm uppercase">Catálogo</p>
      <ul class="space-y-2 text-sm text-cream/70">
        @foreach(\App\Models\Category::where('actif',1)->orderBy('ordre')->get() as $cat)
          <li><a href="{{ route('shop.category', $cat->slug) }}" class="hover:text-gold transition-colors">{{ $cat->nom }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <p class="font-semibold text-gold mb-4 tracking-wide text-sm uppercase">Contáctanos</p>
      <div class="space-y-3 text-sm text-cream/70">
        <a href="https://wa.me/573117899152" target="_blank"
           class="flex items-center gap-3 hover:text-gold transition-colors">
          <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          311 789 9152
        </a>
        <p class="flex items-center gap-3">
          <svg class="w-5 h-5 shrink-0 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          Bogotá, Colombia
        </p>
      </div>
    </div>
  </div>
  <div class="border-t border-gold/10 py-4 text-center text-xs text-cream/40">
    © {{ date('Y') }} ChocoBless · Diana Suarez · Todos los derechos reservados
  </div>
</footer>

@stack('scripts')
</body>
</html>

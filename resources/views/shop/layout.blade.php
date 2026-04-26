<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
      <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'ChocoBless — Delicias a base de chocolate')</title>
  <meta name="description" content="@yield('description', 'Fresas con chocolate, corazones, osos y más. Endulzando tu día en Bogotá.')">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
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
    :root {
      --choco:#3d1c02; --choco-light:#5c2e08; --gold:#c9a84c;
      --gold-light:#e2c97e; --cream:#fdf5ee; --cream-dark:#f5e8d8;
      --text:#2a1200; --muted:#8a6a50;
    }
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Jost',sans-serif; background:#fdf5ee; color:#3d1c02; overflow-x:hidden; }
    a { text-decoration:none; color:inherit; }
    img { display:block; max-width:100%; }

    /* ── Navbar ── */
    .site-nav {
      position:sticky; top:0; z-index:100;
      background:#3d1c02;
      border-bottom:1px solid rgba(201,168,76,.2);
      transition:box-shadow .35s;
    }
    .site-nav.scrolled { box-shadow:0 4px 32px rgba(0,0,0,.3); }
    .nav-inner {
      max-width:1180px; margin:0 auto; padding:0 24px;
      display:flex; align-items:center; justify-content:space-between;
      height:68px;
    }
    .nav-logo img { height:42px; width:auto; }
    .nav-links { display:flex; align-items:center; gap:32px; }
    .nav-links a {
      font-size:12px; font-weight:500; letter-spacing:.1em;
      text-transform:uppercase; color:rgba(253,245,238,.7);
      transition:color .25s; position:relative;
    }
    .nav-links a::after {
      content:''; position:absolute; bottom:-4px; left:0;
      width:0; height:1px; background:#c9a84c; transition:width .3s;
    }
    .nav-links a:hover { color:#c9a84c; }
    .nav-links a:hover::after { width:100%; }
    .nav-actions { display:flex; align-items:center; gap:12px; }
    .nav-wa {
      display:flex; align-items:center; gap:6px;
      font-size:12px; color:rgba(253,245,238,.65);
      transition:color .25s;
    }
    .nav-wa:hover { color:#c9a84c; }
    .nav-cart {
      display:flex; align-items:center; gap:8px;
      background:#c9a84c; color:#1e0d00;
      font-size:12px; font-weight:600; letter-spacing:.08em; text-transform:uppercase;
      padding:9px 20px; border-radius:4px;
      transition:background .25s, transform .25s;
      position:relative;
    }
    .nav-cart:hover { background:#e2c97e; transform:translateY(-1px); }
    .nav-cart-badge {
      position:absolute; top:-6px; right:-6px;
      width:18px; height:18px; border-radius:50%;
      background:#3d1c02; color:#e2c97e;
      font-size:10px; font-weight:700;
      display:flex; align-items:center; justify-content:center;
    }
    .nav-mobile-btn {
      display:none; background:none; border:none;
      cursor:pointer; color:#fdf5ee; padding:4px;
    }
    @media(max-width:768px){
      .nav-links { display:none; }
      .nav-wa { display:none; }
      .nav-mobile-btn { display:block; }
    }

    /* ── Mobile menu ── */
    .mobile-menu {
      display:none;
      flex-direction:column;
      background:#2a1200;
      border-top:1px solid rgba(201,168,76,.15);
      overflow:hidden;
      max-height:0;
      transition:max-height .35s ease, padding .35s ease;
    }
    .mobile-menu.open {
      display:flex;
      max-height:500px;
      padding:8px 0 16px;
    }
    .mobile-menu a {
      font-size:13px; font-weight:500; letter-spacing:.08em;
      text-transform:uppercase; color:rgba(253,245,238,.7);
      padding:13px 24px;
      border-bottom:1px solid rgba(201,168,76,.07);
      transition:color .2s, background .2s;
      display:flex; align-items:center; gap:10px;
    }
    .mobile-menu a:last-child { border-bottom:none; }
    .mobile-menu a:hover { color:#c9a84c; background:rgba(201,168,76,.06); }
    .mobile-menu .mobile-wa {
      color:#25D366;
      margin-top:4px;
      border-top:1px solid rgba(201,168,76,.1);
      border-bottom:none;
    }
    .mobile-menu .mobile-wa:hover { color:#1ebe5b; }

    /* Hamburger animation */
    .nav-mobile-btn svg { transition:transform .3s; }
    .nav-mobile-btn.open svg { transform:rotate(90deg); }

    /* ── Alerts ── */
    .alert-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; padding:12px 16px; border-radius:6px; font-size:13px; }
    .alert-error   { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:12px 16px; border-radius:6px; font-size:13px; }

    /* ── Footer ── */
    .site-footer { background:#1e0d01; margin-top:80px; }
    .footer-top {
      max-width:1180px; margin:0 auto; padding:56px 24px 48px;
      display:grid; grid-template-columns:1.5fr 1fr 1fr; gap:48px;
      border-bottom:1px solid rgba(201,168,76,.12);
    }
    @media(max-width:768px){ .footer-top{ grid-template-columns:1fr; gap:32px; } }
    .footer-brand-name { font-family:'Cormorant Garamond',serif; font-size:24px; color:#c9a84c; display:block; margin-bottom:12px; }
    .footer-tagline { font-size:13px; color:rgba(253,245,238,.45); line-height:1.6; margin-bottom:20px; }
    .footer-social { display:flex; gap:10px; }
    .footer-social a {
      width:34px; height:34px; border-radius:50%;
      background:rgba(201,168,76,.12); border:1px solid rgba(201,168,76,.2);
      display:flex; align-items:center; justify-content:center;
      color:#c9a84c; font-size:14px; transition:all .25s;
    }
    .footer-social a:hover { background:#c9a84c; color:#1e0d00; transform:scale(1.1); }
    .footer-col-title { font-size:11px; font-weight:600; letter-spacing:.18em; text-transform:uppercase; color:#c9a84c; margin-bottom:18px; display:block; }
    .footer-links { list-style:none; display:flex; flex-direction:column; gap:8px; }
    .footer-links a { font-size:13px; color:rgba(253,245,238,.5); transition:color .25s; }
    .footer-links a:hover { color:#c9a84c; }
    .footer-contact-item { display:flex; align-items:center; gap:10px; font-size:13px; color:rgba(253,245,238,.5); margin-bottom:10px; }
    .footer-bottom { max-width:1180px; margin:0 auto; padding:20px 24px; display:flex; justify-content:space-between; flex-wrap:wrap; gap:8px; }
    .footer-copy { font-size:12px; color:rgba(253,245,238,.25); }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width:5px; }
    ::-webkit-scrollbar-track { background:#fdf5ee; }
    ::-webkit-scrollbar-thumb { background:#c9a84c; border-radius:3px; }
  </style>
  @stack('styles')
</head>
<body>

<nav class="site-nav" id="site-nav">
  <div class="nav-inner">

    <a href="{{ route('shop.home') }}" class="nav-logo">
      <img src="/images/logo-chocobless.png" alt="ChocoBless"
           onerror="this.style.display='none'">
    </a>

    <div class="nav-links">
      <a href="{{ route('shop.home') }}#ocasiones">Ocasiones</a>
      <a href="{{ route('shop.catalog') }}">Catálogo</a>
      <a href="{{ route('shop.nosotras') }}">Nosotras</a>
      <a href="{{ route('shop.contact') }}">Contacto</a>
    </div>

    <div class="nav-actions">
      <a href="https://wa.me/573117989152" target="_blank" class="nav-wa">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        311 798 9152
      </a>
      <a href="{{ route('cart.show') }}" class="nav-cart">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 7H4l1-7z"/></svg>
        Carrito
        @php $cartCount = array_sum(array_column(session()->get('cart',[]),'cantidad')); @endphp
        @if($cartCount > 0)
          <span class="nav-cart-badge">{{ $cartCount }}</span>
        @endif
      </a>
      <button class="nav-mobile-btn" id="mobile-btn" aria-label="Menú" aria-expanded="false">
        <svg id="icon-menu" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <line x1="3" y1="6" x2="21" y2="6"/>
          <line x1="3" y1="12" x2="21" y2="12"/>
          <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
        <svg id="icon-close" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display:none">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>

  </div>

  {{-- Mobile menu --}}
  <div id="mobile-menu" class="mobile-menu">
    <a href="{{ route('shop.home') }}">
      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
      Inicio
    </a>
    <a href="{{ route('shop.nosotras') }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        Nosotras
      </a>
      <a href="{{ route('shop.catalog') }}">
      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
      Catálogo
    </a>
    @foreach(\App\Models\Category::where('actif',1)->orderBy('ordre')->get() as $cat)
      <a href="{{ route('shop.category', $cat->slug) }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        {{ $cat->nom }}
      </a>
    @endforeach
    <a href="{{ route('cart.show') }}">
      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 7H4l1-7z"/></svg>
      Carrito
      @if($cartCount > 0)
        <span style="background:#c9a84c;color:#1e0d00;font-size:10px;font-weight:700;padding:1px 7px;border-radius:20px;margin-left:4px;">{{ $cartCount }}</span>
      @endif
    </a>
    <a href="{{ route('shop.contact') }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        Contacto
      </a>
      <a href="https://wa.me/573117989152" target="_blank" class="mobile-wa">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      WhatsApp: 311 798 9152
    </a>
  </div>

</nav>

<main>
  @if(session('success'))
    <div style="max-width:1180px; margin:16px auto; padding:0 24px;">
      <div class="alert-success">✓ {{ session('success') }}</div>
    </div>
  @endif
  @if(session('error'))
    <div style="max-width:1180px; margin:16px auto; padding:0 24px;">
      <div class="alert-error">{{ session('error') }}</div>
    </div>
  @endif
  @yield('content')
</main>

<footer class="site-footer">
  <div class="footer-top">

    <div>
      <span class="footer-brand-name">ChocoBless</span>
      <p class="footer-tagline">Delicias artesanales a base de chocolate, hechas con amor en Bogotá para hacer tus momentos únicos e inolvidables.</p>
      <div class="footer-social">
        <a href="https://instagram.com/chocobless" target="_blank" aria-label="Instagram">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        </a>
        <a href="https://wa.me/573117989152" target="_blank" aria-label="WhatsApp">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        </a>
      </div>
    </div>

    <div>
      <span class="footer-col-title">Catálogo</span>
      <ul class="footer-links">
        @foreach(\App\Models\Category::where('actif',1)->orderBy('ordre')->get() as $cat)
          <li><a href="{{ route('shop.category', $cat->slug) }}">{{ $cat->nom }}</a></li>
        @endforeach
      </ul>
    </div>

    <div>
      <span class="footer-col-title">Contáctanos</span>
      <div class="footer-contact-item">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#c9a84c;flex-shrink:0"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        <a href="https://wa.me/573117989152" target="_blank" style="color:rgba(253,245,238,.5); transition:color .25s;" onmouseover="this.style.color='#c9a84c'" onmouseout="this.style.color='rgba(253,245,238,.5)'">311 798 9152</a>
      </div>
      <div class="footer-contact-item">
        <svg width="16" height="16" fill="none" stroke="#c9a84c" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <span>Bogotá, Colombia</span>
      </div>
    </div>

  </div>
  <div class="footer-bottom">
    <p class="footer-copy">© {{ date('Y') }} ChocoBless · Diana Suarez · Todos los derechos reservados</p>
  </div>
</footer>

<script>
  // Scroll shadow
  const nav = document.getElementById('site-nav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 40);
  }, { passive: true });

  // Mobile menu toggle
  const mobileBtn  = document.getElementById('mobile-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  const iconMenu   = document.getElementById('icon-menu');
  const iconClose  = document.getElementById('icon-close');

  mobileBtn.addEventListener('click', () => {
    const isOpen = mobileMenu.classList.toggle('open');
    mobileBtn.setAttribute('aria-expanded', isOpen);
    iconMenu.style.display  = isOpen ? 'none'  : 'block';
    iconClose.style.display = isOpen ? 'block' : 'none';
  });

  // Close menu when clicking a link
  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      mobileMenu.classList.remove('open');
      iconMenu.style.display  = 'block';
      iconClose.style.display = 'none';
      mobileBtn.setAttribute('aria-expanded', 'false');
    });
  });

  // Close menu when clicking outside
  document.addEventListener('click', (e) => {
    if (!nav.contains(e.target)) {
      mobileMenu.classList.remove('open');
      iconMenu.style.display  = 'block';
      iconClose.style.display = 'none';
      mobileBtn.setAttribute('aria-expanded', 'false');
    }
  });
</script>

@stack('scripts')
</body>
</html>

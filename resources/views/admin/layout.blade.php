<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','Back-office') — ChocoBless</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex">
<aside class="w-64 shrink-0 bg-white border-r border-gray-200 flex flex-col">
  <div class="px-6 py-5 border-b border-gray-100">
    <span class="text-xl font-bold text-amber-800">🍫 ChocoBless</span>
    <p class="text-xs text-gray-400 mt-0.5">Back-office admin</p>
  </div>
  <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-amber-100 text-amber-800' : 'text-gray-600 hover:bg-gray-50' }}">📊 Tableau de bord</a>
    <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase">Catalogue</p>
    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.products*') ? 'bg-amber-100 text-amber-800' : 'text-gray-600 hover:bg-gray-50' }}">🍫 Produits</a>
    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.categories*') ? 'bg-amber-100 text-amber-800' : 'text-gray-600 hover:bg-gray-50' }}">🏷️ Catégories</a>
    <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase">Ventes</p>
    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.orders*') ? 'bg-amber-100 text-amber-800' : 'text-gray-600 hover:bg-gray-50' }}">
      🛍️ Commandes
      @php $pending = \App\Models\Order::where('statut','en_attente')->count(); @endphp
      @if($pending > 0)<span class="ml-auto bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $pending }}</span>@endif
    </a>
    <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.customers*') ? 'bg-amber-100 text-amber-800' : 'text-gray-600 hover:bg-gray-50' }}">👥 Clients</a>
    <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.coupons*') ? 'bg-amber-100 text-amber-800' : 'text-gray-600 hover:bg-gray-50' }}">🎟️ Coupons</a>
    <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-400 uppercase">Compte</p>
    <a href="{{ route('admin.account.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.account*') ? 'bg-amber-100 text-amber-800' : 'text-gray-600 hover:bg-gray-50' }}">👤 Mon compte</a>
  </nav>
  <div class="px-4 py-4 border-t border-gray-100">
    <p class="text-sm font-medium text-gray-800 truncate">{{ $authAdmin->nom }}</p>
    <p class="text-xs text-gray-400 mb-2">{{ $authAdmin->role }}</p>
    <form method="POST" action="{{ route('admin.logout') }}">
      @csrf
      <button class="text-sm text-red-500 hover:text-red-700">→ Déconnexion</button>
    </form>
  </div>
</aside>
<div class="flex-1 flex flex-col min-h-0 overflow-hidden">
  <header class="bg-white border-b border-gray-200 px-8 py-4 shrink-0">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-xl font-semibold text-gray-800">@yield('page-title')</h1>
        @hasSection('page-subtitle')<p class="text-sm text-gray-400 mt-0.5">@yield('page-subtitle')</p>@endif
      </div>
      <div>@yield('header-actions')</div>
    </div>
  </header>
  @if(session('success'))
    <div class="mx-8 mt-4 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">✓ {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="mx-8 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">✕ {{ session('error') }}</div>
  @endif
  <main class="flex-1 overflow-y-auto px-8 py-6">@yield('content')</main>
</div>
</body>
</html>

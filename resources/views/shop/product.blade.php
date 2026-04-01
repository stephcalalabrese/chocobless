@extends('shop.layout')
@section('title', $product->nom.' — ChocoBless')
@section('description', $product->description_courte)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">

  {{-- Breadcrumb --}}
  <nav class="text-xs text-choco/40 mb-8 flex items-center gap-2">
    <a href="{{ route('shop.home') }}" class="hover:text-gold transition-colors">Inicio</a>
    <span>/</span>
    <a href="{{ route('shop.catalog') }}" class="hover:text-gold transition-colors">Catálogo</a>
    <span>/</span>
    <a href="{{ route('shop.category', $product->category->slug) }}" class="hover:text-gold transition-colors">{{ $product->category->nom }}</a>
    <span>/</span>
    <span class="text-choco">{{ $product->nom }}</span>
  </nav>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">

    {{-- Imagen --}}
    <div class="sticky top-24">
      <div class="aspect-square rounded-3xl overflow-hidden bg-cream-dark border border-gold/20">
        @if($product->image_principale)
          <img src="/storage/{{ $product->image_principale }}"
               alt="{{ $product->nom }}"
               class="w-full h-full object-cover"
               id="main-image">
        @else
          <div class="w-full h-full flex items-center justify-center text-8xl">🍫</div>
        @endif
      </div>
      @if($product->images->count() > 0)
      <div class="flex gap-3 mt-4">
        @foreach($product->images as $img)
        <button onclick="document.getElementById('main-image').src='/storage/{{ $img->url_image }}'"
                class="w-16 h-16 rounded-xl overflow-hidden border-2 border-gold/20 hover:border-gold transition-colors">
          <img src="/storage/{{ $img->url_image }}" alt="{{ $img->alt_text }}" class="w-full h-full object-cover">
        </button>
        @endforeach
      </div>
      @endif
    </div>

    {{-- Détails --}}
    <div>
      <p class="text-gold text-xs tracking-widest uppercase mb-2" style="letter-spacing:0.15em;">{{ $product->category->nom }}</p>
      <h1 class="font-serif text-4xl text-choco mb-4 leading-tight">{{ $product->nom }}</h1>

      @if($product->description_courte)
        <p class="text-choco/70 font-light mb-6 leading-relaxed">{{ $product->description_courte }}</p>
      @endif

      {{-- Variantes & precio --}}
      <div class="mb-6">
        <p class="text-sm font-medium text-choco mb-3">Elige tu opción:</p>
        <div class="space-y-2" id="variantes">
          @foreach($product->variants as $v)
          <label class="flex items-center justify-between p-4 rounded-xl border border-gold/20 cursor-pointer hover:border-gold/60 transition-all has-[:checked]:border-gold has-[:checked]:bg-gold/10">
            <div class="flex items-center gap-3">
              <input type="radio" name="variante" value="{{ $v->id }}"
                     data-price="{{ (float) $v->prix }}"
		     data-label="{{ $v->label }}"
                     class="accent-gold"
                     {{ $loop->first ? 'checked' : '' }}>
              <span class="text-sm text-choco font-medium">{{ $v->label }}</span>
            </div>
            <div class="text-right">
              @if($v->prix_promo)
                <span class="text-xs text-choco/40 line-through block">{{ number_format($v->prix, 0, ',', '.') }}</span>
                <span class="text-base font-semibold text-gold">{{ number_format($v->prix_promo, 0, ',', '.') }} COP</span>
              @else
                <span class="text-base font-semibold text-choco">{{ number_format($v->prix, 0, ',', '.') }} COP</span>
              @endif
            </div>
          </label>
          @endforeach
        </div>
      </div>

      {{-- Cantidad --}}
      <div class="flex items-center gap-4 mb-6">
        <p class="text-sm font-medium text-choco">Cantidad:</p>
        <div class="flex items-center border border-gold/30 rounded-xl overflow-hidden">
          <button onclick="updateQty(-1)" class="w-10 h-10 text-choco hover:bg-gold/20 transition-colors flex items-center justify-center text-lg">−</button>
          <input type="number" id="qty" value="1" min="1" max="20"
                 class="w-12 text-center text-sm font-medium bg-transparent border-none outline-none text-choco">
          <button onclick="updateQty(1)" class="w-10 h-10 text-choco hover:bg-gold/20 transition-colors flex items-center justify-center text-lg">+</button>
        </div>
        <p class="text-sm text-choco/50 font-light">Total: <span id="price-display" class="font-semibold text-choco">—</span></p>
      </div>

      {{-- Botones --}}
      <div class="space-y-3 mb-8">
        <form action="{{ route('cart.add') }}" method="POST" id="add-cart-form">
          @csrf
          <input type="hidden" name="variante_id" id="variante_id_input">
          <input type="hidden" name="cantidad" id="cantidad_input">
          <button type="submit" class="btn-gold w-full py-4 rounded-full text-sm flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 7H4l1-7z"/>
            </svg>
            Agregar al carrito
          </button>
        </form>

        <a href="{{ route('order.whatsapp') }}" target="_blank"
           class="btn-choco w-full py-4 rounded-full text-sm flex items-center justify-center gap-2">
          <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          Pedir por WhatsApp
        </a>
      </div>

      {{-- Descripción completa --}}
      @if($product->description)
      <div class="border-t border-gold/20 pt-6">
        <p class="text-sm font-medium text-choco mb-3">Descripción</p>
        <p class="text-sm text-choco/70 font-light leading-relaxed">{{ $product->description }}</p>
      </div>
      @endif
    </div>
  </div>

  {{-- Productos relacionados --}}
  @if($relacionados->count() > 0)
  <div class="mt-20">
    <h2 class="font-serif text-3xl text-choco mb-8">También te puede gustar</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
      @foreach($relacionados as $p)
        @include('shop.partials.product-card', ['product' => $p])
      @endforeach
    </div>
  </div>
  @endif
</div>

@push('scripts')
<script>
  function updateDisplay() {
    const selected = document.querySelector('input[name="variante"]:checked');
    if (!selected) return;
    const qty = parseInt(document.getElementById('qty').value) || 1;
    const price = parseFloat(selected.getAttribute('data-price')) || 0;
    const total = price * qty;
    document.getElementById('price-display').textContent =
      new Intl.NumberFormat('es-CO').format(total) + ' COP';
    document.getElementById('variante_id_input').value = selected.value;
    document.getElementById('cantidad_input').value = qty;
  }

  function updateQty(delta) {
    const input = document.getElementById('qty');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > 20) val = 20;
    input.value = val;
    updateDisplay();
  }

  document.querySelectorAll('input[name="variante"]').forEach(r => {
    r.addEventListener('change', updateDisplay);
  });
  document.getElementById('qty').addEventListener('input', updateDisplay);

  // Sélectionner automatiquement le premier radio et déclencher l'affichage
  const firstRadio = document.querySelector('input[name="variante"]');
  if (firstRadio) {
    firstRadio.checked = true;
    updateDisplay();
  }
</script>
@endpush

@endsection

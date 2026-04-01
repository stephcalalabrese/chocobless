@extends('shop.layout')
@section('title', 'Mi carrito — ChocoBless')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
  <h1 class="font-serif text-4xl text-choco mb-8">Mi carrito</h1>

  @if(empty($cart))
    <div class="text-center py-20 bg-white rounded-3xl border border-gold/20">
      <span class="text-6xl block mb-4">🛒</span>
      <p class="font-serif text-2xl text-choco mb-2">Tu carrito está vacío</p>
      <p class="text-choco/50 mb-8 font-light">¡Agrega algunos chocolates deliciosos!</p>
      <a href="{{ route('shop.catalog') }}" class="btn-gold px-8 py-3.5 rounded-full text-sm inline-block">Ver catálogo</a>
    </div>
  @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="md:col-span-2 space-y-4">
        @foreach($cart as $item)
        <div class="bg-white rounded-2xl border border-gold/20 p-4 flex items-center gap-4">
          <div class="w-20 h-20 rounded-xl overflow-hidden bg-cream-dark shrink-0">
            @if($item['imagen'])
              <img src="/storage/{{ $item['imagen'] }}" alt="" class="w-full h-full object-cover">
            @else
              <div class="w-full h-full flex items-center justify-center text-2xl">🍫</div>
            @endif
          </div>
          <div class="flex-1 min-w-0">
            <p class="font-serif text-base text-choco leading-tight">{{ $item['nom_produit'] }}</p>
            <p class="text-xs text-choco/50 mb-2">{{ $item['label_variante'] }}</p>
            <p class="text-sm font-semibold text-choco">{{ number_format($item['prix'] * $item['cantidad'], 0, ',', '.') }} COP</p>
          </div>
          <div class="flex items-center gap-2 shrink-0">
            <form method="POST" action="{{ route('cart.update') }}" class="flex items-center gap-1">
              @csrf @method('PATCH')
              <input type="hidden" name="variante_id" value="{{ $item['variante_id'] }}">
              <div class="flex items-center border border-gold/30 rounded-lg overflow-hidden">
                <button type="submit" name="cantidad" value="{{ max(0, $item['cantidad']-1) }}"
                        class="w-8 h-8 text-choco hover:bg-gold/20 transition-colors text-sm flex items-center justify-center">−</button>
                <span class="w-8 text-center text-sm font-medium text-choco">{{ $item['cantidad'] }}</span>
                <button type="submit" name="cantidad" value="{{ $item['cantidad']+1 }}"
                        class="w-8 h-8 text-choco hover:bg-gold/20 transition-colors text-sm flex items-center justify-center">+</button>
              </div>
            </form>
            <form method="POST" action="{{ route('cart.remove', $item['variante_id']) }}"
                  onsubmit="return confirm('¿Eliminar este producto?')">
              @csrf @method('DELETE')
              <button type="submit" class="text-red-400 hover:text-red-600 transition-colors p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
              </button>
            </form>
          </div>
        </div>
        @endforeach
      </div>

      <div class="md:col-span-1">
        <div class="bg-white rounded-2xl border border-gold/20 p-6 sticky top-24">
          <h2 class="font-serif text-xl text-choco mb-4">Resumen del pedido</h2>
          <div class="space-y-2 mb-4 text-sm">
            @foreach($cart as $item)
            <div class="flex justify-between text-choco/70">
              <span>{{ $item['nom_produit'] }} x{{ $item['cantidad'] }}</span>
              <span>{{ number_format($item['prix'] * $item['cantidad'], 0, ',', '.') }}</span>
            </div>
            @endforeach
          </div>
          <div class="border-t border-gold/20 pt-4 mb-6">
            <div class="flex justify-between font-semibold text-choco">
              <span>Total</span>
              <span class="text-lg">{{ number_format($total, 0, ',', '.') }} COP</span>
            </div>
          </div>
          <div class="space-y-3">
            <a href="{{ route('order.checkout') }}" class="btn-gold w-full py-3.5 rounded-full text-sm flex items-center justify-center gap-2 text-center">
              Finalizar pedido →
            </a>
            <a href="{{ route('order.whatsapp') }}" target="_blank"
               class="btn-choco w-full py-3.5 rounded-full text-sm flex items-center justify-center gap-2">
              <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              Pedir por WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection

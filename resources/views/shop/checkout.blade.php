{{-- ================================================================
     resources/views/shop/checkout.blade.php
     ================================================================ --}}
@extends('shop.layout')
@section('title', 'Finalizar pedido — ChocoBless')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
  <h1 class="font-serif text-4xl text-choco mb-8">Finalizar pedido</h1>

  <form method="POST" action="{{ route('order.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-8">
    @csrf

    {{-- Formulario --}}
    <div class="md:col-span-2 space-y-5">

      {{-- Datos personales --}}
      <div class="bg-white rounded-2xl border border-gold/20 p-6">
        <h2 class="font-serif text-xl text-choco mb-5">Tus datos</h2>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-medium text-choco/60 mb-1.5 uppercase tracking-wide">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required
                   class="w-full border border-gold/30 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold bg-cream/50 text-choco @error('nombre') border-red-400 @enderror">
            @error('nombre')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="block text-xs font-medium text-choco/60 mb-1.5 uppercase tracking-wide">Apellido *</label>
            <input type="text" name="apellido" value="{{ old('apellido') }}" required
                   class="w-full border border-gold/30 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold bg-cream/50 text-choco @error('apellido') border-red-400 @enderror">
          </div>
          <div>
            <label class="block text-xs font-medium text-choco/60 mb-1.5 uppercase tracking-wide">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border border-gold/30 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold bg-cream/50 text-choco @error('email') border-red-400 @enderror">
          </div>
          <div>
            <label class="block text-xs font-medium text-choco/60 mb-1.5 uppercase tracking-wide">Teléfono / WhatsApp *</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" required
                   placeholder="300 000 0000"
                   class="w-full border border-gold/30 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold bg-cream/50 text-choco @error('telefono') border-red-400 @enderror">
          </div>
        </div>
      </div>

      {{-- Dirección --}}
      <div class="bg-white rounded-2xl border border-gold/20 p-6">
        <h2 class="font-serif text-xl text-choco mb-5">Dirección de entrega</h2>
        <div class="space-y-4">
          <div>
            <label class="block text-xs font-medium text-choco/60 mb-1.5 uppercase tracking-wide">Dirección *</label>
            <input type="text" name="direccion" value="{{ old('direccion') }}" required
                   placeholder="Calle / Carrera / Avenida, número"
                   class="w-full border border-gold/30 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold bg-cream/50 text-choco @error('direccion') border-red-400 @enderror">
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-medium text-choco/60 mb-1.5 uppercase tracking-wide">Barrio</label>
              <input type="text" name="barrio" value="{{ old('barrio') }}"
                     class="w-full border border-gold/30 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold bg-cream/50 text-choco">
            </div>
            <div>
              <label class="block text-xs font-medium text-choco/60 mb-1.5 uppercase tracking-wide">Ciudad *</label>
              <input type="text" name="ciudad" value="{{ old('ciudad', 'Bogotá') }}" required
                     class="w-full border border-gold/30 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold bg-cream/50 text-choco">
            </div>
          </div>
          <div>
            <label class="block text-xs font-medium text-choco/60 mb-1.5 uppercase tracking-wide">Notas adicionales</label>
            <textarea name="notas" rows="2" placeholder="Instrucciones especiales, color preferido, dedicatoria..."
                      class="w-full border border-gold/30 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold bg-cream/50 text-choco resize-none">{{ old('notas') }}</textarea>
          </div>
        </div>
      </div>

      {{-- Pago --}}
      <div class="bg-white rounded-2xl border border-gold/20 p-6">
        <h2 class="font-serif text-xl text-choco mb-5">Método de pago</h2>
        <div class="grid grid-cols-2 gap-3">
          @foreach(['Nequi','Daviplata','Efectivo','Transferencia'] as $metodo)
          <label class="flex items-center gap-3 p-4 rounded-xl border border-gold/20 cursor-pointer hover:border-gold/50 transition-all has-[:checked]:border-gold has-[:checked]:bg-gold/10">
            <input type="radio" name="metodo_pago" value="{{ $metodo }}"
                   {{ old('metodo_pago') === $metodo || ($loop->first && !old('metodo_pago')) ? 'checked' : '' }}
                   class="accent-gold">
            <div>
              <span class="block text-sm font-medium text-choco">{{ $metodo }}</span>
            </div>
          </label>
          @endforeach
        </div>
      </div>

      {{-- Cupón --}}
      <div class="bg-white rounded-2xl border border-gold/20 p-6">
        <h2 class="font-serif text-xl text-choco mb-4">Cupón de descuento</h2>
        <div class="flex gap-3">
          <input type="text" name="coupon_code" value="{{ old('coupon_code') }}"
                 placeholder="Ingresa tu código"
                 class="flex-1 border border-gold/30 rounded-xl px-4 py-3 text-sm uppercase font-mono focus:outline-none focus:border-gold bg-cream/50 text-choco">
          <span class="text-xs text-choco/40 self-center">Opcional</span>
        </div>
      </div>
    </div>

    {{-- Resumen --}}
    <div>
      <div class="bg-white rounded-2xl border border-gold/20 p-6 sticky top-24">
        <h2 class="font-serif text-xl text-choco mb-4">Tu pedido</h2>
        <div class="space-y-3 mb-4">
          @foreach($cart as $item)
          <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-lg overflow-hidden bg-cream-dark shrink-0">
              @if($item['imagen'])
                <img src="/storage/{{ $item['imagen'] }}" class="w-full h-full object-cover">
              @else
                <div class="w-full h-full flex items-center justify-center text-lg">🍫</div>
              @endif
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-xs font-medium text-choco truncate">{{ $item['nom_produit'] }}</p>
              <p class="text-xs text-choco/50">{{ $item['label_variante'] }} × {{ $item['cantidad'] }}</p>
            </div>
            <p class="text-xs font-semibold text-choco shrink-0">{{ number_format($item['prix'] * $item['cantidad'], 0, ',', '.') }}</p>
          </div>
          @endforeach
        </div>
        <div class="border-t border-gold/20 pt-4 mb-6">
          <div class="flex justify-between font-semibold text-choco text-lg">
            <span>Total</span>
            <span>{{ number_format($total, 0, ',', '.') }} COP</span>
          </div>
        </div>
        <button type="submit" class="btn-gold w-full py-4 rounded-full text-sm font-medium">
          Confirmar pedido →
        </button>
        <p class="text-xs text-choco/40 text-center mt-3 font-light">
          Te contactaremos para coordinar la entrega
        </p>
      </div>
    </div>
  </form>
</div>
@endsection

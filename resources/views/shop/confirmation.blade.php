@extends('shop.layout')
@section('title', '¡Pedido confirmado! — ChocoBless')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-16 text-center">

  {{-- Icono éxito --}}
  <div class="w-20 h-20 bg-gold/20 rounded-full flex items-center justify-center mx-auto mb-6">
    <svg class="w-10 h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
  </div>

  <p class="text-gold text-xs tracking-widest uppercase mb-3" style="letter-spacing:0.2em;">¡Gracias por tu confianza!</p>
  <h1 class="font-serif text-4xl text-choco mb-3">Pedido confirmado</h1>
  <p class="text-choco/60 mb-2 font-light">Número de pedido:</p>
  <p class="font-mono text-2xl font-bold text-choco bg-gold/20 rounded-xl py-3 px-6 inline-block mb-8">
    {{ $order->numero_commande }}
  </p>

  {{-- Detalle pedido --}}
  <div class="bg-white rounded-2xl border border-gold/20 p-6 text-left mb-6">
    <h2 class="font-serif text-xl text-choco mb-4">Resumen de tu pedido</h2>
    <div class="space-y-3 mb-4">
      @foreach($order->items as $item)
      <div class="flex justify-between text-sm">
        <span class="text-choco">{{ $item->nom_produit }} <span class="text-choco/50">({{ $item->label_variante }}) × {{ $item->quantite }}</span></span>
        <span class="font-semibold text-choco">{{ number_format($item->sous_total, 0, ',', '.') }} COP</span>
      </div>
      @endforeach
    </div>
    <div class="border-t border-gold/20 pt-4 space-y-2">
      @if($order->remise > 0)
      <div class="flex justify-between text-sm text-green-600">
        <span>Descuento aplicado</span>
        <span>-{{ number_format($order->remise, 0, ',', '.') }} COP</span>
      </div>
      @endif
      <div class="flex justify-between font-bold text-choco text-lg">
        <span>Total a pagar</span>
        <span>{{ number_format($order->total, 0, ',', '.') }} COP</span>
      </div>
      <div class="flex justify-between text-sm text-choco/60">
        <span>Método de pago</span>
        <span>{{ $order->methode_paiement }}</span>
      </div>
    </div>
  </div>

  {{-- Datos entrega --}}
  <div class="bg-white rounded-2xl border border-gold/20 p-6 text-left mb-8">
    <h2 class="font-serif text-xl text-choco mb-3">Datos de entrega</h2>
    <p class="text-sm text-choco font-medium">{{ $order->customer->full_name }}</p>
    <p class="text-sm text-choco/60">{{ $order->customer->email }}</p>
    <p class="text-sm text-choco/60">{{ $order->customer->telephone }}</p>
    @if($order->address)
      <p class="text-sm text-choco/60 mt-1">{{ $order->address->rue }}, {{ $order->address->barrio }} — {{ $order->address->ciudad }}</p>
    @endif
    @if($order->notes)
      <p class="text-sm text-choco/60 mt-2 italic">Nota: {{ $order->notes }}</p>
    @endif
  </div>

  {{-- Próximos pasos --}}
  <div class="bg-gold/10 rounded-2xl border border-gold/30 p-6 text-left mb-8">
    <h2 class="font-serif text-xl text-choco mb-3">¿Qué sigue?</h2>
    <ol class="space-y-2 text-sm text-choco/70">
      <li class="flex items-start gap-3"><span class="w-5 h-5 bg-gold text-choco text-xs rounded-full flex items-center justify-center shrink-0 mt-0.5 font-semibold">1</span> Recibirás confirmación por WhatsApp en los próximos minutos.</li>
      <li class="flex items-start gap-3"><span class="w-5 h-5 bg-gold text-choco text-xs rounded-full flex items-center justify-center shrink-0 mt-0.5 font-semibold">2</span> Coordinamos el método de pago ({{ $order->methode_paiement }}).</li>
      <li class="flex items-start gap-3"><span class="w-5 h-5 bg-gold text-choco text-xs rounded-full flex items-center justify-center shrink-0 mt-0.5 font-semibold">3</span> Preparamos tu pedido con todo el amor y lo enviamos.</li>
    </ol>
  </div>

  {{-- CTA WhatsApp --}}
  <a href="{{ $whatsapp_url }}" target="_blank"
     class="btn-choco inline-flex items-center gap-3 px-8 py-4 rounded-full text-sm mb-4">
    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    Confirmar por WhatsApp
  </a>

  <div class="mt-4">
    <a href="{{ route('shop.home') }}" class="text-sm text-gold hover:text-choco transition-colors border-b border-gold/40 pb-1">
      ← Volver a la tienda
    </a>
  </div>
</div>
@endsection

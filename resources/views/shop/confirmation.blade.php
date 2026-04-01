@extends('shop.layout')
@section('title', '¡Pedido confirmado! — ChocoBless')

@push('styles')
<style>
  .conf-wrap{max-width:680px;margin:0 auto;padding:60px 24px 80px;}
  .conf-success-icon{width:80px;height:80px;background:rgba(201,168,76,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;border:2px solid rgba(201,168,76,.3);}
  .conf-label{font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:#c9a84c;display:block;text-align:center;margin-bottom:10px;}
  .conf-title{font-family:'Cormorant Garamond',Georgia,serif;font-size:clamp(32px,4vw,48px);font-weight:400;color:#3d1c02;text-align:center;margin-bottom:8px;}
  .conf-order-wrap{text-align:center;margin-bottom:36px;}
  .conf-order-label{font-size:13px;color:rgba(61,28,2,.5);margin-bottom:8px;}
  .conf-order-num{font-family:monospace;font-size:22px;font-weight:700;color:#3d1c02;background:rgba(201,168,76,.15);border:1px solid rgba(201,168,76,.3);border-radius:6px;padding:10px 24px;display:inline-block;letter-spacing:.05em;}
  .conf-card{background:#fff;border-radius:10px;border:1px solid rgba(201,168,76,.18);padding:24px;margin-bottom:16px;}
  .conf-card-title{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:500;color:#3d1c02;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid rgba(201,168,76,.15);}
  .conf-items{display:flex;flex-direction:column;gap:10px;margin-bottom:16px;}
  .conf-item{display:flex;justify-content:space-between;align-items:baseline;gap:12px;}
  .conf-item-name{font-size:14px;color:#3d1c02;}
  .conf-item-meta{font-size:12px;color:rgba(61,28,2,.45);}
  .conf-item-price{font-size:14px;font-weight:600;color:#3d1c02;flex-shrink:0;}
  .conf-divider{border:none;border-top:1px solid rgba(201,168,76,.15);margin:12px 0;}
  .conf-total-row{display:flex;justify-content:space-between;align-items:baseline;}
  .conf-total-label{font-size:13px;font-weight:600;color:rgba(61,28,2,.6);text-transform:uppercase;letter-spacing:.08em;}
  .conf-total-value{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:600;color:#3d1c02;}
  .conf-discount{display:flex;justify-content:space-between;font-size:13px;color:#16a34a;margin-bottom:6px;}
  .conf-pay-method{display:flex;justify-content:space-between;font-size:13px;color:rgba(61,28,2,.5);margin-top:6px;}
  .conf-address-name{font-size:14px;font-weight:600;color:#3d1c02;margin-bottom:4px;}
  .conf-address-detail{font-size:13px;color:rgba(61,28,2,.55);line-height:1.6;}
  .conf-address-note{font-size:13px;color:rgba(61,28,2,.5);font-style:italic;margin-top:8px;padding-top:8px;border-top:1px solid rgba(201,168,76,.1);}
  .conf-steps{background:rgba(201,168,76,.08);border:1px solid rgba(201,168,76,.2);border-radius:10px;padding:24px;margin-bottom:24px;}
  .conf-steps-title{font-family:'Cormorant Garamond',serif;font-size:20px;color:#3d1c02;margin-bottom:16px;}
  .conf-step{display:flex;align-items:flex-start;gap:14px;margin-bottom:12px;}
  .conf-step:last-child{margin-bottom:0;}
  .conf-step-num{width:26px;height:26px;background:#c9a84c;color:#1e0d00;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;margin-top:1px;}
  .conf-step-text{font-size:13px;color:rgba(61,28,2,.7);line-height:1.55;}
  .conf-btns{display:flex;flex-direction:column;gap:10px;align-items:center;}
  .btn-conf-wa{display:inline-flex;align-items:center;justify-content:center;gap:10px;background:#25D366;color:#fff;font-size:13px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:16px 32px;border-radius:6px;width:100%;transition:all .25s;}
  .btn-conf-wa:hover{background:#1ebe5b;transform:translateY(-1px);}
  .btn-conf-back{font-size:13px;color:#c9a84c;transition:color .2s;border-bottom:1px solid rgba(201,168,76,.3);padding-bottom:2px;}
  .btn-conf-back:hover{color:#3d1c02;}
</style>
@endpush

@section('content')
<div class="conf-wrap">

  <div class="conf-success-icon">
    <svg width="36" height="36" fill="none" stroke="#c9a84c" viewBox="0 0 24 24" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
    </svg>
  </div>

  <span class="conf-label">¡Gracias por tu confianza!</span>
  <h1 class="conf-title">Pedido confirmado</h1>

  <div class="conf-order-wrap">
    <p class="conf-order-label">Número de pedido</p>
    <span class="conf-order-num">{{ $order->numero_commande }}</span>
  </div>

  {{-- Resumen productos --}}
  <div class="conf-card">
    <h2 class="conf-card-title">Resumen de tu pedido</h2>
    <div class="conf-items">
      @foreach($order->items as $item)
      <div class="conf-item">
        <div>
          <span class="conf-item-name">{{ $item->nom_produit }}</span>
          <span class="conf-item-meta"> ({{ $item->label_variante }}) × {{ $item->quantite }}</span>
        </div>
        <span class="conf-item-price">{{ number_format($item->sous_total, 0, ',', '.') }} COP</span>
      </div>
      @endforeach
    </div>
    <hr class="conf-divider">
    @if($order->remise > 0)
      <div class="conf-discount">
        <span>Descuento aplicado</span>
        <span>-{{ number_format($order->remise, 0, ',', '.') }} COP</span>
      </div>
    @endif
    <div class="conf-total-row">
      <span class="conf-total-label">Total a pagar</span>
      <span class="conf-total-value">{{ number_format($order->total, 0, ',', '.') }} COP</span>
    </div>
    <div class="conf-pay-method">
      <span>Método de pago</span>
      <span>{{ $order->methode_paiement }}</span>
    </div>
  </div>

  {{-- Datos entrega --}}
  <div class="conf-card">
    <h2 class="conf-card-title">Datos de entrega</h2>
    <p class="conf-address-name">{{ $order->customer->full_name }}</p>
    <p class="conf-address-detail">
      {{ $order->customer->email }}<br>
      {{ $order->customer->telephone }}<br>
      @if($order->address)
        {{ $order->address->rue }}{{ $order->address->barrio ? ', '.$order->address->barrio : '' }} — {{ $order->address->ciudad }}
      @endif
    </p>
    @if($order->notes)
      <p class="conf-address-note">📝 {{ $order->notes }}</p>
    @endif
  </div>

  {{-- Pasos --}}
  <div class="conf-steps">
    <h2 class="conf-steps-title">¿Qué sigue?</h2>
    <div class="conf-step">
      <span class="conf-step-num">1</span>
      <p class="conf-step-text">Recibirás confirmación por WhatsApp en los próximos minutos.</p>
    </div>
    <div class="conf-step">
      <span class="conf-step-num">2</span>
      <p class="conf-step-text">Coordinamos el método de pago ({{ $order->methode_paiement }}).</p>
    </div>
    <div class="conf-step">
      <span class="conf-step-num">3</span>
      <p class="conf-step-text">Preparamos tu pedido con todo el amor y lo enviamos 🍫</p>
    </div>
  </div>

  {{-- Botones --}}
  <div class="conf-btns">
    <a href="{{ $whatsapp_url }}" target="_blank" class="btn-conf-wa">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      Confirmar por WhatsApp
    </a>
    <a href="{{ route('shop.home') }}" class="btn-conf-back">← Volver a la tienda</a>
  </div>

</div>
@endsection

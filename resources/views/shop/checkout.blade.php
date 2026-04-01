@extends('shop.layout')
@section('title', 'Finalizar pedido — ChocoBless')

@push('styles')
<style>
  .co-wrap{max-width:1060px;margin:0 auto;padding:48px 24px 80px;}
  .co-header{margin-bottom:36px;}
  .co-label{font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:#c9a84c;display:block;margin-bottom:10px;}
  .co-title{font-family:'Cormorant Garamond',Georgia,serif;font-size:clamp(28px,4vw,42px);font-weight:400;color:#3d1c02;line-height:1.1;}
  .co-grid{display:grid;grid-template-columns:1fr 340px;gap:28px;align-items:start;}
  @media(max-width:900px){.co-grid{grid-template-columns:1fr;}}
  .co-form-col{display:flex;flex-direction:column;gap:16px;}
  .co-card{background:#fff;border-radius:10px;border:1px solid rgba(201,168,76,.18);padding:24px;}
  .co-card-title{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:500;color:#3d1c02;margin-bottom:20px;padding-bottom:12px;border-bottom:1px solid rgba(201,168,76,.15);}
  .co-fields{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
  .co-field-full{grid-column:1/-1;}
  @media(max-width:600px){.co-fields{grid-template-columns:1fr;}}
  .field-label{display:block;font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:rgba(61,28,2,.5);margin-bottom:6px;}
  .field-input{width:100%;border:1.5px solid rgba(201,168,76,.25);border-radius:6px;padding:11px 14px;font-size:14px;color:#3d1c02;background:rgba(253,245,238,.5);outline:none;transition:border-color .2s;font-family:'Jost',sans-serif;}
  .field-input:focus{border-color:#c9a84c;background:#fff;}
  .field-input.error{border-color:#dc2626;}
  .field-error{font-size:12px;color:#dc2626;margin-top:4px;}
  .field-textarea{resize:none;height:80px;}
  .pay-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
  @media(max-width:500px){.pay-grid{grid-template-columns:1fr;}}
  .pay-option{display:flex;align-items:center;gap:12px;padding:14px 16px;border-radius:8px;border:1.5px solid rgba(201,168,76,.2);cursor:pointer;transition:all .2s;}
  .pay-option:hover{border-color:rgba(201,168,76,.5);background:rgba(201,168,76,.04);}
  .pay-option input[type=radio]{accent-color:#c9a84c;}
  .pay-option.selected{border-color:#c9a84c;background:rgba(201,168,76,.08);}
  .pay-name{font-size:14px;font-weight:500;color:#3d1c02;}
  .coupon-row{display:flex;align-items:center;gap:10px;}
  .coupon-note{font-size:12px;color:rgba(61,28,2,.35);flex-shrink:0;}
  .co-summary{background:#3d1c02;border-radius:12px;padding:24px;position:sticky;top:88px;}
  .sum-title{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:400;color:#fdf5ee;margin-bottom:18px;}
  .sum-items{display:flex;flex-direction:column;gap:12px;margin-bottom:16px;}
  .sum-item{display:flex;align-items:center;gap:12px;}
  .sum-item-img{width:44px;height:44px;border-radius:6px;overflow:hidden;background:#f5e8d8;flex-shrink:0;}
  .sum-item-img img{width:100%;height:100%;object-fit:cover;}
  .sum-item-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:18px;}
  .sum-item-info{flex:1;min-width:0;}
  .sum-item-name{font-size:12px;font-weight:500;color:rgba(253,245,238,.85);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
  .sum-item-meta{font-size:11px;color:rgba(253,245,238,.4);}
  .sum-item-price{font-size:13px;font-weight:600;color:rgba(253,245,238,.8);flex-shrink:0;}
  .sum-divider{border:none;border-top:1px solid rgba(201,168,76,.2);margin:14px 0;}
  .sum-total{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:20px;}
  .sum-total-label{font-size:12px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:rgba(253,245,238,.5);}
  .sum-total-value{font-family:'Cormorant Garamond',serif;font-size:26px;color:#e2c97e;}
  .sum-total-cop{font-size:13px;color:rgba(253,245,238,.35);margin-left:3px;}
  .btn-confirm{width:100%;background:#c9a84c;color:#1e0d00;border:none;padding:15px;border-radius:6px;font-family:'Jost',sans-serif;font-size:13px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;transition:all .25s;display:flex;align-items:center;justify-content:center;gap:8px;}
  .btn-confirm:hover{background:#e2c97e;transform:translateY(-1px);}
  .sum-note{font-size:11px;color:rgba(253,245,238,.3);text-align:center;margin-top:10px;line-height:1.5;}
</style>
@endpush

@section('content')
<div class="co-wrap">
  <div class="co-header">
    <span class="co-label">ChocoBless</span>
    <h1 class="co-title">Finalizar pedido</h1>
  </div>

  <form method="POST" action="{{ route('order.store') }}" class="co-grid">
    @csrf
    <div class="co-form-col">

      {{-- Datos personales --}}
      <div class="co-card">
        <h2 class="co-card-title">Tus datos</h2>
        <div class="co-fields">
          <div>
            <label class="field-label">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required class="field-input @error('nombre') error @enderror">
            @error('nombre')<p class="field-error">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="field-label">Apellido *</label>
            <input type="text" name="apellido" value="{{ old('apellido') }}" required class="field-input @error('apellido') error @enderror">
            @error('apellido')<p class="field-error">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="field-label">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="field-input @error('email') error @enderror">
            @error('email')<p class="field-error">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="field-label">Teléfono / WhatsApp *</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" required placeholder="300 000 0000" class="field-input @error('telefono') error @enderror">
            @error('telefono')<p class="field-error">{{ $message }}</p>@enderror
          </div>
        </div>
      </div>

      {{-- Dirección --}}
      <div class="co-card">
        <h2 class="co-card-title">Dirección de entrega</h2>
        <div class="co-fields">
          <div class="co-field-full">
            <label class="field-label">Dirección *</label>
            <input type="text" name="direccion" value="{{ old('direccion') }}" required placeholder="Calle / Carrera / Avenida, número" class="field-input @error('direccion') error @enderror">
            @error('direccion')<p class="field-error">{{ $message }}</p>@enderror
          </div>
          <div>
            <label class="field-label">Barrio</label>
            <input type="text" name="barrio" value="{{ old('barrio') }}" class="field-input">
          </div>
          <div>
            <label class="field-label">Ciudad *</label>
            <input type="text" name="ciudad" value="{{ old('ciudad', 'Bogotá') }}" required class="field-input">
          </div>
          <div class="co-field-full">
            <label class="field-label">Notas adicionales</label>
            <textarea name="notas" class="field-input field-textarea" placeholder="Instrucciones especiales, color preferido, dedicatoria...">{{ old('notas') }}</textarea>
          </div>
        </div>
      </div>

      {{-- Método de pago --}}
      <div class="co-card">
        <h2 class="co-card-title">Método de pago</h2>
        <div class="pay-grid">
          @foreach(['Nequi','Daviplata','Efectivo','Transferencia'] as $metodo)
          <label class="pay-option">
            <input type="radio" name="metodo_pago" value="{{ $metodo }}"
                   {{ old('metodo_pago') === $metodo || ($loop->first && !old('metodo_pago')) ? 'checked' : '' }}>
            <span class="pay-name">{{ $metodo }}</span>
          </label>
          @endforeach
        </div>
      </div>

      {{-- Cupón --}}
      <div class="co-card">
        <h2 class="co-card-title">Cupón de descuento</h2>
        <div class="coupon-row">
          <input type="text" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="Ingresa tu código" class="field-input" style="text-transform:uppercase;font-family:monospace;">
          <span class="coupon-note">Opcional</span>
        </div>
      </div>

    </div>

    {{-- Resumen --}}
    <div class="co-summary">
      <h2 class="sum-title">Tu pedido</h2>
      <div class="sum-items">
        @foreach($cart as $item)
        <div class="sum-item">
          <div class="sum-item-img">
            @if(!empty($item['imagen']))
              <img src="{{ str_starts_with($item['imagen'], 'images/') ? '/'.$item['imagen'] : '/storage/'.$item['imagen'] }}" alt="">
            @else
              <div class="sum-item-placeholder">🍫</div>
            @endif
          </div>
          <div class="sum-item-info">
            <p class="sum-item-name">{{ $item['nom_produit'] }}</p>
            <p class="sum-item-meta">{{ $item['label_variante'] }} × {{ $item['cantidad'] }}</p>
          </div>
          <span class="sum-item-price">{{ number_format($item['prix'] * $item['cantidad'], 0, ',', '.') }}</span>
        </div>
        @endforeach
      </div>
      <hr class="sum-divider">
      <div class="sum-total">
        <span class="sum-total-label">Total</span>
        <span class="sum-total-value">{{ number_format($total, 0, ',', '.') }}<span class="sum-total-cop">COP</span></span>
      </div>
      <button type="submit" class="btn-confirm">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        Confirmar pedido
      </button>
      <p class="sum-note">Te contactaremos para coordinar la entrega 🍫</p>
    </div>

  </form>
</div>
@endsection
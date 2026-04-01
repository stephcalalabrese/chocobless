@extends('shop.layout')
@section('title', 'Mi carrito — ChocoBless')

@push('styles')
<style>
  .cart-wrap{max-width:1000px;margin:0 auto;padding:48px 24px 80px;}
  .cart-header{margin-bottom:36px;}
  .cart-header-label{font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:#c9a84c;display:block;margin-bottom:10px;}
  .cart-header-title{font-family:'Cormorant Garamond',Georgia,serif;font-size:clamp(28px,4vw,42px);font-weight:400;color:#3d1c02;line-height:1.1;}
  .cart-empty{text-align:center;padding:80px 24px;background:#fff;border-radius:12px;border:1px solid rgba(201,168,76,.2);}
  .cart-empty-icon{font-size:56px;display:block;margin-bottom:20px;}
  .cart-empty-title{font-family:'Cormorant Garamond',serif;font-size:26px;color:#3d1c02;margin-bottom:8px;}
  .cart-empty-sub{font-size:14px;color:rgba(61,28,2,.5);margin-bottom:28px;font-weight:300;}
  .btn-catalog{display:inline-flex;align-items:center;gap:8px;background:#3d1c02;color:#e2c97e;font-size:12px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;padding:14px 28px;border-radius:4px;transition:all .25s;}

  /* Grid desktop */
  .cart-grid{display:grid;grid-template-columns:1fr 340px;gap:28px;align-items:start;}

  /* Cart items */
  .cart-items{display:flex;flex-direction:column;gap:12px;}
  .cart-item{background:#fff;border-radius:10px;border:1px solid rgba(201,168,76,.15);padding:16px;display:flex;align-items:center;gap:12px;transition:border-color .25s;}
  .cart-item:hover{border-color:rgba(201,168,76,.35);}
  .cart-item-img{width:72px;height:72px;border-radius:8px;overflow:hidden;background:#f5e8d8;flex-shrink:0;}
  .cart-item-img img{width:100%;height:100%;object-fit:cover;}
  .cart-item-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:28px;}
  .cart-item-info{flex:1;min-width:0;}
  .cart-item-name{font-family:'Cormorant Garamond',serif;font-size:16px;font-weight:500;color:#3d1c02;line-height:1.2;margin-bottom:3px;}
  .cart-item-variant{font-size:12px;color:rgba(61,28,2,.45);margin-bottom:4px;}
  .cart-item-price{font-family:'Cormorant Garamond',serif;font-size:16px;font-weight:600;color:#3d1c02;}
  .cart-item-actions{display:flex;align-items:center;gap:8px;flex-shrink:0;}
  .qty-ctrl{display:flex;align-items:center;border:1.5px solid rgba(201,168,76,.25);border-radius:6px;overflow:hidden;}
  .qty-ctrl button{width:30px;height:30px;background:none;border:none;cursor:pointer;font-size:15px;color:#3d1c02;transition:background .2s;display:flex;align-items:center;justify-content:center;}
  .qty-ctrl button:hover{background:rgba(201,168,76,.15);}
  .qty-ctrl span{width:28px;text-align:center;font-size:13px;font-weight:600;color:#3d1c02;border-left:1.5px solid rgba(201,168,76,.2);border-right:1.5px solid rgba(201,168,76,.2);line-height:30px;}
  .btn-remove{background:none;border:none;cursor:pointer;color:rgba(61,28,2,.3);padding:5px;border-radius:4px;transition:color .2s,background .2s;display:flex;}
  .btn-remove:hover{color:#dc2626;background:rgba(220,38,38,.08);}

  /* Summary */
  .cart-summary{background:#3d1c02;border-radius:12px;padding:24px;position:sticky;top:88px;}
  .summary-title{font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:400;color:#fdf5ee;margin-bottom:20px;}
  .summary-lines{display:flex;flex-direction:column;gap:10px;margin-bottom:20px;}
  .summary-line{display:flex;justify-content:space-between;align-items:baseline;gap:8px;}
  .summary-line-name{font-size:12px;color:rgba(253,245,238,.55);flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
  .summary-line-qty{font-size:11px;color:rgba(253,245,238,.35);margin-left:3px;}
  .summary-line-price{font-size:13px;color:rgba(253,245,238,.7);flex-shrink:0;font-weight:500;white-space:nowrap;}
  .summary-divider{border:none;border-top:1px solid rgba(201,168,76,.2);margin:16px 0;}
  .summary-total{display:flex;justify-content:space-between;align-items:baseline;gap:8px;}
  .summary-total-label{font-size:12px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:rgba(253,245,238,.5);flex-shrink:0;}
  .summary-total-value{font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:400;color:#e2c97e;word-break:break-all;}
  .summary-total-cop{font-size:13px;color:rgba(253,245,238,.4);margin-left:3px;}
  .summary-btns{display:flex;flex-direction:column;gap:10px;margin-top:20px;}
  .btn-checkout{display:flex;align-items:center;justify-content:center;gap:8px;background:#c9a84c;color:#1e0d00;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:15px;border-radius:4px;transition:all .25s;}
  .btn-checkout:hover{background:#e2c97e;}
  .btn-wa{display:flex;align-items:center;justify-content:center;gap:8px;background:#25D366;color:#fff;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:15px;border-radius:4px;transition:all .25s;}
  .btn-continue{display:flex;align-items:center;justify-content:center;gap:6px;font-size:12px;color:rgba(253,245,238,.4);margin-top:4px;transition:color .2s;}
  .btn-continue:hover{color:#c9a84c;}

  /* ── MOBILE ── */
  @media(max-width:768px){
    .cart-wrap{ padding:32px 16px 60px; }
    .cart-grid{ grid-template-columns:1fr; gap:20px; }
    .cart-summary{ position:static; }

    /* Card item sur mobile : image + infos empilées + actions en bas */
    .cart-item{ flex-wrap:wrap; padding:14px; gap:10px; }
    .cart-item-img{ width:60px; height:60px; }
    .cart-item-info{ flex:1; min-width:0; }
    .cart-item-name{ font-size:15px; }
    .cart-item-actions{
      width:100%;
      justify-content:space-between;
      border-top:1px solid rgba(201,168,76,.1);
      padding-top:10px;
      margin-top:4px;
    }

    /* Total plus petit sur mobile */
    .summary-total-value{ font-size:22px; }
    .summary-line-name{ font-size:11px; }
  }

  @media(max-width:400px){
    .qty-ctrl button{ width:28px; height:28px; }
    .qty-ctrl span{ width:24px; }
  }
</style>
@endpush

@section('content')
<div class="cart-wrap">
  <div class="cart-header">
    <span class="cart-header-label">ChocoBless</span>
    <h1 class="cart-header-title">Mi carrito</h1>
  </div>

  @if(empty($cart))
    <div class="cart-empty">
      <span class="cart-empty-icon">🛒</span>
      <p class="cart-empty-title">Tu carrito está vacío</p>
      <p class="cart-empty-sub">¡Agrega algunos chocolates deliciosos!</p>
      <a href="{{ route('shop.catalog') }}" class="btn-catalog">Ver catálogo</a>
    </div>

  @else
    <div class="cart-grid">

      {{-- Items --}}
      <div class="cart-items">
        @foreach($cart as $item)
        <div class="cart-item">

          <div class="cart-item-img">
            @if(!empty($item['imagen']))
              <img src="{{ str_starts_with($item['imagen'], 'images/') ? '/'.$item['imagen'] : '/storage/'.$item['imagen'] }}"
                   alt="{{ $item['nom_produit'] }}">
            @else
              <div class="cart-item-placeholder">🍫</div>
            @endif
          </div>

          <div class="cart-item-info">
            <p class="cart-item-name">{{ $item['nom_produit'] }}</p>
            <p class="cart-item-variant">{{ $item['label_variante'] }}</p>
            <p class="cart-item-price">{{ number_format($item['prix'] * $item['cantidad'], 0, ',', '.') }} COP</p>
          </div>

          <div class="cart-item-actions">
            <form method="POST" action="{{ route('cart.update') }}">
              @csrf @method('PATCH')
              <input type="hidden" name="variante_id" value="{{ $item['variante_id'] }}">
              <div class="qty-ctrl">
                <button type="submit" name="cantidad" value="{{ max(0, $item['cantidad']-1) }}">−</button>
                <span>{{ $item['cantidad'] }}</span>
                <button type="submit" name="cantidad" value="{{ $item['cantidad']+1 }}">+</button>
              </div>
            </form>

            <form method="POST" action="{{ route('cart.remove', $item['variante_id']) }}">
              @csrf @method('DELETE')
              <button type="submit" class="btn-remove" onclick="return confirm('¿Eliminar?')" title="Eliminar">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
              </button>
            </form>
          </div>

        </div>
        @endforeach
      </div>

      {{-- Summary --}}
      <div class="cart-summary">
        <h2 class="summary-title">Resumen del pedido</h2>

        <div class="summary-lines">
          @foreach($cart as $item)
          <div class="summary-line">
            <span class="summary-line-name">
              {{ $item['nom_produit'] }}
              <span class="summary-line-qty">×{{ $item['cantidad'] }}</span>
            </span>
            <span class="summary-line-price">{{ number_format($item['prix'] * $item['cantidad'], 0, ',', '.') }}</span>
          </div>
          @endforeach
        </div>

        <hr class="summary-divider">

        <div class="summary-total">
          <span class="summary-total-label">Total</span>
          <span class="summary-total-value">
            {{ number_format($total, 0, ',', '.') }}
            <span class="summary-total-cop">COP</span>
          </span>
        </div>

        <div class="summary-btns">
          <a href="{{ route('order.checkout') }}" class="btn-checkout">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
            Finalizar pedido
          </a>
          <a href="{{ route('order.whatsapp') }}" target="_blank" class="btn-wa">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Pedir por WhatsApp
          </a>
          <a href="{{ route('shop.catalog') }}" class="btn-continue">← Seguir comprando</a>
        </div>
      </div>

    </div>
  @endif

</div>
@endsection

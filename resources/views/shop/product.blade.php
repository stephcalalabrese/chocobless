@extends('shop.layout')
@section('title', $product->nom.' — ChocoBless')
@section('description', $product->description_courte)

@push('styles')
<style>
  .product-wrap { max-width:1180px; margin:0 auto; padding:40px 24px 80px; }

  /* Breadcrumb */
  .breadcrumb { display:flex; align-items:center; gap:8px; margin-bottom:40px; flex-wrap:wrap; }
  .breadcrumb a { font-size:12px; color:rgba(61,28,2,.45); transition:color .2s; }
  .breadcrumb a:hover { color:#c9a84c; }
  .breadcrumb span.sep { font-size:12px; color:rgba(61,28,2,.25); }
  .breadcrumb span.current { font-size:12px; color:#3d1c02; font-weight:500; }

  /* Grid */
  .product-grid { display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:start; }
  @media(max-width:768px){ .product-grid{ grid-template-columns:1fr; gap:32px; } }

  /* Image column */
  .product-img-sticky { position:sticky; top:88px; }
  @media(max-width:900px){ .product-img-sticky { position:static; top:auto; } }
  .product-main-img {
    aspect-ratio:1; border-radius:16px; overflow:hidden;
    background:#f5e8d8; border:1px solid rgba(201,168,76,.2);
    position:relative;
  }
  .product-main-img img { width:100%; height:100%; object-fit:cover; }
  .product-main-img .placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:96px; }
  .product-thumbnails { display:flex; gap:10px; margin-top:12px; flex-wrap:wrap; }
  .product-thumbnails button {
    width:64px; height:64px; border-radius:8px; overflow:hidden;
    border:2px solid rgba(201,168,76,.2); cursor:pointer;
    transition:border-color .2s; background:none; padding:0;
  }
  .product-thumbnails button:hover,
  .product-thumbnails button.active { border-color:#c9a84c; }
  .product-thumbnails button img { width:100%; height:100%; object-fit:cover; }

  /* Info column */
  .product-category-label {
    font-size:11px; font-weight:600; letter-spacing:.2em;
    text-transform:uppercase; color:#c9a84c; display:block; margin-bottom:10px;
  }
  .product-title {
    font-family:'Cormorant Garamond',Georgia,serif;
    font-size:clamp(28px,4vw,44px); font-weight:400; line-height:1.1;
    color:#3d1c02; margin-bottom:16px;
  }
  .product-short-desc {
    font-size:14px; font-weight:300; color:rgba(61,28,2,.65);
    line-height:1.7; margin-bottom:28px;
  }

  /* Variants */
  .variants-label { font-size:12px; font-weight:600; letter-spacing:.08em; text-transform:uppercase; color:rgba(61,28,2,.5); margin-bottom:12px; display:block; }
  .variant-option {
    display:flex; align-items:center; justify-content:space-between;
    padding:14px 18px; border-radius:8px;
    border:1.5px solid rgba(201,168,76,.2);
    cursor:pointer; transition:all .25s; margin-bottom:8px;
  }
  .variant-option:hover { border-color:rgba(201,168,76,.5); background:rgba(201,168,76,.04); }
  .variant-option.selected { border-color:#c9a84c; background:rgba(201,168,76,.08); }
  .variant-option input[type="radio"] { accent-color:#c9a84c; margin-right:10px; }
  .variant-name { font-size:14px; font-weight:500; color:#3d1c02; }
  .variant-price { font-family:'Cormorant Garamond',serif; font-size:18px; font-weight:600; color:#3d1c02; }
  .variant-price-promo { font-size:12px; color:rgba(61,28,2,.35); text-decoration:line-through; display:block; text-align:right; line-height:1; margin-bottom:2px; }
  .variant-price-promo-val { font-family:'Cormorant Garamond',serif; font-size:18px; font-weight:600; color:#c9a84c; }

  /* Quantity */
  .qty-row { display:flex; align-items:center; gap:20px; margin:24px 0; flex-wrap:wrap; }
  .qty-label { font-size:12px; font-weight:600; letter-spacing:.08em; text-transform:uppercase; color:rgba(61,28,2,.5); }
  .qty-control { display:flex; align-items:center; border:1.5px solid rgba(201,168,76,.3); border-radius:6px; overflow:hidden; }
  .qty-btn { width:38px; height:38px; background:none; border:none; cursor:pointer; font-size:18px; color:#3d1c02; transition:background .2s; display:flex; align-items:center; justify-content:center; }
  .qty-btn:hover { background:rgba(201,168,76,.15); }
  .qty-input { width:44px; text-align:center; font-size:14px; font-weight:600; color:#3d1c02; border:none; border-left:1.5px solid rgba(201,168,76,.2); border-right:1.5px solid rgba(201,168,76,.2); outline:none; background:transparent; padding:8px 0; }
  .qty-total { font-family:'Cormorant Garamond',serif; font-size:22px; font-weight:600; color:#3d1c02; }
  .qty-total span { font-size:13px; font-weight:400; font-family:'Jost',sans-serif; color:rgba(61,28,2,.4); margin-right:4px; font-style:italic; }

  /* Buttons */
  .btn-add-cart {
    width:100%; padding:16px; border-radius:6px; border:none; cursor:pointer;
    background:#3d1c02; color:#e2c97e;
    font-family:'Jost',sans-serif; font-size:13px; font-weight:600;
    letter-spacing:.1em; text-transform:uppercase;
    display:flex; align-items:center; justify-content:center; gap:10px;
    transition:background .25s, transform .25s;
    margin-bottom:10px;
  }
  .btn-add-cart:hover { background:#1e0d00; transform:translateY(-2px); box-shadow:0 8px 24px rgba(61,28,2,.25); }
  .btn-whatsapp {
    width:100%; padding:16px; border-radius:6px;
    background:#25D366; color:#fff;
    font-family:'Jost',sans-serif; font-size:13px; font-weight:600;
    letter-spacing:.1em; text-transform:uppercase;
    display:flex; align-items:center; justify-content:center; gap:10px;
    transition:background .25s, transform .25s;
    text-decoration:none;
  }
  .btn-whatsapp:hover { background:#1ebe5b; transform:translateY(-2px); box-shadow:0 8px 24px rgba(37,211,102,.3); }

  /* Description */
  .product-desc-block { border-top:1px solid rgba(201,168,76,.2); padding-top:24px; margin-top:28px; }
  .product-desc-title { font-size:12px; font-weight:600; letter-spacing:.1em; text-transform:uppercase; color:rgba(61,28,2,.4); margin-bottom:12px; }
  .product-desc-text { font-size:14px; color:rgba(61,28,2,.7); line-height:1.75; font-weight:300; }
  .product-desc-text p { margin-bottom:14px; }
  .product-desc-text p:last-child { margin-bottom:0; }
  .product-desc-text strong { color:#3d1c02; font-weight:600; }
  .product-desc-text em { font-style:italic; }
  .product-desc-text u { text-decoration:underline; }
  .product-desc-text ul { list-style:disc; padding-left:22px; margin-bottom:14px; }
  .product-desc-text ol { list-style:decimal; padding-left:22px; margin-bottom:14px; }
  .product-desc-text li { margin-bottom:6px; }
  .product-desc-text a { color:#c9a84c; text-decoration:underline; }
  .product-desc-text a:hover { color:#3d1c02; }

  /* Related */
  .related-section { max-width:1180px; margin:0 auto; padding:0 24px 80px; border-top:1px solid rgba(201,168,76,.15); padding-top:60px; }
  .related-title { font-family:'Cormorant Garamond',Georgia,serif; font-size:34px; font-weight:400; color:#3d1c02; margin-bottom:32px; }
  .related-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; }
  @media(max-width:900px){ .related-grid{ grid-template-columns:repeat(2,1fr); } }
  @media(max-width:480px){ .related-grid{ grid-template-columns:1fr; } }
  .pcard { background:#fff; border-radius:10px; overflow:hidden; border:1px solid rgba(61,28,2,.08); transition:transform .3s,box-shadow .3s,border-color .3s; display:flex; flex-direction:column; }
  .pcard:hover { transform:translateY(-5px); box-shadow:0 20px 50px rgba(61,28,2,.12); border-color:rgba(201,168,76,.35); }
  .pcard-img { aspect-ratio:1; overflow:hidden; background:#f5e8d8; position:relative; flex-shrink:0; }
  .pcard-img img { width:100%; height:100%; object-fit:cover; transition:transform .5s; }
  .pcard:hover .pcard-img img { transform:scale(1.06); }
  .pcard-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:52px; background:linear-gradient(135deg,#f5e8d8,#fdf5ee); }
  .pcard-badge { position:absolute; top:12px; left:12px; background:#c9a84c; color:#1e0d00; font-size:10px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; padding:3px 10px; border-radius:20px; }
  .pcard-body { padding:18px; display:flex; flex-direction:column; flex:1; }
  .pcard-name { font-family:"Cormorant Garamond",Georgia,serif; font-size:17px; font-weight:500; color:#3d1c02; line-height:1.2; margin-bottom:6px; }
  .pcard-desc { font-size:12px; color:rgba(61,28,2,.5); line-height:1.55; margin-bottom:12px; flex:1; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
  .pcard-footer { display:flex; align-items:center; justify-content:space-between; gap:8px; margin-top:auto; }
  .pcard-price-from { font-size:11px; color:rgba(61,28,2,.4); display:block; font-style:italic; font-family:"Cormorant Garamond",serif; line-height:1; margin-bottom:2px; }
  .pcard-price-value { font-size:19px; font-weight:600; color:#3d1c02; font-family:"Cormorant Garamond",serif; line-height:1; }
  .pcard-btn { flex-shrink:0; background:#3d1c02; color:#e2c97e; font-size:11px; font-weight:600; letter-spacing:.1em; text-transform:uppercase; padding:8px 14px; border-radius:4px; transition:background .25s; display:inline-flex; align-items:center; gap:5px; }
  .pcard-btn:hover { background:#1e0d00; }
</style>
@endpush

@section('content')

<div class="product-wrap">

  {{-- Breadcrumb --}}
  <nav class="breadcrumb">
    <a href="{{ route('shop.home') }}">Inicio</a>
    <span class="sep">/</span>
    <a href="{{ route('shop.catalog') }}">Catálogo</a>
    <span class="sep">/</span>
    <a href="{{ route('shop.category', $product->category->slug) }}">{{ $product->category->nom }}</a>
    <span class="sep">/</span>
    <span class="current">{{ $product->nom }}</span>
  </nav>

  <div class="product-grid">

    {{-- Imagen --}}
    <div class="product-img-sticky">
      <div class="product-main-img">
        @if($product->image_principale)
          <img src="{{ Str::startsWith($product->image_principale, 'images/') ? '/'.$product->image_principale : '/storage/'.$product->image_principale }}"
               alt="{{ $product->nom }}" id="main-image">
        @else
          <div class="placeholder">🍫</div>
        @endif
      </div>
      @if($product->images->count() > 0)
        <div class="product-thumbnails">
          @if($product->image_principale)
            <button class="active" onclick="switchImage(this, '{{ Str::startsWith($product->image_principale, 'images/') ? '/'.$product->image_principale : '/storage/'.$product->image_principale }}')">
              <img src="{{ Str::startsWith($product->image_principale, 'images/') ? '/'.$product->image_principale : '/storage/'.$product->image_principale }}" alt="">
            </button>
          @endif
          @foreach($product->images as $img)
            <button onclick="switchImage(this, '/storage/{{ $img->url_image }}')">
              <img src="/storage/{{ $img->url_image }}" alt="{{ $img->alt_text }}">
            </button>
          @endforeach
        </div>
      @endif
    </div>

    {{-- Info --}}
    <div>
      <span class="product-category-label">{{ $product->category->nom }}</span>
      <h1 class="product-title">{{ $product->nom }}</h1>

      @if($product->description_courte)
        <p class="product-short-desc">{{ $product->description_courte }}</p>
      @endif

      {{-- Variantes --}}
      <span class="variants-label">Elige tu opción</span>
      <div id="variantes">
        @foreach($product->variants as $v)
          <label class="variant-option {{ $loop->first ? 'selected' : '' }}">
            <div style="display:flex; align-items:center;">
              <input type="radio" name="variante" value="{{ $v->id }}"
                     data-price="{{ (float) $v->prix }}"
                     data-label="{{ $v->label }}"
                     {{ $loop->first ? 'checked' : '' }}>
              <span class="variant-name">{{ $v->label }}</span>
            </div>
            <div style="text-align:right;">
              @if($v->prix_promo)
                <span class="variant-price-promo">{{ number_format($v->prix, 0, ',', '.') }} COP</span>
                <span class="variant-price-promo-val">{{ number_format($v->prix_promo, 0, ',', '.') }} COP</span>
              @else
                <span class="variant-price">{{ number_format($v->prix, 0, ',', '.') }} COP</span>
              @endif
            </div>
          </label>
        @endforeach
      </div>

      {{-- Cantidad + Total --}}
      <div class="qty-row">
        <span class="qty-label">Cantidad</span>
        <div class="qty-control">
          <button class="qty-btn" type="button" onclick="updateQty(-1)">−</button>
          <input type="number" id="qty" class="qty-input" value="1" min="1" max="20">
          <button class="qty-btn" type="button" onclick="updateQty(1)">+</button>
        </div>
        <div class="qty-total">
          <span>Total</span>
          <span id="price-display">—</span>
        </div>
      </div>

      {{-- Botones --}}
      <form action="{{ route('cart.add') }}" method="POST" id="add-cart-form">
        @csrf
        <input type="hidden" name="variante_id" id="variante_id_input">
        <input type="hidden" name="cantidad" id="cantidad_input">
        <button type="submit" class="btn-add-cart">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 7H4l1-7z"/></svg>
          Agregar al carrito
        </button>
      </form>

      <a href="{{ route('order.whatsapp') }}" target="_blank" class="btn-whatsapp">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        Pedir por WhatsApp
      </a>

      {{-- Description --}}
      @if($product->description)
        <div class="product-desc-block">
          <p class="product-desc-title">Descripción</p>
          <div class="product-desc-text">{!! $product->description !!}</div>
        </div>
      @endif

    </div>
  </div>
</div>

{{-- Relacionados --}}
@if($relacionados->count() > 0)
<div class="related-section">
  <h2 class="related-title">También te puede gustar</h2>
  <div class="related-grid">
    @foreach($relacionados as $p)
      @include('shop.partials.product-card', ['product' => $p])
    @endforeach
  </div>
</div>
@endif

@endsection

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

  function switchImage(btn, src) {
    document.getElementById('main-image').src = src;
    document.querySelectorAll('.product-thumbnails button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  }

  // Variants — highlight selected
  document.querySelectorAll('input[name="variante"]').forEach(radio => {
    radio.addEventListener('change', function() {
      document.querySelectorAll('.variant-option').forEach(o => o.classList.remove('selected'));
      this.closest('.variant-option').classList.add('selected');
      updateDisplay();
    });
  });

  document.getElementById('qty').addEventListener('input', updateDisplay);

  // Init
  const firstRadio = document.querySelector('input[name="variante"]');
  if (firstRadio) { firstRadio.checked = true; updateDisplay(); }
</script>
@endpush

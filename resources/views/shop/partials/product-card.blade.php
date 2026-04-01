{{-- ================================================================
     resources/views/shop/partials/product-card.blade.php
     ================================================================ --}}
@php $pmin = $product->variants->min('prix'); @endphp

<a href="{{ route('shop.product', $product->slug) }}" class="pcard">

    {{-- Image --}}
    <div class="pcard-img">
        @if($product->image_principale)
            <img src="{{ Str::startsWith($product->image_principale, 'images/') ? '/'.$product->image_principale : '/storage/'.$product->image_principale }}"
                 alt="{{ $product->nom }}"
                 loading="lazy">
        @else
            <div class="pcard-placeholder">🍫</div>
        @endif

        @if($product->en_vedette)
            <span class="pcard-badge">★ Destacado</span>
        @endif
    </div>

    {{-- Body --}}
    <div class="pcard-body">
        <p class="pcard-name">{{ $product->nom }}</p>
        <p class="pcard-desc">{{ $product->description_courte }}</p>

        <div class="pcard-footer">
            <div class="pcard-price">
                <span class="pcard-price-from">Desde</span>
                <span class="pcard-price-value">
                    @if($pmin)
                        {{ number_format($pmin, 0, ',', '.') }} COP
                    @else
                        Consultar
                    @endif
                </span>
            </div>
            <span class="pcard-btn">
                Ver
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </span>
        </div>
    </div>

</a>

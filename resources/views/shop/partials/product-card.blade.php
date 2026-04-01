{{-- ================================================================
     resources/views/shop/partials/product-card.blade.php
     ================================================================ --}}
@php $pmin = $product->variants->min('prix'); @endphp
<a href="{{ route('shop.product', $product->slug) }}" class="product-card group bg-white rounded-2xl overflow-hidden border border-gold/15 hover:border-gold/40">
  <div class="relative aspect-square bg-cream-dark overflow-hidden">
    @if($product->image_principale)
      <img src="/storage/{{ $product->image_principale }}"
           alt="{{ $product->nom }}"
           class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
    @else
      <div class="w-full h-full flex items-center justify-center text-6xl">🍫</div>
    @endif
    @if($product->en_vedette)
      <span class="absolute top-3 left-3 bg-gold text-choco text-xs font-semibold px-3 py-1 rounded-full">★ Destacado</span>
    @endif
  </div>
  <div class="p-4">
    <p class="font-serif text-base text-choco leading-tight mb-1">{{ $product->nom }}</p>
    <p class="text-xs text-choco/50 mb-3 font-light line-clamp-2">{{ $product->description_courte }}</p>
    <div class="flex items-center justify-between">
      <p class="text-sm font-semibold text-choco">
        @if($pmin) Desde {{ number_format($pmin, 0, ',', '.') }} COP @else Consultar @endif
      </p>
      <span class="text-gold text-xs border border-gold/40 px-3 py-1 rounded-full group-hover:bg-gold group-hover:text-choco transition-all">
        Ver →
      </span>
    </div>
  </div>
</a>

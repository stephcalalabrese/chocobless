@extends('admin.layout')
@section('page-title', isset($product) ? 'Modifier le produit' : 'Nuevo producto')
@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ isset($product) ? route('admin.products.update',$product) : route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-5">
  @csrf @if(isset($product)) @method('PATCH') @endif

  {{-- ── Informations générales ── --}}
  <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
    <h2 class="font-semibold text-gray-700 text-base">Información general</h2>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
      <input type="text" name="nom" value="{{ old('nom',$product->nom??'') }}" required
             class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
      <select name="categorie_id" required
              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
        <option value="">Elegir...</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" @selected(old('categorie_id',$product->categorie_id??'')==$cat->id)>
            {{ $cat->nom }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Descripción corta</label>
      <textarea name="description_courte" rows="2"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description_courte',$product->description_courte??'') }}</textarea>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Descripción completa</label>
      <textarea name="description" rows="4"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description',$product->description??'') }}</textarea>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Imagen principal</label>
      @if(isset($product) && $product->image_principale)
        <div class="mb-2 flex items-center gap-3">
          <img src="{{ str_starts_with($product->image_principale,'images/') ? '/'.$product->image_principale : '/storage/'.$product->image_principale }}"
               class="w-20 h-20 object-cover rounded-lg border border-gray-200" alt="">
          <span class="text-xs text-gray-400">Imagen actual</span>
        </div>
      @endif
      <input type="file" name="image_principale" accept="image/*"
             class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-amber-50 file:text-amber-800">
    </div>

    <div class="flex gap-6">
      <label class="flex items-center gap-2 text-sm">
        <input type="hidden" name="actif" value="0">
        <input type="checkbox" name="actif" value="1" @checked(old('actif',$product->actif??true)) class="accent-amber-700">
        Activo
      </label>
      <label class="flex items-center gap-2 text-sm">
        <input type="hidden" name="en_vedette" value="0">
        <input type="checkbox" name="en_vedette" value="1" @checked(old('en_vedette',$product->en_vedette??false)) class="accent-amber-700">
        Destacado
      </label>
    </div>
  </div>

  {{-- ── Ocasiones ── --}}
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="font-semibold text-gray-700 text-base mb-1">Ocasiones</h2>
    <p class="text-xs text-gray-400 mb-4">Selecciona todas las ocasiones para las que aplica este producto.</p>

    @php
      $selectedOcasiones = old('ocasion_ids',
        isset($product) ? $product->ocasiones->pluck('id')->toArray() : []
      );
    @endphp

    <div class="grid grid-cols-2 gap-2">
      @foreach($ocasiones as $oc)
        <label class="flex items-center gap-3 p-3 rounded-lg border cursor-pointer transition-all
                       {{ in_array($oc->id, $selectedOcasiones)
                          ? 'border-amber-400 bg-amber-50'
                          : 'border-gray-200 hover:border-amber-300 hover:bg-amber-50/50' }}"
               id="oc-label-{{ $oc->id }}">
          <input type="checkbox"
                 name="ocasion_ids[]"
                 value="{{ $oc->id }}"
                 @checked(in_array($oc->id, $selectedOcasiones))
                 class="accent-amber-700"
                 onchange="toggleOcLabel(this, {{ $oc->id }})">
          <span class="text-lg">{{ $oc->icono }}</span>
          <span class="text-sm font-medium text-gray-700">{{ $oc->nom }}</span>
        </label>
      @endforeach
    </div>
  </div>

  {{-- ── Variantes & Prix ── --}}
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="font-semibold text-gray-700 mb-4">Variantes & Precios</h2>
    <div id="variantes-container" class="space-y-3">
      @php
        $variantes = old('variantes', isset($product)
          ? $product->variants->toArray()
          : [['label'=>'','prix'=>'','prix_promo'=>'','stock'=>0,'sku'=>'','id'=>null]]);
      @endphp
      @foreach($variantes as $i => $v)
      <div class="variant-row border border-gray-200 rounded-lg p-4">
        @if(!empty($v['id']))
          <input type="hidden" name="variantes[{{ $i }}][id]" value="{{ $v['id'] }}">
        @endif
        <div class="grid grid-cols-2 gap-3 mb-3">
          <div>
            <label class="text-xs text-gray-500 block mb-1">Label *</label>
            <input type="text" name="variantes[{{ $i }}][label]" value="{{ $v['label']??'' }}" required
                   placeholder="Ej: Individual"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
          </div>
          <div>
            <label class="text-xs text-gray-500 block mb-1">SKU</label>
            <input type="text" name="variantes[{{ $i }}][sku]" value="{{ $v['sku']??'' }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
          </div>
        </div>
        <div class="grid grid-cols-3 gap-3">
          <div>
            <label class="text-xs text-gray-500 block mb-1">Precio COP *</label>
            <input type="number" name="variantes[{{ $i }}][prix]" value="{{ $v['prix']??'' }}" required min="0"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
          </div>
          <div>
            <label class="text-xs text-gray-500 block mb-1">Precio promo</label>
            <input type="number" name="variantes[{{ $i }}][prix_promo]" value="{{ $v['prix_promo']??'' }}" min="0"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
          </div>
          <div>
            <label class="text-xs text-gray-500 block mb-1">Stock *</label>
            <input type="number" name="variantes[{{ $i }}][stock]" value="{{ $v['stock']??0 }}" required min="0"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
          </div>
        </div>
        <div class="text-right mt-2">
          <button type="button" onclick="this.closest('.variant-row').remove()"
                  class="text-xs text-red-500 hover:underline">Eliminar</button>
        </div>
      </div>
      @endforeach
    </div>
    <button type="button" onclick="addVariant()"
            class="mt-3 text-sm bg-amber-50 hover:bg-amber-100 text-amber-800 px-3 py-1.5 rounded-lg">
      + Agregar variante
    </button>
  </div>

  {{-- ── Boutons ── --}}
  <div class="flex gap-3">
    <button type="submit"
            class="bg-amber-800 hover:bg-amber-900 text-white text-sm font-medium px-6 py-2.5 rounded-lg">
      {{ isset($product) ? 'Guardar cambios' : 'Crear producto' }}
    </button>
    <a href="{{ route('admin.products.index') }}"
       class="border border-gray-300 text-gray-600 text-sm px-6 py-2.5 rounded-lg hover:bg-gray-50">
      Cancelar
    </a>
  </div>

</form>
</div>

<script>
// Toggle visual de los checkboxes de ocasiones
function toggleOcLabel(checkbox, id) {
  const label = document.getElementById('oc-label-' + id);
  if (checkbox.checked) {
    label.classList.add('border-amber-400', 'bg-amber-50');
    label.classList.remove('border-gray-200');
  } else {
    label.classList.remove('border-amber-400', 'bg-amber-50');
    label.classList.add('border-gray-200');
  }
}

// Variantes
let vc = {{ count($variantes) }};
function addVariant(){
  const i = vc++;
  const c = document.getElementById('variantes-container');
  const d = document.createElement('div');
  d.className = 'variant-row border border-gray-200 rounded-lg p-4';
  d.innerHTML = `
    <div class="grid grid-cols-2 gap-3 mb-3">
      <div><label class="text-xs text-gray-500 block mb-1">Label *</label>
        <input type="text" name="variantes[${i}][label]" required placeholder="Ej: Individual"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
      <div><label class="text-xs text-gray-500 block mb-1">SKU</label>
        <input type="text" name="variantes[${i}][sku]"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
    </div>
    <div class="grid grid-cols-3 gap-3">
      <div><label class="text-xs text-gray-500 block mb-1">Precio COP *</label>
        <input type="number" name="variantes[${i}][prix]" required min="0"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
      <div><label class="text-xs text-gray-500 block mb-1">Precio promo</label>
        <input type="number" name="variantes[${i}][prix_promo]" min="0"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
      <div><label class="text-xs text-gray-500 block mb-1">Stock *</label>
        <input type="number" name="variantes[${i}][stock]" value="0" required min="0"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
    </div>
    <div class="text-right mt-2">
      <button type="button" onclick="this.closest('.variant-row').remove()"
              class="text-xs text-red-500 hover:underline">Eliminar</button>
    </div>`;
  c.appendChild(d);
}
</script>
@endsection

@extends('admin.layout')
@section('page-title', isset($product) ? 'Modifier le produit' : 'Nouveau produit')
@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ isset($product) ? route('admin.products.update',$product) : route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-5">
  @csrf @if(isset($product)) @method('PATCH') @endif
  <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label><input type="text" name="nom" value="{{ old('nom',$product->nom??'') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Catégorie *</label><select name="categorie_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"><option value="">Choisir...</option>@foreach($categories as $cat)<option value="{{ $cat->id }}" @selected(old('categorie_id',$product->categorie_id??'')==$cat->id)>{{ $cat->nom }}</option>@endforeach</select></div>
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Description courte</label><textarea name="description_courte" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description_courte',$product->description_courte??'') }}</textarea></div>
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Image principale</label><input type="file" name="image_principale" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-amber-50 file:text-amber-800"></div>
    <div class="flex gap-6"><label class="flex items-center gap-2 text-sm"><input type="hidden" name="actif" value="0"><input type="checkbox" name="actif" value="1" @checked(old('actif',$product->actif??true)) class="accent-amber-700"> Actif</label><label class="flex items-center gap-2 text-sm"><input type="hidden" name="en_vedette" value="0"><input type="checkbox" name="en_vedette" value="1" @checked(old('en_vedette',$product->en_vedette??false)) class="accent-amber-700"> En vedette</label></div>
  </div>
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="font-semibold text-gray-700 mb-4">Variantes & Prix</h2>
    <div id="variantes-container" class="space-y-3">
      @php $variantes = old('variantes', isset($product) ? $product->variants->toArray() : [['label'=>'','prix'=>'','prix_promo'=>'','stock'=>0,'sku'=>'','id'=>null]]); @endphp
      @foreach($variantes as $i => $v)
      <div class="variant-row border border-gray-200 rounded-lg p-4">
        @if(!empty($v['id']))<input type="hidden" name="variantes[{{ $i }}][id]" value="{{ $v['id'] }}">@endif
        <div class="grid grid-cols-2 gap-3 mb-3">
          <div><label class="text-xs text-gray-500 block mb-1">Label *</label><input type="text" name="variantes[{{ $i }}][label]" value="{{ $v['label']??'' }}" required placeholder="Ex: Individuel" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
          <div><label class="text-xs text-gray-500 block mb-1">SKU</label><input type="text" name="variantes[{{ $i }}][sku]" value="{{ $v['sku']??'' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
        </div>
        <div class="grid grid-cols-3 gap-3">
          <div><label class="text-xs text-gray-500 block mb-1">Prix COP *</label><input type="number" name="variantes[{{ $i }}][prix]" value="{{ $v['prix']??'' }}" required min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
          <div><label class="text-xs text-gray-500 block mb-1">Prix promo</label><input type="number" name="variantes[{{ $i }}][prix_promo]" value="{{ $v['prix_promo']??'' }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
          <div><label class="text-xs text-gray-500 block mb-1">Stock *</label><input type="number" name="variantes[{{ $i }}][stock]" value="{{ $v['stock']??0 }}" required min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
        </div>
        <div class="text-right mt-2"><button type="button" onclick="this.closest('.variant-row').remove()" class="text-xs text-red-500 hover:underline">Supprimer</button></div>
      </div>
      @endforeach
    </div>
    <button type="button" onclick="addVariant()" class="mt-3 text-sm bg-amber-50 hover:bg-amber-100 text-amber-800 px-3 py-1.5 rounded-lg">+ Ajouter une variante</button>
  </div>
  <div class="flex gap-3"><button type="submit" class="bg-amber-800 hover:bg-amber-900 text-white text-sm font-medium px-6 py-2.5 rounded-lg">{{ isset($product) ? 'Enregistrer' : 'Créer' }}</button><a href="{{ route('admin.products.index') }}" class="border border-gray-300 text-gray-600 text-sm px-6 py-2.5 rounded-lg hover:bg-gray-50">Annuler</a></div>
</form>
</div>
<script>
let vc = {{ count($variantes) }};
function addVariant(){const i=vc++;const c=document.getElementById('variantes-container');const d=document.createElement('div');d.className='variant-row border border-gray-200 rounded-lg p-4';d.innerHTML=`<div class="grid grid-cols-2 gap-3 mb-3"><div><label class="text-xs text-gray-500 block mb-1">Label *</label><input type="text" name="variantes[${i}][label]" required placeholder="Ex: Individuel" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div><div><label class="text-xs text-gray-500 block mb-1">SKU</label><input type="text" name="variantes[${i}][sku]" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div></div><div class="grid grid-cols-3 gap-3"><div><label class="text-xs text-gray-500 block mb-1">Prix COP *</label><input type="number" name="variantes[${i}][prix]" required min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div><div><label class="text-xs text-gray-500 block mb-1">Prix promo</label><input type="number" name="variantes[${i}][prix_promo]" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div><div><label class="text-xs text-gray-500 block mb-1">Stock *</label><input type="number" name="variantes[${i}][stock]" value="0" required min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div></div><div class="text-right mt-2"><button type="button" onclick="this.closest('.variant-row').remove()" class="text-xs text-red-500 hover:underline">Supprimer</button></div>`;c.appendChild(d);}
</script>
@endsection

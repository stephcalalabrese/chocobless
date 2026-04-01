@extends('admin.layout')
@section('page-title', isset($coupon) ? 'Modifier le coupon' : 'Nouveau coupon')
@section('header-actions')<a href="{{ route('admin.coupons.index') }}" class="text-sm text-gray-500 hover:text-gray-800">← Retour</a>@endsection
@section('content')
<div class="max-w-lg">
<div class="bg-white rounded-xl border border-gray-200 p-6">
<form method="POST" action="{{ isset($coupon) ? route('admin.coupons.update',$coupon) : route('admin.coupons.store') }}" class="space-y-4">
  @csrf @if(isset($coupon)) @method('PATCH') @endif
  <div><label class="block text-sm font-medium text-gray-700 mb-1">Code *</label><input type="text" name="code" value="{{ old('code',$coupon->code??'') }}" required style="text-transform:uppercase" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono uppercase focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="Ex: BLESS20"></div>
  <div class="grid grid-cols-2 gap-4">
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Type *</label><select name="type_remise" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"><option value="pourcent" @selected(old('type_remise',$coupon->type_remise??'pourcent')==='pourcent')>Pourcentage (%)</option><option value="fixe" @selected(old('type_remise',$coupon->type_remise??'')==='fixe')>Montant fixe (COP)</option></select></div>
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Valeur *</label><input type="number" name="valeur" value="{{ old('valeur',$coupon->valeur??'') }}" required min="0" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
  </div>
  <div class="grid grid-cols-2 gap-4">
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Utilisations max</label><input type="number" name="utilisations_max" value="{{ old('utilisations_max',$coupon->utilisations_max??'') }}" min="1" placeholder="Vide = illimité" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
    <div><label class="block text-sm font-medium text-gray-700 mb-1">Expiration</label><input type="date" name="date_expiration" value="{{ old('date_expiration', isset($coupon->date_expiration) ? $coupon->date_expiration->format('Y-m-d') : '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
  </div>
  <div class="flex items-center gap-2"><input type="hidden" name="actif" value="0"><input type="checkbox" name="actif" id="actif" value="1" @checked(old('actif',$coupon->actif??true)) class="accent-amber-700"><label for="actif" class="text-sm font-medium text-gray-700">Coupon actif</label></div>
  <div class="flex gap-3 pt-2"><button type="submit" class="bg-amber-800 hover:bg-amber-900 text-white text-sm font-medium px-6 py-2.5 rounded-lg">{{ isset($coupon) ? 'Mettre à jour' : 'Créer' }}</button><a href="{{ route('admin.coupons.index') }}" class="border border-gray-300 text-gray-600 text-sm px-6 py-2.5 rounded-lg hover:bg-gray-50">Annuler</a></div>
</form>
</div>
</div>
@endsection

@extends('admin.layout')
@section('page-title', isset($category) ? 'Modifier la catégorie' : 'Nouvelle catégorie')
@section('header-actions')<a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-gray-800">← Retour</a>@endsection
@section('content')
<div class="max-w-lg">
<div class="bg-white rounded-xl border border-gray-200 p-6">
<form method="POST" action="{{ isset($category) ? route('admin.categories.update',$category) : route('admin.categories.store') }}" class="space-y-4">
  @csrf @if(isset($category)) @method('PATCH') @endif
  <div><label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label><input type="text" name="nom" value="{{ old('nom',$category->nom??'') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="Ex: Fraises au chocolat"></div>
  <div><label class="block text-sm font-medium text-gray-700 mb-1">Catégorie parente</label><select name="parent_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"><option value="">Aucune (racine)</option>@foreach($parents as $p)<option value="{{ $p->id }}" @selected(old('parent_id',$category->parent_id??'')==$p->id)>{{ $p->nom }}</option>@endforeach</select></div>
  <div><label class="block text-sm font-medium text-gray-700 mb-1">Description</label><textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description',$category->description??'') }}</textarea></div>
  <div><label class="block text-sm font-medium text-gray-700 mb-1">Ordre</label><input type="number" name="ordre" value="{{ old('ordre',$category->ordre??0) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
  <div class="flex items-center gap-2"><input type="hidden" name="actif" value="0"><input type="checkbox" name="actif" id="actif" value="1" @checked(old('actif',$category->actif??true)) class="accent-amber-700"><label for="actif" class="text-sm font-medium text-gray-700">Catégorie active</label></div>
  <div class="flex gap-3 pt-2"><button type="submit" class="bg-amber-800 hover:bg-amber-900 text-white text-sm font-medium px-6 py-2.5 rounded-lg">{{ isset($category) ? 'Mettre à jour' : 'Créer' }}</button><a href="{{ route('admin.categories.index') }}" class="border border-gray-300 text-gray-600 text-sm px-6 py-2.5 rounded-lg hover:bg-gray-50">Annuler</a></div>
</form>
</div>
</div>
@endsection

@extends('admin.layout')
@section('page-title','Mon compte')
@section('content')
<div class="max-w-lg space-y-6">
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="font-semibold text-gray-700 mb-4">Profil</h2>
    <form method="POST" action="{{ route('admin.account.update') }}" class="space-y-4">@csrf @method('PATCH')
      <div><label class="block text-sm font-medium text-gray-700 mb-1">Nom</label><input type="text" name="nom" value="{{ old('nom',$admin->nom) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
      <div><label class="block text-sm font-medium text-gray-700 mb-1">Email</label><input type="email" name="email" value="{{ old('email',$admin->email) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
      <button type="submit" class="bg-amber-800 hover:bg-amber-900 text-white text-sm font-medium px-5 py-2 rounded-lg">Enregistrer</button>
    </form>
  </div>
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="font-semibold text-gray-700 mb-4">Changer le mot de passe</h2>
    <form method="POST" action="{{ route('admin.account.password') }}" class="space-y-4">@csrf @method('PATCH')
      <div><label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label><input type="password" name="mot_de_passe_actuel" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
      <div><label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe (min. 10 caractères)</label><input type="password" name="nouveau_mot_de_passe" required minlength="10" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
      <div><label class="block text-sm font-medium text-gray-700 mb-1">Confirmer</label><input type="password" name="nouveau_mot_de_passe_confirmation" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
      <button type="submit" class="bg-amber-800 hover:bg-amber-900 text-white text-sm font-medium px-5 py-2 rounded-lg">Mettre à jour</button>
    </form>
  </div>
</div>
@endsection

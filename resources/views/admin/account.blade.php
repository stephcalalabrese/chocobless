@extends('admin.layout')
@section('page-title','Mi cuenta')
@section('content')
<div class="max-w-lg space-y-6">
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="font-semibold text-gray-700 mb-4">Perfil</h2>
    <form method="POST" action="{{ route('admin.account.update') }}" class="space-y-4">@csrf @method('PATCH')
      <div><label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label><input type="text" name="nom" value="{{ old('nom',$admin->nom) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
      <div><label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label><input type="email" name="email" value="{{ old('email',$admin->email) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
      <button type="submit" class="bg-amber-800 hover:bg-amber-900 text-white text-sm font-medium px-5 py-2 rounded-lg">Guardar</button>
    </form>
  </div>
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="font-semibold text-gray-700 mb-4">Cambiar contraseña</h2>
    <form method="POST" action="{{ route('admin.account.password') }}" class="space-y-4">@csrf @method('PATCH')
      <div><label class="block text-sm font-medium text-gray-700 mb-1">Contraseña actual</label><input type="password" name="mot_de_passe_actuel" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
      <div><label class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña (mín. 10 caracteres)</label><input type="password" name="nouveau_mot_de_passe" required minlength="10" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
      <div><label class="block text-sm font-medium text-gray-700 mb-1">Confirmar</label><input type="password" name="nouveau_mot_de_passe_confirmation" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></div>
      <button type="submit" class="bg-amber-800 hover:bg-amber-900 text-white text-sm font-medium px-5 py-2 rounded-lg">Actualizar</button>
    </form>
  </div>
</div>
@endsection
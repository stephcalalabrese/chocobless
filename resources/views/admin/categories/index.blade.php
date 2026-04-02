@extends('admin.layout')
@section('page-title','Categorías')
@section('header-actions')<a href="{{ route('admin.categories.create') }}" class="bg-amber-800 hover:bg-amber-900 text-white text-sm font-medium px-4 py-2 rounded-lg">+ Nueva categoría</a>@endsection
@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-gray-50 text-gray-500 text-xs uppercase"><tr><th class="px-6 py-3 text-left">Nombre</th><th class="px-6 py-3 text-left">Superior</th><th class="px-6 py-3 text-left">Productos</th><th class="px-6 py-3 text-left">Estado</th><th class="px-6 py-3 text-right">Acciones</th></tr></thead>
    <tbody class="divide-y divide-gray-100">
      @forelse($categories as $cat)
      <tr class="hover:bg-gray-50">
        <td class="px-6 py-3 font-medium text-gray-800">{{ $cat->nom }}<p class="text-xs text-gray-400 font-mono">{{ $cat->slug }}</p></td>
        <td class="px-6 py-3 text-gray-500">{{ $cat->parent?->nom ?? '—' }}</td>
        <td class="px-6 py-3 text-center"><span class="bg-amber-50 text-amber-800 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $cat->products_count }}</span></td>
        <td class="px-6 py-3"><span class="px-2 py-1 rounded-full text-xs {{ $cat->actif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">{{ $cat->actif ? 'Activa' : 'Inactiva' }}</span></td>
        <td class="px-6 py-3 text-right"><a href="{{ route('admin.categories.edit',$cat) }}" class="text-amber-700 hover:underline text-xs mr-2">Editar</a><form method="POST" action="{{ route('admin.categories.destroy',$cat) }}" class="inline" onsubmit="return confirm('¿Eliminar?')">@csrf @method('DELETE')<button class="text-xs text-red-500 hover:underline">Elim.</button></form></td>
      </tr>
      @empty
      <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">No hay categorías.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
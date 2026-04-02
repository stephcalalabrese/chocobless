@extends('admin.layout')
@section('page-title','Productos')
@section('header-actions')
<a href="{{ route('admin.products.create') }}" class="bg-amber-800 hover:bg-amber-900 text-white text-sm font-medium px-4 py-2 rounded-lg">+ Nuevo producto</a>
@endsection
@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-gray-50 text-gray-500 text-xs uppercase"><tr><th class="px-6 py-3 text-left">Producto</th><th class="px-6 py-3 text-left">Categoría</th><th class="px-6 py-3 text-left">Precio mín.</th><th class="px-6 py-3 text-left">Estado</th><th class="px-6 py-3 text-right">Acciones</th></tr></thead>
    <tbody class="divide-y divide-gray-100">
      @forelse($products as $product)
      <tr class="hover:bg-gray-50">
        <td class="px-6 py-3 font-medium text-gray-800">{{ $product->nom }}</td>
        <td class="px-6 py-3 text-gray-500">{{ $product->category?->nom ?? '—' }}</td>
        <td class="px-6 py-3">{{ $product->prix_min ? number_format($product->prix_min,0,',',' ').' COP' : '—' }}</td>
        <td class="px-6 py-3"><span class="px-2 py-1 rounded-full text-xs {{ $product->actif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">{{ $product->actif ? 'Activo' : 'Inactivo' }}</span></td>
        <td class="px-6 py-3 text-right"><a href="{{ route('admin.products.edit',$product) }}" class="text-amber-700 hover:underline text-xs mr-3">Editar</a><form method="POST" action="{{ route('admin.products.destroy',$product) }}" class="inline" onsubmit="return confirm('¿Eliminar?')">@csrf @method('DELETE')<button class="text-xs text-red-500 hover:underline">Elim.</button></form></td>
      </tr>
      @empty
      <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">No hay productos.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="px-6 py-4 border-t border-gray-100">{{ $products->links() }}</div>
</div>
@endsection
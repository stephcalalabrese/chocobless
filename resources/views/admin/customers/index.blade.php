@extends('admin.layout')
@section('page-title','Clientes')
@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-gray-50 text-gray-500 text-xs uppercase"><tr><th class="px-6 py-3 text-left">Cliente</th><th class="px-6 py-3 text-left">Teléfono</th><th class="px-6 py-3 text-left">Pedidos</th><th class="px-6 py-3 text-left">Registrado</th><th class="px-6 py-3 text-right">Acciones</th></tr></thead>
    <tbody class="divide-y divide-gray-100">
      @forelse($customers as $customer)
      <tr class="hover:bg-gray-50">
        <td class="px-6 py-3"><p class="font-medium">{{ $customer->full_name }}</p><p class="text-xs text-gray-400">{{ $customer->email }}</p></td>
        <td class="px-6 py-3 text-gray-500">{{ $customer->telephone ?? '—' }}</td>
        <td class="px-6 py-3 text-center"><span class="bg-amber-50 text-amber-800 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $customer->orders_count }}</span></td>
        <td class="px-6 py-3 text-gray-400 text-xs">{{ $customer->cree_le->format('d/m/Y') }}</td>
        <td class="px-6 py-3 text-right"><a href="{{ route('admin.customers.show',$customer) }}" class="text-amber-700 hover:underline text-xs">Detalle</a></td>
      </tr>
      @empty
      <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">No hay clientes.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="px-6 py-4 border-t border-gray-100">{{ $customers->links() }}</div>
</div>
@endsection
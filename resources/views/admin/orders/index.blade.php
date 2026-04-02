@extends('admin.layout')
@section('page-title','Pedidos')
@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-gray-50 text-gray-500 text-xs uppercase"><tr><th class="px-6 py-3 text-left">N° pedido</th><th class="px-6 py-3 text-left">Cliente</th><th class="px-6 py-3 text-left">Total</th><th class="px-6 py-3 text-left">Estado</th><th class="px-6 py-3 text-left">Fecha</th><th class="px-6 py-3 text-right">Acción</th></tr></thead>
    <tbody class="divide-y divide-gray-100">
      @forelse($orders as $order)
      <tr class="hover:bg-gray-50">
        <td class="px-6 py-3 font-mono font-medium text-amber-800"><a href="{{ route('admin.orders.show',$order) }}" class="hover:underline">{{ $order->numero_commande }}</a></td>
        <td class="px-6 py-3">{{ $order->customer?->full_name ?? '—' }}</td>
        <td class="px-6 py-3 font-semibold">{{ number_format($order->total,0,',',' ') }} COP</td>
        <td class="px-6 py-3"><span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">{{ $order->statut_label }}</span></td>
        <td class="px-6 py-3 text-gray-400 text-xs">{{ $order->cree_le->format('d/m/Y H:i') }}</td>
        <td class="px-6 py-3 text-right"><a href="{{ route('admin.orders.show',$order) }}" class="text-amber-700 hover:underline text-xs">Detalle →</a></td>
      </tr>
      @empty
      <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">No hay pedidos.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="px-6 py-4 border-t border-gray-100">{{ $orders->links() }}</div>
</div>
@endsection
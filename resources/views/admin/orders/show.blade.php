@extends('admin.layout')
@section('page-title','Pedido '.$order->numero_commande)
@section('header-actions')<a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-800">← Volver</a>@endsection
@section('content')
<div class="grid grid-cols-3 gap-6">
  <div class="col-span-2">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-4">
      <div class="px-6 py-4 border-b border-gray-100 font-semibold text-gray-700">Artículos</div>
      <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase"><tr><th class="px-6 py-3 text-left">Producto</th><th class="px-6 py-3 text-center">Cant.</th><th class="px-6 py-3 text-right">Precio</th><th class="px-6 py-3 text-right">Subtotal</th></tr></thead>
        <tbody class="divide-y divide-gray-100">
          @foreach($order->items as $item)
          <tr><td class="px-6 py-3"><p class="font-medium">{{ $item->nom_produit }}</p><p class="text-xs text-gray-400">{{ $item->label_variante }}</p></td><td class="px-6 py-3 text-center">{{ $item->quantite }}</td><td class="px-6 py-3 text-right">{{ number_format($item->prix_unitaire,0,',',' ') }}</td><td class="px-6 py-3 text-right font-semibold">{{ number_format($item->sous_total,0,',',' ') }}</td></tr>
          @endforeach
        </tbody>
        <tfoot class="bg-gray-50"><tr class="font-bold"><td colspan="3" class="px-6 py-3 text-right">TOTAL</td><td class="px-6 py-3 text-right">{{ number_format($order->total,0,',',' ') }} COP</td></tr></tfoot>
      </table>
    </div>
  </div>
  <div class="space-y-4">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
      <p class="font-semibold text-gray-700 mb-3">Cambiar estado</p>
      <form method="POST" action="{{ route('admin.orders.status',$order) }}">@csrf @method('PATCH')
        <select name="statut" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm mb-3">@foreach($statuts as $key=>$s)<option value="{{ $key }}" @selected($order->statut===$key)>{{ $s['label'] }}</option>@endforeach</select>
        <button class="w-full bg-amber-800 hover:bg-amber-900 text-white text-sm py-2 rounded-lg">Actualizar</button>
      </form>
      <div class="mt-6 pt-4 border-t border-red-100">
        <p class="text-xs font-semibold text-red-400 uppercase tracking-wide mb-2">Zona de peligro</p>
        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
              onsubmit="return confirm('¿Eliminar definitivamente el pedido {{ $order->numero_commande }}? Esta acción no se puede deshacer.')">
          @csrf @method('DELETE')
          <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 text-sm font-medium px-4 py-2.5 rounded-lg transition-all">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Eliminar pedido definitivamente
          </button>
        </form>
      </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
      <p class="font-semibold text-gray-700 mb-2">Cliente</p>
      <p class="text-sm">{{ $order->customer?->full_name }}</p>
      <p class="text-sm text-gray-500">{{ $order->customer?->email }}</p>
      <p class="text-sm text-gray-500">{{ $order->customer?->telephone }}</p>
    </div>
  </div>
</div>
@endsection
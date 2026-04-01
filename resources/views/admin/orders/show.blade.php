@extends('admin.layout')
@section('page-title','Commande '.$order->numero_commande)
@section('header-actions')<a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-800">← Retour</a>@endsection
@section('content')
<div class="grid grid-cols-3 gap-6">
  <div class="col-span-2">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-4">
      <div class="px-6 py-4 border-b border-gray-100 font-semibold text-gray-700">Articles</div>
      <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase"><tr><th class="px-6 py-3 text-left">Produit</th><th class="px-6 py-3 text-center">Qté</th><th class="px-6 py-3 text-right">Prix</th><th class="px-6 py-3 text-right">Sous-total</th></tr></thead>
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
      <p class="font-semibold text-gray-700 mb-3">Changer le statut</p>
      <form method="POST" action="{{ route('admin.orders.status',$order) }}">@csrf @method('PATCH')
        <select name="statut" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm mb-3">@foreach($statuts as $key=>$s)<option value="{{ $key }}" @selected($order->statut===$key)>{{ $s['label'] }}</option>@endforeach</select>
        <button class="w-full bg-amber-800 hover:bg-amber-900 text-white text-sm py-2 rounded-lg">Mettre à jour</button>
      </form>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
      <p class="font-semibold text-gray-700 mb-2">Client</p>
      <p class="text-sm">{{ $order->customer?->full_name }}</p>
      <p class="text-sm text-gray-500">{{ $order->customer?->email }}</p>
      <p class="text-sm text-gray-500">{{ $order->customer?->telephone }}</p>
    </div>
  </div>
</div>
@endsection

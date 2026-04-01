@extends('admin.layout')
@section('page-title','Tableau de bord')
@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
  <div class="bg-white rounded-xl border border-gray-200 p-5"><p class="text-sm text-gray-500">Commandes aujourd'hui</p><p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['commandes_aujourd_hui'] }}</p></div>
  <div class="bg-white rounded-xl border border-gray-200 p-5"><p class="text-sm text-gray-500">CA ce mois (COP)</p><p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['ca_ce_mois'],0,',',' ') }}</p></div>
  <div class="bg-white rounded-xl border border-gray-200 p-5"><p class="text-sm text-gray-500">En attente</p><p class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['commandes_en_attente'] }}</p></div>
  <div class="bg-white rounded-xl border border-gray-200 p-5"><p class="text-sm text-gray-500">Clients total</p><p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['clients_total'] }}</p></div>
</div>
<div class="bg-white rounded-xl border border-gray-200">
  <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <h2 class="font-semibold text-gray-700">Dernières commandes</h2>
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-amber-700 hover:underline">Voir tout →</a>
  </div>
  <table class="w-full text-sm">
    <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
      <tr>
        <th class="px-6 py-3 text-left">N° commande</th>
        <th class="px-6 py-3 text-left">Client</th>
        <th class="px-6 py-3 text-left">Total</th>
        <th class="px-6 py-3 text-left">Statut</th>
        <th class="px-6 py-3 text-left">Date</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
      @forelse($dernieres_commandes as $order)
      <tr class="hover:bg-gray-50">
        <td class="px-6 py-3 font-mono font-medium text-amber-800"><a href="{{ route('admin.orders.show',$order) }}" class="hover:underline">{{ $order->numero_commande }}</a></td>
        <td class="px-6 py-3">{{ $order->customer?->full_name ?? '—' }}</td>
        <td class="px-6 py-3 font-semibold">{{ number_format($order->total,0,',',' ') }} COP</td>
        <td class="px-6 py-3"><span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">{{ $order->statut_label }}</span></td>
        <td class="px-6 py-3 text-gray-400">{{ $order->cree_le->format('d/m/Y H:i') }}</td>
      </tr>
      @empty
      <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Aucune commande pour l'instant.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection

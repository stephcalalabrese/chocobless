@extends('admin.layout')
@section('page-title', $customer->full_name)
@section('header-actions')<a href="{{ route('admin.customers.index') }}" class="text-sm text-gray-500 hover:text-gray-800">← Retour</a>@endsection
@section('content')
<div class="grid grid-cols-3 gap-6">
  <div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
      <p class="font-semibold text-lg text-gray-800">{{ $customer->full_name }}</p>
      <p class="text-sm text-gray-500 mt-1">{{ $customer->email }}</p>
      <p class="text-sm text-gray-500">{{ $customer->telephone ?? '—' }}</p>
      <p class="text-sm text-gray-400 mt-2">Inscrit le {{ $customer->cree_le->format('d/m/Y') }}</p>
      <div class="mt-4 pt-4 border-t border-gray-100">
        <form method="POST" action="{{ route('admin.customers.toggle',$customer) }}">@csrf @method('PATCH')
          <button class="text-sm {{ $customer->actif ? 'text-orange-500' : 'text-green-600' }} hover:underline">{{ $customer->actif ? 'Désactiver' : 'Activer' }}</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-span-2">
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-100 font-semibold text-gray-700">Dernières commandes</div>
      <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase"><tr><th class="px-6 py-3 text-left">N°</th><th class="px-6 py-3 text-left">Total</th><th class="px-6 py-3 text-left">Statut</th><th class="px-6 py-3 text-left">Date</th></tr></thead>
        <tbody class="divide-y divide-gray-100">
          @forelse($customer->orders as $order)
          <tr><td class="px-6 py-3 font-mono text-amber-800"><a href="{{ route('admin.orders.show',$order) }}" class="hover:underline">{{ $order->numero_commande }}</a></td><td class="px-6 py-3 font-semibold">{{ number_format($order->total,0,',',' ') }} COP</td><td class="px-6 py-3 text-xs"><span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700">{{ $order->statut_label }}</span></td><td class="px-6 py-3 text-gray-400 text-xs">{{ $order->cree_le->format('d/m/Y') }}</td></tr>
          @empty
          <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">Aucune commande.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

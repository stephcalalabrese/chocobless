@extends('admin.layout')
@section('page-title','Coupons & promos')
@section('header-actions')<a href="{{ route('admin.coupons.create') }}" class="bg-amber-800 hover:bg-amber-900 text-white text-sm font-medium px-4 py-2 rounded-lg">+ Nouveau coupon</a>@endsection
@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-gray-50 text-gray-500 text-xs uppercase"><tr><th class="px-6 py-3 text-left">Code</th><th class="px-6 py-3 text-left">Type</th><th class="px-6 py-3 text-left">Valeur</th><th class="px-6 py-3 text-left">Utilisations</th><th class="px-6 py-3 text-left">Expiration</th><th class="px-6 py-3 text-left">Statut</th><th class="px-6 py-3 text-right">Actions</th></tr></thead>
    <tbody class="divide-y divide-gray-100">
      @forelse($coupons as $coupon)
      <tr class="hover:bg-gray-50">
        <td class="px-6 py-3 font-mono font-bold text-amber-800">{{ $coupon->code }}</td>
        <td class="px-6 py-3 text-gray-500">{{ $coupon->type_remise }}</td>
        <td class="px-6 py-3 font-semibold">{{ $coupon->type_remise==='pourcent' ? $coupon->valeur.'%' : number_format($coupon->valeur,0,',',' ').' COP' }}</td>
        <td class="px-6 py-3 text-gray-500">{{ $coupon->utilisations_actuelles }} / {{ $coupon->utilisations_max ?? '∞' }}</td>
        <td class="px-6 py-3 text-gray-500 text-xs">{{ $coupon->date_expiration ? $coupon->date_expiration->format('d/m/Y') : 'Sans limite' }}</td>
        <td class="px-6 py-3"><span class="px-2 py-1 rounded-full text-xs {{ $coupon->isValid() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">{{ $coupon->isValid() ? 'Valide' : 'Expiré' }}</span></td>
        <td class="px-6 py-3 text-right"><a href="{{ route('admin.coupons.edit',$coupon) }}" class="text-amber-700 hover:underline text-xs mr-2">Modifier</a><form method="POST" action="{{ route('admin.coupons.destroy',$coupon) }}" class="inline" onsubmit="return confirm('Supprimer ?')">@csrf @method('DELETE')<button class="text-xs text-red-500 hover:underline">Suppr.</button></form></td>
      </tr>
      @empty
      <tr><td colspan="7" class="px-6 py-10 text-center text-gray-400">Aucun coupon.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div class="px-6 py-4 border-t border-gray-100">{{ $coupons->links() }}</div>
</div>
@endsection

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Georgia, serif; background: #fdf5ee; margin: 0; padding: 20px; color: #3d1c02; }
    .card { background: white; max-width: 600px; margin: 0 auto; border-radius: 16px; overflow: hidden; border: 1px solid #e8d5b0; }
    .header { background: #3d1c02; padding: 30px; text-align: center; }
    .header h1 { color: #c9a84c; margin: 0; font-size: 24px; }
    .header p { color: #c9a84c; opacity: 0.7; margin: 5px 0 0; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; }
    .body { padding: 30px; }
    .alert { background: #fef9ee; border: 1px solid #c9a84c; border-radius: 10px; padding: 15px 20px; margin-bottom: 25px; }
    .alert p { margin: 0; font-size: 15px; }
    .section-title { font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; margin: 25px 0 10px; }
    .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f5e6d3; font-size: 14px; }
    .info-row:last-child { border-bottom: none; }
    .label { color: #888; }
    .value { font-weight: bold; color: #3d1c02; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { background: #fdf5ee; padding: 10px 12px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; }
    td { padding: 10px 12px; border-bottom: 1px solid #f5e6d3; font-size: 14px; }
    .total-row td { font-weight: bold; font-size: 16px; color: #3d1c02; border-bottom: none; }
    .btn { display: inline-block; background: #3d1c02; color: #c9a84c; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-size: 14px; margin-top: 20px; }
    .footer { background: #fdf5ee; padding: 20px; text-align: center; font-size: 12px; color: #aaa; }
  </style>
</head>
<body>
<div class="card">
  <div class="header">
    <h1>🍫 ChocoBless</h1>
    <p>Nueva orden recibida</p>
  </div>
  <div class="body">
    <div class="alert">
      <p>¡Tienes una nueva orden! <strong>#{{ $order->numero_commande }}</strong> por <strong>{{ number_format($order->total, 0, ',', '.') }} COP</strong></p>
    </div>

    <p class="section-title">Datos del cliente</p>
    <div class="info-row"><span class="label">Nombre</span><span class="value">{{ $order->customer->full_name }}</span></div>
    <div class="info-row"><span class="label">Email</span><span class="value">{{ $order->customer->email }}</span></div>
    <div class="info-row"><span class="label">Teléfono</span><span class="value">{{ $order->customer->telephone ?? '—' }}</span></div>
    <div class="info-row"><span class="label">Pago</span><span class="value">{{ $order->methode_paiement }}</span></div>

    @if($order->address)
    <p class="section-title">Dirección de entrega</p>
    <div class="info-row"><span class="label">Dirección</span><span class="value">{{ $order->address->rue }}</span></div>
    <div class="info-row"><span class="label">Barrio</span><span class="value">{{ $order->address->barrio ?? '—' }}</span></div>
    <div class="info-row"><span class="label">Ciudad</span><span class="value">{{ $order->address->ciudad }}</span></div>
    @endif

    @if($order->notes)
    <p class="section-title">Nota del cliente</p>
    <p style="font-size:14px; color:#666; font-style:italic;">{{ $order->notes }}</p>
    @endif

    <p class="section-title">Productos</p>
    <table>
      <tr>
        <th>Producto</th>
        <th>Cant.</th>
        <th style="text-align:right">Subtotal</th>
      </tr>
      @foreach($order->items as $item)
      <tr>
        <td>
          {{ $item->nom_produit }}<br>
          <span style="font-size:12px; color:#999;">{{ $item->label_variante }}</span>
        </td>
        <td>{{ $item->quantite }}</td>
        <td style="text-align:right">{{ number_format($item->sous_total, 0, ',', '.') }} COP</td>
      </tr>
      @endforeach
      @if($order->remise > 0)
      <tr>
        <td colspan="2" style="text-align:right; color:green;">Descuento</td>
        <td style="text-align:right; color:green;">-{{ number_format($order->remise, 0, ',', '.') }} COP</td>
      </tr>
      @endif
      <tr class="total-row">
        <td colspan="2" style="text-align:right">TOTAL</td>
        <td style="text-align:right; color:#c9a84c;">{{ number_format($order->total, 0, ',', '.') }} COP</td>
      </tr>
    </table>

    <div style="text-align:center; margin-top:25px;">
      <a href="https://choco-bless.com/admin/admin/orders" class="btn">
        Ver pedido en el panel →
      </a>
    </div>
  </div>
  <div class="footer">
    ChocoBless · diana@choco-bless.com · 311 798 9152
  </div>
</div>
</body>
</html>

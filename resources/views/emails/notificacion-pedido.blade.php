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
    .status-banner { border-radius: 10px; padding: 20px; margin-bottom: 25px; text-align: center; }
    .status-icon { font-size: 36px; display: block; margin-bottom: 8px; }
    .status-title { font-size: 22px; font-weight: bold; color: #3d1c02; margin: 0 0 8px; }
    .status-msg { font-size: 14px; color: #666; line-height: 1.6; margin: 0; }
    .order-num { background: #fdf5ee; border: 1px solid #e8d5b0; border-radius: 8px; padding: 12px 20px; text-align: center; margin-bottom: 25px; }
    .order-num span { font-family: 'Courier New', monospace; font-size: 18px; font-weight: bold; color: #3d1c02; }
    .section-title { font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; margin: 25px 0 10px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { background: #fdf5ee; padding: 10px 12px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; }
    td { padding: 10px 12px; border-bottom: 1px solid #f5e6d3; font-size: 14px; }
    .total-row td { font-weight: bold; font-size: 16px; color: #3d1c02; border-bottom: none; }
    .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f5e6d3; font-size: 14px; }
    .info-row:last-child { border-bottom: none; }
    .label { color: #888; }
    .value { font-weight: bold; color: #3d1c02; }
    .btn-wa { display: inline-block; background: #25D366; color: white; padding: 14px 32px; border-radius: 30px; text-decoration: none; font-size: 14px; font-weight: bold; }
    .footer { background: #fdf5ee; padding: 20px; text-align: center; font-size: 12px; color: #aaa; }
  </style>
</head>
<body>
<div class="card">
  <div class="header">
    <h1>🍫 ChocoBless</h1>
    <p>Endulzando tu día</p>
  </div>
  <div class="body">

    {{-- Banner de estado --}}
    <div class="status-banner" style="background: {{ $config['color'] }}15; border: 1px solid {{ $config['color'] }}30;">
      <span class="status-icon">{{ $config['icono'] }}</span>
      <p class="status-title">{{ $config['titulo'] }}</p>
      <p class="status-msg">{{ $config['mensaje'] }}</p>
    </div>

    {{-- Número de pedido --}}
    <div class="order-num">
      <p style="font-size:12px; color:#888; margin:0 0 4px; text-transform:uppercase; letter-spacing:1px;">Número de pedido</p>
      <span>{{ $order->numero_commande }}</span>
    </div>

    {{-- Productos --}}
    <p class="section-title">Tu pedido</p>
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

    {{-- Datos de entrega --}}
    @if($order->address)
    <p class="section-title">Datos de entrega</p>
    <div class="info-row"><span class="label">Nombre</span><span class="value">{{ $order->customer->full_name }}</span></div>
    <div class="info-row"><span class="label">Dirección</span><span class="value">{{ $order->address->rue }}</span></div>
    <div class="info-row"><span class="label">Ciudad</span><span class="value">{{ $order->address->ciudad }}</span></div>
    <div class="info-row"><span class="label">Pago</span><span class="value">{{ $order->methode_paiement }}</span></div>
    @endif

    {{-- WhatsApp CTA --}}
    <div style="text-align:center; margin-top:30px;">
      <p style="font-size:13px; color:#888; margin-bottom:12px;">¿Tienes alguna pregunta sobre tu pedido?</p>
      <a href="https://wa.me/573117989152?text={{ rawurlencode('Hola Diana, tengo una pregunta sobre mi pedido #' . $order->numero_commande) }}"
         class="btn-wa">
        💬 Escríbenos por WhatsApp
      </a>
    </div>

  </div>
  <div class="footer">
    ChocoBless · Diana Suarez · Bogotá, Colombia<br>
    <a href="https://choco-bless.com" style="color:#c9a84c; text-decoration:none;">choco-bless.com</a> · 311 798 9152
  </div>
</div>
</body>
</html>

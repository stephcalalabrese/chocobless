<?php
namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionPedido extends Mailable
{
    use Queueable, SerializesModels;

    public string $tipo;

    // Configuración por tipo de notificación
    const TIPOS = [
        'en_attente' => [
            'subject'  => '🍫 Pedido recibido #%s — ChocoBless',
            'titulo'   => '¡Recibimos tu pedido!',
            'mensaje'  => 'Gracias por confiar en ChocoBless. Tu pedido ha sido recibido y está siendo revisado. Te contactaremos pronto por WhatsApp para coordinar los detalles.',
            'color'    => '#c9a84c',
            'icono'    => '📋',
        ],
        'confirmee' => [
            'subject'  => '✅ Pedido confirmado #%s — ChocoBless',
            'titulo'   => '¡Tu pedido está confirmado!',
            'mensaje'  => '¡Excelentes noticias! Tu pedido ha sido confirmado y ya estamos preparando tus delicias con todo el amor. Te avisaremos cuando esté listo para la entrega.',
            'color'    => '#2563eb',
            'icono'    => '✅',
        ],
        'en_livraison' => [
            'subject'  => '🚚 Pedido en camino #%s — ChocoBless',
            'titulo'   => '¡Tu pedido va en camino!',
            'mensaje'  => 'Tu pedido ya salió de nuestra cocina y va en camino hacia ti. Prepárate para disfrutar de tus delicias ChocoBless. ¡Que lo disfrutes!',
            'color'    => '#ea580c',
            'icono'    => '🚚',
        ],
        'annulee' => [
            'subject'  => '❌ Pedido cancelado #%s — ChocoBless',
            'titulo'   => 'Tu pedido ha sido cancelado',
            'mensaje'  => 'Lamentamos informarte que tu pedido ha sido cancelado. Si tienes alguna pregunta o deseas realizar un nuevo pedido, no dudes en contactarnos por WhatsApp.',
            'color'    => '#dc2626',
            'icono'    => '❌',
        ],
    ];

    public function __construct(public Order $order, string $tipo)
    {
        $this->tipo = $tipo;
    }

    public function envelope(): Envelope
    {
        $config = self::TIPOS[$this->tipo] ?? self::TIPOS['en_attente'];
        return new Envelope(
            subject: sprintf($config['subject'], $this->order->numero_commande),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notificacion-pedido',
            with: [
                'order'  => $this->order,
                'config' => self::TIPOS[$this->tipo] ?? self::TIPOS['en_attente'],
            ],
        );
    }
}

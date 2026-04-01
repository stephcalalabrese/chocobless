<?php
// app/Http/Controllers/Shop/ContactController.php
namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function show()
    {
        return view('shop.contact');
    }

    public function send(Request $request)
    {
        // ── Anti-spam honeypot ─────────────────────────────
        // Campo oculto: si está relleno, es un bot
        if ($request->filled('website')) {
            return redirect()->route('shop.contact')->with('success',
                '¡Mensaje enviado! Te contactaremos pronto.');
        }

        // ── Rate limiting ──────────────────────────────────
        // Máximo 3 envíos por IP cada 10 minutos
        $key = 'contact.' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Demasiados intentos. Por favor espera {$seconds} segundos.",
            ]);
        }
        RateLimiter::hit($key, 600); // 10 minutos

        // ── Validación ─────────────────────────────────────
        $data = $request->validate([
            'nombre'   => 'required|string|min:2|max:100',
            'email'    => 'required|email:rfc,dns|max:150',
            'telefono' => ['nullable', 'string', 'max:20',
                           'regex:/^[0-9\s\+\-\(\)]{7,20}$/'],
            'ocasion'  => 'nullable|string|max:100',
            'mensaje'  => 'required|string|min:10|max:1000',
        ], [
            'nombre.required'   => 'Por favor ingresa tu nombre.',
            'nombre.min'        => 'El nombre debe tener al menos 2 caracteres.',
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Por favor ingresa un correo electrónico válido.',
            'telefono.regex'    => 'Por favor ingresa un número de teléfono válido.',
            'mensaje.required'  => 'Por favor escribe tu mensaje.',
            'mensaje.min'       => 'El mensaje debe tener al menos 10 caracteres.',
        ]);

        // ── Envío del email ────────────────────────────────
        try {
            Mail::send([], [], function ($mail) use ($data) {
                $mail->to('diana@choco-bless.com')
                     ->replyTo($data['email'], $data['nombre'])
                     ->subject('✉️ Nuevo mensaje de contacto — ChocoBless')
                     ->html($this->buildEmailHtml($data));
            });
        } catch (\Exception $e) {
            \Log::error('Contact email failed: ' . $e->getMessage());
            return back()->withInput()->with('error',
                'Hubo un problema al enviar tu mensaje. Por favor escríbenos directamente por WhatsApp.');
        }

        return redirect()->route('shop.contact')
                         ->with('success', '¡Mensaje enviado con éxito! Diana te contactará pronto 🍫');
    }

    private function buildEmailHtml(array $data): string
    {
        $ocasion  = $data['ocasion'] ?? 'No especificada';
        $telefono = $data['telefono'] ?? 'No proporcionado';
        $nombre   = htmlspecialchars($data['nombre']);
        $email    = htmlspecialchars($data['email']);
        $mensaje  = nl2br(htmlspecialchars($data['mensaje']));

        return "
        <div style='font-family:Georgia,serif;max-width:600px;margin:0 auto;background:#fdf5ee;'>
          <div style='background:#3d1c02;padding:32px 40px;text-align:center;'>
            <h1 style='color:#c9a84c;font-size:24px;margin:0;'>ChocoBless</h1>
            <p style='color:rgba(253,245,238,.6);font-size:13px;margin:6px 0 0;'>Nuevo mensaje de contacto</p>
          </div>
          <div style='padding:32px 40px;'>
            <table style='width:100%;border-collapse:collapse;margin-bottom:24px;'>
              <tr><td style='padding:10px 0;border-bottom:1px solid rgba(61,28,2,.1);font-size:13px;color:rgba(61,28,2,.5);width:130px;'>Nombre</td>
                  <td style='padding:10px 0;border-bottom:1px solid rgba(61,28,2,.1);font-size:14px;color:#3d1c02;font-weight:600;'>{$nombre}</td></tr>
              <tr><td style='padding:10px 0;border-bottom:1px solid rgba(61,28,2,.1);font-size:13px;color:rgba(61,28,2,.5);'>Email</td>
                  <td style='padding:10px 0;border-bottom:1px solid rgba(61,28,2,.1);font-size:14px;color:#3d1c02;'><a href='mailto:{$email}' style='color:#c9a84c;'>{$email}</a></td></tr>
              <tr><td style='padding:10px 0;border-bottom:1px solid rgba(61,28,2,.1);font-size:13px;color:rgba(61,28,2,.5);'>Teléfono</td>
                  <td style='padding:10px 0;border-bottom:1px solid rgba(61,28,2,.1);font-size:14px;color:#3d1c02;'>{$telefono}</td></tr>
              <tr><td style='padding:10px 0;border-bottom:1px solid rgba(61,28,2,.1);font-size:13px;color:rgba(61,28,2,.5);'>Ocasión</td>
                  <td style='padding:10px 0;border-bottom:1px solid rgba(61,28,2,.1);font-size:14px;color:#3d1c02;'>{$ocasion}</td></tr>
            </table>
            <div style='background:#fff;border-radius:8px;padding:20px;border-left:3px solid #c9a84c;'>
              <p style='font-size:12px;color:rgba(61,28,2,.4);margin:0 0 8px;text-transform:uppercase;letter-spacing:.1em;'>Mensaje</p>
              <p style='font-size:15px;color:#3d1c02;line-height:1.7;margin:0;'>{$mensaje}</p>
            </div>
          </div>
          <div style='background:#3d1c02;padding:20px 40px;text-align:center;'>
            <p style='color:rgba(253,245,238,.4);font-size:12px;margin:0;'>© " . date('Y') . " ChocoBless · diana@choco-bless.com</p>
          </div>
        </div>";
    }
}

@extends('shop.layout')
@section('title', 'Contacto — ChocoBless')
@section('description', 'Escríbenos para tu pedido personalizado. Diana Suarez crea delicias artesanales de chocolate en Bogotá para cada celebración especial.')

@push('styles')
<style>
  .contact-wrap { max-width:1060px; margin:0 auto; padding:60px 24px 80px; }

  /* Hero */
  .contact-hero { text-align:center; margin-bottom:56px; }
  .contact-eyebrow { font-size:11px; font-weight:600; letter-spacing:.2em; text-transform:uppercase; color:#c9a84c; display:block; margin-bottom:12px; }
  .contact-title { font-family:'Cormorant Garamond',Georgia,serif; font-size:clamp(32px,4vw,52px); font-weight:400; color:#3d1c02; line-height:1.1; margin-bottom:16px; }
  .contact-subtitle { font-size:15px; font-weight:300; color:rgba(61,28,2,.6); max-width:520px; margin:0 auto; line-height:1.7; }

  /* Grid */
  .contact-grid { display:grid; grid-template-columns:1fr 380px; gap:40px; align-items:start; }
  @media(max-width:900px){ .contact-grid{ grid-template-columns:1fr; } }

  /* Form */
  .contact-form-card { background:#fff; border-radius:12px; border:1px solid rgba(201,168,76,.18); padding:36px; }
  .form-group { margin-bottom:20px; }
  .form-label { display:block; font-size:11px; font-weight:600; letter-spacing:.1em; text-transform:uppercase; color:rgba(61,28,2,.5); margin-bottom:7px; }
  .form-label span { color:#c9a84c; }
  .form-input {
    width:100%; border:1.5px solid rgba(201,168,76,.25); border-radius:6px;
    padding:12px 14px; font-size:14px; color:#3d1c02;
    background:rgba(253,245,238,.5); outline:none;
    transition:border-color .2s, background .2s;
    font-family:'Jost',sans-serif;
  }
  .form-input:focus { border-color:#c9a84c; background:#fff; }
  .form-input.error { border-color:#dc2626; background:#fef2f2; }
  .form-error { font-size:12px; color:#dc2626; margin-top:5px; display:flex; align-items:center; gap:4px; }
  .form-textarea { resize:vertical; min-height:130px; }
  .form-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23c9a84c' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 14px center; padding-right:36px; cursor:pointer; }
  .form-hint { font-size:12px; color:rgba(61,28,2,.4); margin-top:5px; }

  /* Honeypot (caché) */
  .hp-field { position:absolute; left:-9999px; opacity:0; pointer-events:none; }

  /* Submit */
  .btn-submit {
    width:100%; background:#3d1c02; color:#e2c97e;
    border:none; padding:16px; border-radius:6px;
    font-family:'Jost',sans-serif; font-size:13px; font-weight:700;
    letter-spacing:.1em; text-transform:uppercase;
    cursor:pointer; transition:all .25s;
    display:flex; align-items:center; justify-content:center; gap:10px;
  }
  .btn-submit:hover { background:#1e0d00; transform:translateY(-1px); box-shadow:0 8px 24px rgba(61,28,2,.25); }
  .btn-submit:disabled { opacity:.6; cursor:not-allowed; transform:none; }

  /* Alertas */
  .alert-success { background:#f0fdf4; border:1px solid #86efac; color:#166534; padding:16px 20px; border-radius:8px; margin-bottom:24px; font-size:14px; display:flex; align-items:center; gap:10px; }
  .alert-error { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:16px 20px; border-radius:8px; margin-bottom:24px; font-size:14px; display:flex; align-items:center; gap:10px; }

  /* Sidebar info */
  .contact-info { display:flex; flex-direction:column; gap:20px; }
  .contact-info-card { background:#3d1c02; border-radius:12px; padding:28px; }
  .contact-info-title { font-family:'Cormorant Garamond',serif; font-size:22px; color:#fdf5ee; margin-bottom:16px; font-weight:400; }
  .contact-info-item { display:flex; align-items:flex-start; gap:14px; margin-bottom:16px; }
  .contact-info-item:last-child { margin-bottom:0; }
  .contact-info-icon { width:36px; height:36px; background:rgba(201,168,76,.15); border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#c9a84c; }
  .contact-info-text { font-size:13px; color:rgba(253,245,238,.7); line-height:1.5; }
  .contact-info-text strong { display:block; color:#fdf5ee; font-weight:600; margin-bottom:2px; font-size:13px; }

  .contact-wa-btn { display:flex; align-items:center; justify-content:center; gap:10px; background:#25D366; color:#fff; font-size:13px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; padding:15px; border-radius:6px; transition:all .25s; margin-top:4px; }
  .contact-wa-btn:hover { background:#1ebe5b; transform:translateY(-1px); }

  .contact-personalizado { background:rgba(201,168,76,.08); border:1px solid rgba(201,168,76,.2); border-radius:12px; padding:24px; }
  .contact-personalizado-title { font-family:'Cormorant Garamond',serif; font-size:18px; color:#3d1c02; margin-bottom:10px; font-weight:500; }
  .contact-personalizado p { font-size:13px; color:rgba(61,28,2,.65); line-height:1.65; }
  .contact-ocasiones-tags { display:flex; flex-wrap:wrap; gap:6px; margin-top:12px; }
  .contact-tag { font-size:11px; background:rgba(201,168,76,.15); color:#9c7c2a; padding:3px 10px; border-radius:20px; font-weight:500; }

  /* Contador caracteres */
  .char-count { font-size:11px; color:rgba(61,28,2,.35); text-align:right; margin-top:4px; }
  .char-count.warn { color:#d97706; }
  .char-count.limit { color:#dc2626; }
</style>
@endpush

@section('content')
<div class="contact-wrap">

  {{-- Hero --}}
  <div class="contact-hero">
    <span class="contact-eyebrow">Hablemos</span>
    <h1 class="contact-title">¿Tienes un pedido especial en mente?</h1>
    <p class="contact-subtitle">
      Cuéntanos tu idea. Diana diseña cada detalle a tu medida — iniciales, colores, temáticas y mucho más. Cada pedido es único, como tú.
    </p>
  </div>

  {{-- Alertas --}}
  @if(session('success'))
    <div class="alert-success">
      <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="alert-error">
      <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ session('error') }}
    </div>
  @endif

  <div class="contact-grid">

    {{-- Formulario --}}
    <div class="contact-form-card">
      <form method="POST" action="{{ route('shop.contact.send') }}" id="contact-form" novalidate>
        @csrf

        {{-- Honeypot anti-spam (campo oculto) --}}
        <div class="hp-field" aria-hidden="true">
          <label for="website">No rellenes este campo</label>
          <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
        </div>

        {{-- Nombre --}}
        <div class="form-group">
          <label class="form-label" for="nombre">Nombre <span>*</span></label>
          <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"
                 class="form-input @error('nombre') error @enderror"
                 placeholder="Tu nombre completo"
                 autocomplete="name" required>
          @error('nombre')
            <p class="form-error">
              <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        {{-- Email --}}
        <div class="form-group">
          <label class="form-label" for="email">Correo electrónico <span>*</span></label>
          <input type="email" id="email" name="email" value="{{ old('email') }}"
                 class="form-input @error('email') error @enderror"
                 placeholder="tu@correo.com"
                 autocomplete="email" required>
          @error('email')
            <p class="form-error">
              <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        {{-- Teléfono --}}
        <div class="form-group">
          <label class="form-label" for="telefono">WhatsApp / Teléfono</label>
          <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}"
                 class="form-input @error('telefono') error @enderror"
                 placeholder="300 000 0000"
                 autocomplete="tel">
          @error('telefono')
            <p class="form-error">
              <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              {{ $message }}
            </p>
          @enderror
          <p class="form-hint">Opcional — para respuesta más rápida por WhatsApp</p>
        </div>

        {{-- Ocasión --}}
        <div class="form-group">
          <label class="form-label" for="ocasion">¿Para qué ocasión?</label>
          <select id="ocasion" name="ocasion" class="form-input form-select">
            <option value="">Seleccionar ocasión...</option>
            @foreach(\App\Models\Ocasion::actif()->get() as $oc)
              <option value="{{ $oc->nom }}" @selected(old('ocasion') === $oc->nom)>
                {{ $oc->icono }} {{ $oc->nom }}
              </option>
            @endforeach
            <option value="Otro" @selected(old('ocasion') === 'Otro')>🎉 Otro</option>
          </select>
        </div>

        {{-- Mensaje --}}
        <div class="form-group">
          <label class="form-label" for="mensaje">Tu mensaje <span>*</span></label>
          <textarea id="mensaje" name="mensaje" rows="5"
                    class="form-input form-textarea @error('mensaje') error @enderror"
                    placeholder="Cuéntame tu idea: qué producto te interesa, para cuántas personas, la fecha del evento, colores, iniciales o cualquier detalle especial..."
                    maxlength="1000" required
                    oninput="updateCharCount(this)">{{ old('mensaje') }}</textarea>
          @error('mensaje')
            <p class="form-error">
              <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              {{ $message }}
            </p>
          @enderror
          <p class="char-count" id="char-count">0 / 1000</p>
        </div>

        <button type="submit" class="btn-submit" id="submit-btn">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
          </svg>
          Enviar mensaje
        </button>

      </form>
    </div>

    {{-- Sidebar info --}}
    <div class="contact-info">

      {{-- Datos de contacto --}}
      <div class="contact-info-card">
        <h2 class="contact-info-title">Información de contacto</h2>

        <div class="contact-info-item">
          <div class="contact-info-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          </div>
          <div class="contact-info-text">
            <strong>WhatsApp</strong>
            311 798 9152
          </div>
        </div>

        <div class="contact-info-item">
          <div class="contact-info-icon">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          </div>
          <div class="contact-info-text">
            <strong>Email</strong>
            diana@choco-bless.com
          </div>
        </div>

        <div class="contact-info-item">
          <div class="contact-info-icon">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          </div>
          <div class="contact-info-text">
            <strong>Ubicación</strong>
            Bogotá, Colombia<br>Domicilios a toda la ciudad
          </div>
        </div>

        <div class="contact-info-item">
          <div class="contact-info-icon">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div class="contact-info-text">
            <strong>Anticipación mínima</strong>
            24 horas para pedidos estándar<br>48–72h para pedidos personalizados
          </div>
        </div>

        <a href="https://wa.me/573117989152?text=Hola%20Diana%2C%20quiero%20hacer%20un%20pedido%20personalizado%20🍫"
           target="_blank" class="contact-wa-btn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          Escribir por WhatsApp
        </a>
      </div>

      {{-- Pedidos a medida --}}
      <div class="contact-personalizado">
        <h3 class="contact-personalizado-title">🎨 Pedidos a medida</h3>
        <p>¿Tienes una idea especial? Diana puede crear diseños únicos para cualquier ocasión: iniciales, colores corporativos, temáticas personalizadas y más.</p>
        <div class="contact-ocasiones-tags">
          @foreach(\App\Models\Ocasion::actif()->get() as $oc)
            <span class="contact-tag">{{ $oc->icono }} {{ $oc->nom }}</span>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Contador de caracteres
  function updateCharCount(textarea) {
    const count = textarea.value.length;
    const max = 1000;
    const el = document.getElementById('char-count');
    el.textContent = count + ' / ' + max;
    el.className = 'char-count' + (count > 900 ? ' warn' : '') + (count >= max ? ' limit' : '');
  }

  // Inicializar contador si hay valor previo (old())
  const msgArea = document.getElementById('mensaje');
  if (msgArea && msgArea.value) updateCharCount(msgArea);

  // Validación client-side en tiempo réel
  const emailInput = document.getElementById('email');
  const telefonoInput = document.getElementById('telefono');

  emailInput.addEventListener('blur', function() {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (this.value && !emailRegex.test(this.value)) {
      this.classList.add('error');
    } else {
      this.classList.remove('error');
    }
  });

  telefonoInput.addEventListener('blur', function() {
    const telRegex = /^[0-9\s\+\-\(\)]{7,20}$/;
    if (this.value && !telRegex.test(this.value)) {
      this.classList.add('error');
    } else {
      this.classList.remove('error');
    }
  });

  // Prevenir doble submit
  document.getElementById('contact-form').addEventListener('submit', function() {
    const btn = document.getElementById('submit-btn');
    btn.disabled = true;
    btn.innerHTML = '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Enviando...';
  });
</script>
@endpush

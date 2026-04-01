@extends('shop.layout')
@section('title', 'Nuestra Historia — ChocoBless')
@section('description', 'Diana Suarez — chocolatera artesanal en Bogotá. La historia detrás de ChocoBless, delicias a base de chocolate hechas con amor.')

@push('styles')
<style>
  /* ── Reveal animation ── */
  .reveal { opacity:0; transform:translateY(20px); transition:opacity .6s ease, transform .6s ease; }
  .reveal.visible { opacity:1; transform:none; }

  /* ── Hero ── */
  .nos-hero {
    background:#fdf5ee;
    padding:80px 24px 64px;
    text-align:center;
    border-bottom:1px solid rgba(61,28,2,.08);
  }
  .nos-eyebrow {
    font-size:11px; font-weight:600; letter-spacing:.2em;
    text-transform:uppercase; color:#c9a84c;
    display:block; margin-bottom:16px;
  }
  .nos-hero h1 {
    font-family:'Cormorant Garamond',Georgia,serif;
    font-size:clamp(38px,5vw,64px); font-weight:400;
    font-style:italic; color:#3d1c02;
    line-height:1.1; margin-bottom:20px;
  }
  .nos-hero p {
    font-size:16px; font-weight:300; color:rgba(61,28,2,.65);
    max-width:520px; margin:0 auto; line-height:1.7;
  }

  /* ── Historia ── */
  .nos-historia {
    padding:80px 24px;
    background:#f5e8d8;
  }
  .nos-historia-inner {
    max-width:1060px; margin:0 auto;
    display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center;
  }
  @media(max-width:768px){ .nos-historia-inner{ grid-template-columns:1fr; gap:36px; } }

  .nos-img-wrap {
    border-radius:12px; overflow:hidden;
    background:#2c1208;
    aspect-ratio:4/3;
    display:flex; align-items:center; justify-content:center;
  }
  .nos-img-wrap img {
    width:100%; height:100%; object-fit:contain; padding:40px;
  }

  .nos-historia-content .nos-eyebrow { text-align:left; }
  .nos-historia-content h2 {
    font-family:'Cormorant Garamond',serif;
    font-size:clamp(28px,3.5vw,42px); font-weight:400;
    font-style:italic; color:#3d1c02;
    line-height:1.15; margin-bottom:24px;
  }
  .nos-historia-content p {
    font-size:14px; color:rgba(61,28,2,.7);
    line-height:1.75; margin-bottom:16px; font-weight:300;
  }
  .nos-historia-content p:last-of-type { margin-bottom:32px; }

  .btn-nos {
    display:inline-flex; align-items:center; gap:8px;
    background:#3d1c02; color:#e2c97e;
    font-size:12px; font-weight:600; letter-spacing:.1em;
    text-transform:uppercase; padding:14px 28px;
    border-radius:4px; transition:all .25s; border:none; cursor:pointer;
  }
  .btn-nos:hover { background:#1e0d00; transform:translateY(-2px); }

  /* ── Valores ── */
  .nos-valores {
    padding:80px 24px;
    background:#fdf5ee;
  }
  .nos-valores-header {
    text-align:center; margin-bottom:48px;
  }
  .nos-valores-header h2 {
    font-family:'Cormorant Garamond',serif;
    font-size:clamp(30px,4vw,46px); font-weight:400;
    font-style:italic; color:#3d1c02;
  }
  .nos-valores-list {
    max-width:640px; margin:0 auto;
    display:flex; flex-direction:column; gap:32px;
  }
  .nos-valor {
    display:flex; align-items:flex-start; gap:20px;
  }
  .nos-valor-icon {
    width:44px; height:44px; flex-shrink:0;
    background:rgba(201,168,76,.15); border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-size:20px;
  }
  .nos-valor-title {
    font-family:'Cormorant Garamond',serif;
    font-size:20px; font-weight:500; color:#3d1c02;
    margin-bottom:6px;
  }
  .nos-valor-desc {
    font-size:14px; color:rgba(61,28,2,.6);
    line-height:1.65; font-weight:300;
  }

  /* ── Stats ── */
  .nos-stats {
    background:#3d1c02;
    padding:64px 24px;
  }
  .nos-stats-grid {
    max-width:600px; margin:0 auto;
    display:grid; grid-template-columns:1fr 1fr; gap:2px;
  }
  .nos-stat {
    background:rgba(201,168,76,.08);
    padding:36px 24px; text-align:center;
    border:1px solid rgba(201,168,76,.12);
  }
  .nos-stat-number {
    font-family:'Cormorant Garamond',serif;
    font-size:48px; font-weight:300; font-style:italic;
    color:#e2c97e; line-height:1; display:block; margin-bottom:8px;
  }
  .nos-stat-label {
    font-size:12px; font-weight:500; letter-spacing:.08em;
    text-transform:uppercase; color:rgba(253,245,238,.5);
  }

  /* ── CTA ── */
  .nos-cta {
    padding:80px 24px;
    background:#fdf5ee;
    text-align:center;
  }
  .nos-cta h2 {
    font-family:'Cormorant Garamond',serif;
    font-size:clamp(32px,4vw,52px); font-weight:400;
    font-style:italic; color:#3d1c02;
    margin-bottom:16px;
  }
  .nos-cta p {
    font-size:15px; font-weight:300; color:rgba(61,28,2,.6);
    max-width:440px; margin:0 auto 36px; line-height:1.7;
  }
  .nos-cta-btns {
    display:flex; gap:12px; justify-content:center; flex-wrap:wrap;
  }
  .btn-nos-wa {
    display:inline-flex; align-items:center; gap:8px;
    background:#25D366; color:#fff;
    font-size:12px; font-weight:700; letter-spacing:.1em;
    text-transform:uppercase; padding:14px 28px;
    border-radius:4px; transition:all .25s;
  }
  .btn-nos-wa:hover { background:#1ebe5b; transform:translateY(-2px); }
  .btn-nos-outline {
    display:inline-flex; align-items:center; gap:8px;
    background:transparent; color:#3d1c02;
    border:1.5px solid rgba(61,28,2,.3);
    font-size:12px; font-weight:600; letter-spacing:.1em;
    text-transform:uppercase; padding:14px 28px;
    border-radius:4px; transition:all .25s;
  }
  .btn-nos-outline:hover { background:#3d1c02; color:#e2c97e; }
</style>
@endpush

@section('content')

{{-- Hero --}}
<section class="nos-hero">
  <div>
    <span class="nos-eyebrow reveal">La historia detrás de la magia</span>
    <h1 class="reveal">Nuestra historia</h1>
    <p class="reveal">Cada bombón, cada fresa, cada piñata lleva consigo el sueño de una mujer que convirtió su pasión por el chocolate en arte.</p>
  </div>
</section>

{{-- Historia principal --}}
<section class="nos-historia">
  <div class="nos-historia-inner">

    <div class="nos-img-wrap reveal">
      <img src="/images/products/paleta-oscura.jpg" alt="Diana Suarez — ChocoBless">
    </div>

    <div class="nos-historia-content reveal">
      <span class="nos-eyebrow">Diana Suarez</span>
      <h2>Chocolatera artesanal<br>con alma bogotana</h2>
      <p>Todo comenzó con una fresa, chocolate derretido y el deseo de hacer sonreír a alguien. Soy Diana Suarez, y hace más de 6 años descubrí que el chocolate podía ser mucho más que un dulce — podía ser una experiencia, un recuerdo, un abrazo.</p>
      <p>Empecé en mi cocina en Bogotá, aprendiendo técnicas de temperado, decoración y personalización. Hoy, cada pedido de ChocoBless se elabora con los mismos cuidados que ese primer intento: con las mejores materias primas, atención al detalle y mucho amor.</p>
      <p>Mi filosofía es simple: si no me lo comería yo misma con orgullo, no sale de mi cocina. Eso significa ingredientes de calidad, presentaciones que impresionan y sabores que enamoran.</p>
      <a href="https://wa.me/573117989152?text=Hola%20Diana%2C%20quiero%20hablarte%20de%20mi%20pedido%20🍫" target="_blank" class="btn-nos">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        Hablemos de tu pedido
      </a>
    </div>

  </div>
</section>

{{-- Valores --}}
<section class="nos-valores">
  <div class="nos-valores-header reveal">
    <span class="nos-eyebrow">Lo que nos mueve</span>
    <h2>Nuestros valores</h2>
  </div>

  <div class="nos-valores-list reveal">
    <div class="nos-valor">
      <div class="nos-valor-icon">🍫</div>
      <div>
        <p class="nos-valor-title">Calidad sin negociación</p>
        <p class="nos-valor-desc">Usamos chocolate de cobertura de calidad premium y frutas frescas seleccionadas. No hay atajos cuando se trata de hacer algo que lleva mi nombre.</p>
      </div>
    </div>
    <div class="nos-valor">
      <div class="nos-valor-icon">✨</div>
      <div>
        <p class="nos-valor-title">Personalización real</p>
        <p class="nos-valor-desc">No somos una fábrica. Cada pedido se diseña y elabora bajo tu visión — colores, iniciales, mensajes, temáticas. Tu idea, nuestra ejecución.</p>
      </div>
    </div>
    <div class="nos-valor">
      <div class="nos-valor-icon">🤝</div>
      <div>
        <p class="nos-valor-title">Atención cercana</p>
        <p class="nos-valor-desc">Hablo directamente con cada cliente por WhatsApp. Entiendo tu evento, tu presupuesto y tus expectativas. No hay bots, no hay formularios — hay personas.</p>
      </div>
    </div>
    <div class="nos-valor">
      <div class="nos-valor-icon">🎁</div>
      <div>
        <p class="nos-valor-title">La experiencia completa</p>
        <p class="nos-valor-desc">El chocolate es solo el comienzo. La presentación, el empaque, el detalle — todo está pensado para que el regalo llegue perfecto y cause el impacto que merece.</p>
      </div>
    </div>
  </div>
</section>

{{-- Stats --}}
<section class="nos-stats">
  <div class="nos-stats-grid reveal">
    <div class="nos-stat">
      <span class="nos-stat-number">6+</span>
      <span class="nos-stat-label">Años de experiencia</span>
    </div>
    <div class="nos-stat">
      <span class="nos-stat-number">+500</span>
      <span class="nos-stat-label">Clientes satisfechos</span>
    </div>
    <div class="nos-stat">
      <span class="nos-stat-number">100%</span>
      <span class="nos-stat-label">Hecho a mano</span>
    </div>
    <div class="nos-stat">
      <span class="nos-stat-number">24h</span>
      <span class="nos-stat-label">Anticipación mínima</span>
    </div>
  </div>
</section>

{{-- CTA --}}
<section class="nos-cta">
  <span class="nos-eyebrow reveal">¿Lista para endulzar tu próximo momento?</span>
  <h2 class="reveal">Trabajemos juntas</h2>
  <p class="reveal">Escríbeme por WhatsApp y cuéntame tu idea. Juntas hacemos que cada celebración sea inolvidable.</p>
  <div class="nos-cta-btns reveal">
    <a href="https://wa.me/573117989152?text=Hola%20Diana%2C%20quiero%20hablarte%20de%20mi%20pedido%20🍫" target="_blank" class="btn-nos-wa">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      Escribir a Diana
    </a>
    <a href="{{ route('shop.catalog') }}" class="btn-nos-outline">Ver catálogo</a>
  </div>
</section>

@endsection

@push('scripts')
<script>
  const reveals = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  reveals.forEach(el => observer.observe(el));
</script>
@endpush

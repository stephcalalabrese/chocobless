# colle ici tout le contenu du fichier
{{-- resources/views/shop/home.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChocoBless – Endulzando tu día</title>
    <meta name="description" content="Fresas bañadas en chocolate, piñatas artesanales y detalles únicos hechos con amor para cada celebración. Bogotá, Colombia.">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ============================================================
           DESIGN TOKENS
        ============================================================ */
        :root {
            --choco:       #3d1c02;
            --choco-light: #5c2e08;
            --gold:        #c9a84c;
            --gold-light:  #e2c97e;
            --cream:       #fdf5ee;
            --cream-dark:  #f5e8d8;
            --text:        #2a1200;
            --muted:       #8a6a50;
            --white:       #ffffff;

            --serif: 'Cormorant Garamond', Georgia, serif;
            --sans:  'Jost', system-ui, sans-serif;

            --radius: 4px;
            --transition: 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ============================================================
           RESET & BASE
        ============================================================ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--sans);
            background: var(--cream);
            color: var(--text);
            overflow-x: hidden;
            font-size: 16px;
            line-height: 1.6;
        }

        img { display: block; max-width: 100%; }
        a { text-decoration: none; color: inherit; }

        /* ============================================================
           UTILITY
        ============================================================ */
        .container {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .section-label {
            font-family: var(--sans);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gold);
            display: block;
            margin-bottom: 12px;
        }

        .section-title {
            font-family: var(--serif);
            font-size: clamp(30px, 4vw, 46px);
            font-weight: 400;
            line-height: 1.15;
            color: var(--choco);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            font-family: var(--sans);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            border-radius: var(--radius);
        }

        .btn-primary {
            background: var(--choco);
            color: var(--cream);
        }
        .btn-primary:hover {
            background: var(--choco-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(61,28,2,.25);
        }

        .btn-outline {
            background: transparent;
            color: var(--choco);
            border: 1.5px solid var(--choco);
        }
        .btn-outline:hover {
            background: var(--choco);
            color: var(--cream);
            transform: translateY(-2px);
        }

        .btn-gold {
            background: var(--gold);
            color: var(--white);
        }
        .btn-gold:hover {
            background: var(--gold-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(201,168,76,.35);
        }

        .btn-whatsapp {
            background: #25D366;
            color: var(--white);
            font-size: 13px;
            padding: 16px 32px;
        }
        .btn-whatsapp:hover {
            background: #1ebe5b;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37,211,102,.3);
        }

        /* ============================================================
           HEADER
        ============================================================ */
        .site-header {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            background: var(--choco);
            border-bottom: 1px solid rgba(201,168,76,.2);
            transition: var(--transition);
        }

        .site-header.scrolled {
            box-shadow: 0 4px 32px rgba(0,0,0,.3);
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 44px;
            width: auto;
        }

        .logo-fallback {
            font-family: var(--serif);
            font-size: 22px;
            font-weight: 600;
            color: var(--gold);
            letter-spacing: 0.02em;
        }

        .main-nav {
            display: flex;
            align-items: center;
            gap: 36px;
        }

        .main-nav a {
            font-family: var(--sans);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(253,245,238,.75);
            transition: color var(--transition);
        }
        .main-nav a:hover { color: var(--gold); }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .cart-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--cream);
            position: relative;
            padding: 4px;
            transition: color var(--transition);
        }
        .cart-btn:hover { color: var(--gold); }
        .cart-badge {
            position: absolute;
            top: -4px; right: -4px;
            background: var(--gold);
            color: var(--choco);
            font-size: 9px;
            font-weight: 700;
            width: 16px; height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--cream);
            padding: 4px;
        }

        @media (max-width: 768px) {
            .main-nav { display: none; }
            .mobile-menu-btn { display: block; }
        }

        /* ── Mobile menu ── */
        .home-mobile-menu {
            display: none;
            flex-direction: column;
            background: #2a1200;
            border-top: 1px solid rgba(201,168,76,.15);
            position: fixed;
            top: 72px; left: 0; right: 0;
            z-index: 99;
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s ease;
        }
        .home-mobile-menu.open {
            display: flex;
            max-height: 500px;
        }
        .home-mobile-menu a {
            font-family: var(--sans);
            font-size: 13px; font-weight: 500; letter-spacing: .08em;
            text-transform: uppercase; color: rgba(253,245,238,.7);
            padding: 14px 24px;
            border-bottom: 1px solid rgba(201,168,76,.07);
            transition: color .2s, background .2s;
            display: flex; align-items: center; gap: 10px;
        }
        .home-mobile-menu a:hover { color: #c9a84c; background: rgba(201,168,76,.06); }
        .home-mobile-menu a:last-child { border-bottom: none; }
        .home-mobile-menu .m-wa { color: #25D366; }
        .home-mobile-menu .m-wa:hover { color: #1ebe5b; }

        /* ============================================================
           HERO
        ============================================================ */
        .hero {
            min-height: 100svh;
            background: var(--choco);
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            padding-top: 72px;
            overflow: hidden;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 60% 80% at 70% 50%, rgba(201,168,76,.08) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Decorative grain texture */
        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            opacity: 0.4;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 80px 0 80px 0;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .hero-eyebrow span {
            font-family: var(--sans);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--gold);
        }

        .hero-eyebrow::before,
        .hero-eyebrow::after {
            content: '';
            width: 32px;
            height: 1px;
            background: var(--gold);
            opacity: 0.5;
        }

        .hero-title {
            font-family: var(--serif);
            font-size: clamp(42px, 5.5vw, 72px);
            font-weight: 300;
            line-height: 1.05;
            color: var(--cream);
            margin-bottom: 24px;
            letter-spacing: -0.01em;
        }

        .hero-title em {
            font-style: italic;
            color: var(--gold-light);
            font-weight: 300;
        }

        .hero-subtitle {
            font-family: var(--sans);
            font-size: 15px;
            font-weight: 300;
            line-height: 1.7;
            color: rgba(253,245,238,.65);
            max-width: 400px;
            margin-bottom: 40px;
        }

        .hero-cta {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .hero-image-wrap {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 0;
        }

        .hero-image-blob {
            position: relative;
            width: 100%;
            max-width: 540px;
        }

        .hero-image-blob::before {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 420px; height: 420px;
            background: radial-gradient(circle, rgba(201,168,76,.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-main-img {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
            filter: drop-shadow(0 40px 80px rgba(0,0,0,.5));
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-16px); }
        }

        /* Floating badges */
        .hero-badge {
            position: absolute;
            background: var(--cream);
            border-radius: 50px;
            padding: 10px 18px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 32px rgba(0,0,0,.2);
            animation: float 6s ease-in-out infinite;
        }
        .hero-badge:nth-child(2) { animation-delay: -2s; }
        .hero-badge:nth-child(3) { animation-delay: -4s; }

        .hero-badge-1 { top: 15%; left: 0; }
        .hero-badge-2 { bottom: 20%; right: 0; }

        .hero-badge span {
            font-family: var(--sans);
            font-size: 12px;
            font-weight: 600;
            color: var(--choco);
            white-space: nowrap;
        }
        .hero-badge .emoji { font-size: 18px; }

        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; padding-top: 72px; }
            .hero-image-wrap { padding: 20px 0 60px; }
            .hero-content { padding: 60px 0 20px; text-align: center; }
            .hero-subtitle { margin: 0 auto 36px; }
            .hero-eyebrow { justify-content: center; }
            .hero-cta { justify-content: center; }
            .hero-badge-1, .hero-badge-2 { display: none; }
        }

        /* ============================================================
           OCCASIONS
        ============================================================ */
        .occasions {
            padding: 100px 0;
            background: var(--cream);
        }

        .occasions-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .occasions-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        @media (max-width: 768px) {
            .occasions-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
        }
        @media (max-width: 480px) {
            .occasions-grid { grid-template-columns: 1fr; }
        }

        .occasion-card {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 4/3;
            cursor: pointer;
            group: true;
        }

        .occasion-bg {
            position: absolute;
            inset: 0;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .occasion-card:hover .occasion-bg {
            transform: scale(1.06);
        }

        /* Individual occasion colors */
        .occ-cumpleanos  .occasion-bg { background: linear-gradient(135deg, #5c2e08 0%, #3d1c02 100%); }
        .occ-san-valentin .occasion-bg { background: linear-gradient(135deg, #8b1a4a 0%, #5c0d2e 100%); }
        .occ-quinceanera .occasion-bg { background: linear-gradient(135deg, #4a2060 0%, #2e1040 100%); }
        .occ-baby-shower .occasion-bg { background: linear-gradient(135deg, #1a5c6e 0%, #0d3e4e 100%); }
        .occ-matrimonios .occasion-bg { background: linear-gradient(135deg, #2a2a2a 0%, #111 100%); }
        .occ-dia-mujer   .occasion-bg { background: linear-gradient(135deg, #6b3a1f 0%, #3d1c02 100%); }

        .occasion-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.07;
            background-image: radial-gradient(circle at 20% 80%, white 1px, transparent 1px),
                              radial-gradient(circle at 80% 20%, white 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .occasion-icon { font-size: 36px !important;
            position: absolute;
            top: 20px; right: 20px;
            font-size: 28px;
            opacity: 0.35;
            transition: opacity var(--transition), transform var(--transition);
        }
        .occasion-card:hover .occasion-icon { font-size: 36px !important;
            opacity: 0.6;
            transform: scale(1.2) rotate(5deg);
        }

        .occasion-content {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding: 24px;
            background: linear-gradient(to top, rgba(0,0,0,.7) 0%, transparent 100%);
        }

        .occasion-title {
            font-family: var(--serif);
            font-size: 22px;
            font-weight: 500;
            color: var(--white);
            margin-bottom: 4px;
        }

        .occasion-desc {
            font-family: var(--sans);
            font-size: 12px;
            color: rgba(255,255,255,.65);
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .occasion-link {
            font-family: var(--sans);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gold-light);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap var(--transition);
        }
        .occasion-card:hover .occasion-link { gap: 10px; }

        /* ============================================================
           FEATURED PRODUCTS
        ============================================================ */
        .products {
            padding: 100px 0;
            background: var(--choco);
            position: relative;
            overflow: hidden;
        }

        .products::before {
            content: '';
            position: absolute;
            top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(201,168,76,.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .products-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .products-header .section-title {
            color: var(--cream);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        @media (max-width: 900px) {
            .products-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 560px) {
            .products-grid { grid-template-columns: 1fr; max-width: 360px; margin: 0 auto; }
        }

        .product-card {
            background: rgba(253,245,238,.04);
            border: 1px solid rgba(201,168,76,.15);
            border-radius: 10px;
            overflow: hidden;
            transition: var(--transition);
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-6px);
            border-color: rgba(201,168,76,.4);
            box-shadow: 0 24px 60px rgba(0,0,0,.4);
        }

        .product-badge {
            position: absolute;
            top: 14px; left: 14px;
            z-index: 2;
            background: var(--gold);
            color: var(--choco);
            font-family: var(--sans);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 2px;
        }

        .product-img-wrap {
            aspect-ratio: 1;
            background: var(--cream-dark);
            overflow: hidden;
            position: relative;
        }

        .product-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover .product-img-wrap img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 22px;
        }

        .product-name {
            font-family: var(--serif);
            font-size: 20px;
            font-weight: 500;
            color: var(--cream);
            margin-bottom: 6px;
            line-height: 1.2;
        }

        .product-desc {
            font-family: var(--sans);
            font-size: 13px;
            color: rgba(253,245,238,.5);
            line-height: 1.55;
            margin-bottom: 16px;
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .product-price {
            font-family: var(--serif);
            font-size: 13px;
            color: rgba(253,245,238,.5);
            font-style: italic;
        }

        .product-price strong {
            display: block;
            font-size: 20px;
            font-weight: 400;
            color: var(--gold);
            font-style: normal;
        }

        .add-to-cart {
            flex-shrink: 0;
            background: var(--gold);
            color: var(--choco);
            border: none;
            padding: 10px 18px;
            font-family: var(--sans);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border-radius: var(--radius);
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .add-to-cart:hover {
            background: var(--gold-light);
            transform: scale(1.04);
        }

        .products-cta {
            text-align: center;
            margin-top: 52px;
        }

        /* ============================================================
           CREDIBILITY
        ============================================================ */
        .credibility {
            padding: 80px 0;
            background: var(--cream-dark);
            border-top: 1px solid rgba(61,28,2,.1);
            border-bottom: 1px solid rgba(61,28,2,.1);
        }

        .credibility-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .credibility-grid { grid-template-columns: repeat(2, 1fr); gap: 36px; }
        }

        .cred-item {
            position: relative;
        }

        .cred-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: -20px;
            top: 50%;
            transform: translateY(-50%);
            height: 48px;
            width: 1px;
            background: rgba(201,168,76,.25);
        }

        @media (max-width: 768px) {
            .cred-item:not(:last-child)::after { display: none; }
        }

        .cred-number {
            font-family: var(--serif);
            font-size: 54px;
            font-weight: 300;
            line-height: 1;
            color: var(--choco);
            margin-bottom: 4px;
        }

        .cred-number span {
            color: var(--gold);
        }

        .cred-label {
            font-family: var(--sans);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
        }

        /* ============================================================
           TESTIMONIALS
        ============================================================ */
        .testimonials {
            padding: 100px 0;
            background: var(--cream);
        }

        .testimonials-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        @media (max-width: 900px) {
            .testimonials-grid { grid-template-columns: 1fr; max-width: 520px; margin: 0 auto; }
        }

        .testimonial-card {
            background: var(--white);
            border: 1px solid rgba(61,28,2,.08);
            border-radius: 10px;
            padding: 32px;
            position: relative;
            transition: var(--transition);
        }
        .testimonial-card:hover {
            box-shadow: 0 16px 48px rgba(61,28,2,.1);
            transform: translateY(-4px);
        }

        .testimonial-quote-mark {
            font-family: var(--serif);
            font-size: 72px;
            line-height: 0.5;
            color: var(--gold);
            opacity: 0.3;
            margin-bottom: 16px;
            display: block;
        }

        .testimonial-text {
            font-family: var(--serif);
            font-size: 17px;
            font-style: italic;
            color: var(--choco);
            line-height: 1.65;
            margin-bottom: 24px;
        }

        .testimonial-stars {
            color: var(--gold);
            font-size: 14px;
            letter-spacing: 2px;
            margin-bottom: 14px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .author-avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: var(--cream-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--serif);
            font-size: 16px;
            font-weight: 600;
            color: var(--choco);
            flex-shrink: 0;
            border: 2px solid var(--gold);
        }

        .author-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .author-name {
            font-family: var(--sans);
            font-size: 13px;
            font-weight: 600;
            color: var(--choco);
        }

        .author-location {
            font-family: var(--sans);
            font-size: 11px;
            color: var(--muted);
        }

        /* ============================================================
           ORDER CTA
        ============================================================ */
        .order-cta {
            padding: 100px 0;
            background: var(--choco);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .order-cta::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 50% 80% at 30% 50%, rgba(201,168,76,.07) 0%, transparent 60%),
                radial-gradient(ellipse 40% 60% at 70% 50%, rgba(201,168,76,.05) 0%, transparent 60%);
            pointer-events: none;
        }

        .order-cta-inner {
            position: relative;
            z-index: 1;
        }

        .order-cta .section-label { justify-content: center; display: flex; }

        .order-cta .section-title {
            color: var(--cream);
            margin-bottom: 16px;
        }

        .order-cta-subtitle {
            font-family: var(--sans);
            font-size: 15px;
            color: rgba(253,245,238,.6);
            margin-bottom: 40px;
            line-height: 1.65;
            max-width: 460px;
            margin-left: auto;
            margin-right: auto;
        }

        .order-cta-btns {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* ============================================================
           FOOTER
        ============================================================ */
        .site-footer {
            background: #1e0d01;
            padding: 60px 0 32px;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 48px;
            padding-bottom: 48px;
            border-bottom: 1px solid rgba(201,168,76,.12);
            margin-bottom: 32px;
        }

        @media (max-width: 768px) {
            .footer-top { grid-template-columns: 1fr; gap: 36px; }
        }

        .footer-brand .logo-fallback {
            font-size: 26px;
            margin-bottom: 14px;
            display: block;
        }

        .footer-tagline {
            font-family: var(--sans);
            font-size: 13px;
            color: rgba(253,245,238,.45);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .social-link {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgba(201,168,76,.12);
            border: 1px solid rgba(201,168,76,.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 14px;
            transition: var(--transition);
        }
        .social-link:hover {
            background: var(--gold);
            color: var(--choco);
            transform: scale(1.1);
        }

        .footer-col-title {
            font-family: var(--sans);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-links a {
            font-family: var(--sans);
            font-size: 13px;
            color: rgba(253,245,238,.5);
            transition: color var(--transition);
        }
        .footer-links a:hover { color: var(--gold); }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-family: var(--sans);
            font-size: 13px;
            color: rgba(253,245,238,.5);
            margin-bottom: 10px;
        }
        .footer-contact-item span:first-child { color: var(--gold); flex-shrink: 0; }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-copy {
            font-family: var(--sans);
            font-size: 12px;
            color: rgba(253,245,238,.28);
        }

        .footer-divider {
            font-size: 12px;
            color: rgba(253,245,238,.18);
        }

        /* ============================================================
           ANIMATIONS ON SCROLL
        ============================================================ */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
    </style>
</head>
<body>

{{-- ================================================================
     HEADER
================================================================ --}}
<header class="site-header" id="site-header">
    <div class="container">
        <div class="header-inner">

            {{-- Logo --}}
            <a href="{{ route('shop.home') }}" class="logo">
                <img src="/images/logo-chocobless.png"
                     alt="ChocoBless"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <span class="logo-fallback" style="display:none">ChocoBless</span>
            </a>

            {{-- Navigation --}}
            <nav class="main-nav">
                <a href="#ocasiones">Ocasiones</a>
                <a href="{{ route('shop.catalog') }}">Catálogo</a>
                <a href="{{ route('shop.nosotras') }}">Nosotras</a>
                <a href="{{ route('shop.contact') }}">Contacto</a>
            </nav>

            {{-- Actions --}}
            <div class="header-actions">
                {{-- Cart --}}
<!--
                    <button class="cart-btn" aria-label="Carrito de compras">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
                    </svg>
                    @if(session('cart_count', 0) > 0)
                        <span class="cart-badge">{{ session('cart_count', 0) }}</span>
                    @endif
                </button>

                {{-- CTA --}}
                <a href="https://wa.me/573117989152?text=Hola%2C%20quiero%20hacer%20un%20pedido%20🍫"
                   target="_blank"
                   class="btn btn-gold"
                   style="font-size:11px; padding:10px 10px;">
                    Pedir ahora
                </a>
-->
                {{-- Mobile hamburger --}}
                <button class="mobile-menu-btn" id="home-mobile-btn" aria-label="Menú" aria-expanded="false">
                    <svg id="home-icon-menu" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                    <svg id="home-icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

{{-- Mobile menu (homepage) --}}
<div id="home-mobile-menu" class="home-mobile-menu">
    <a href="{{ route('shop.home') }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Inicio
    </a>
    <a href="{{ route('shop.catalog') }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        Catálogo
    </a>
    <a href="{{ route('cart.show') }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 7H4l1-7z"/></svg>
        Carrito
    </a>
    <a href="{{ route('shop.nosotras') }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        Nosotras
    </a>
	    <a href="{{ route('shop.contact') }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18v12H3V6zm0 0l9 6l9-6" /></svg>
        Contacto
    </a>
</div>
<section class="hero">
    <div class="container" style="display:contents;">

        {{-- Left: Copy --}}
        <div style="padding: 0 24px 0 max(24px, calc((100vw - 1180px)/2 + 24px));">
            <div class="hero-content">
                <div class="hero-eyebrow">
                    <span>Diana Suárez · Artesanal · Bogotá</span>
                </div>

                <h1 class="hero-title">
                    Endulzando<br>
                    tus momentos<br>
                    <em>más especiales</em>
                </h1>

                <p class="hero-subtitle">
                    Fresas bañadas en chocolate, piñatas artesanales y detalles
                    únicos hechos con amor para cada celebración.
                </p>

                <div class="hero-cta">
                    <a href="{{ route('shop.catalog') }}" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Explorar catálogo
                    </a>
                    <a href="#ocasiones" class="btn btn-outline" style="color:var(--cream); border-color:rgba(253,245,238,.35);">
                        Ver ocasiones
                    </a>
                </div>
            </div>
        </div>

        {{-- Right: Hero Image --}}
        <div class="hero-image-wrap" style="padding-right: max(24px, calc((100vw - 1180px)/2 + 24px));">
            <div class="hero-image-blob">

                {{-- Floating badge top-left --}}
                <div class="hero-badge hero-badge-1">
                    <span class="emoji">🍓</span>
                    <span>100% Artesanal</span>
                </div>

                {{-- Main product image --}}
                <img class="hero-main-img"
                     src="/images/products/hero-product.png"
                     alt="Fresa bañada en chocolate ChocoBless"
                     onerror="this.src='/images/placeholder-hero.png'">

                {{-- Floating badge bottom-right --}}
                <div class="hero-badge hero-badge-2">
                    <span class="emoji">✨</span>
                    <span>Clientes felices</span>
                </div>

            </div>
        </div>
    </div>
</section>


{{-- ================================================================
     OCCASIONS
================================================================ --}}
<section class="occasions" id="ocasiones">
    <div class="container">

        <div class="occasions-header reveal">
            <span class="section-label">Para cada momento</span>
            <h2 class="section-title">La ocasión perfecta para regalar</h2>
        </div>

        <div class="occasions-grid">

            @foreach($ocasiones as $i => $oc)
            <a href="{{ route('shop.ocasion', $oc->slug) }}"
               class="occasion-card reveal reveal-delay-{{ ($i % 3) + 1 }}"
               style="--oc-color: {{ $oc->color ?? '#3d1c02' }}">
                <div class="occasion-bg" style="background: linear-gradient(135deg, {{ $oc->color ?? '#3d1c02' }} 0%, color-mix(in srgb, {{ $oc->color ?? '#3d1c02' }} 70%, #000) 100%)"></div>
                <div class="occasion-pattern"></div>
                <span class="occasion-icon">{{ $oc->icono }}</span>
                <div class="occasion-content">
                    <h3 class="occasion-title">{{ $oc->nom }}</h3>
                    <p class="occasion-desc">{{ $oc->descripcion }}</p>
                    <span class="occasion-link">
                        Ver ideas
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </span>
                </div>
            </a>
            @endforeach

        </div>
    </div>
</section>


{{-- ================================================================
     FEATURED PRODUCTS
================================================================ --}}
<section class="products" id="catalogo">
    <div class="container">

        <div class="products-header reveal">
            <span class="section-label">Colección Signature</span>
            <h2 class="section-title">Nuestras delicias más queridas</h2>
        </div>

        <div class="products-grid">

            @php
            $defaultProducts = [
                [
                    'id' => 1,
                    'name' => 'Fresa bañada en oro',
                    'description' => 'Chocolate oscuro con inicial personalizada en polvo brillante, perfecta para regalar.',
                    'price' => '$11.000',
                    'image' => '/images/products/fresa-oro.jpg',
                    'badge' => 'Bestseller',
                    'slug' => 'fresa-banada-en-oro',
                ],
                [
                    'id' => 2,
                    'name' => 'Piñata corazón',
                    'description' => 'Piñata artesanal en chocolate blanco con detalles de marcación, rosa y motivos de amor.',
                    'price' => '$45.000',
                    'image' => '/images/products/pinata-corazon.jpg',
                    'badge' => 'Top ventas',
                    'slug' => 'pinata-corazon',
                ],
                [
                    'id' => 3,
                    'name' => 'Oso piñata',
                    'description' => 'Dulce artesanal de chocolate con perlas doradas, lazo y elaborado en tonos lavanda.',
                    'price' => '$65.000',
                    'image' => '/images/products/oso-pinata.jpg',
                    'badge' => 'Nuevo',
                    'slug' => 'oso-pinata',
                ],
            ];
            $featuredProducts = $featuredProducts ?? $defaultProducts;
            @endphp

            @foreach($en_vedette as $i => $product)
            <div class="product-card reveal reveal-delay-{{ $i + 1 }}">
                @if(!empty(($product->en_vedette ? "Destacado" : "")))
                    <span class="product-badge">{{ ($product->en_vedette ? "Destacado" : "") }}</span>
                @endif

                <a href="{{ route('shop.product', $product['slug'] ?? 'producto') }}" class="product-img-wrap">
                    <img src="{{ $product->image_principale ? (Str::startsWith($product->image_principale, ["http","/"]) ? $product->image_principale : (Str::startsWith($product->image_principale, "images/") ? "/".$product->image_principale : "/storage/".$product->image_principale)) : "/images/placeholder-product.jpg" }}"
                         alt="{{ $product->nom }}"
                         loading="lazy"
                         onerror="this.src='/images/placeholder-product.jpg'">
                </a>

                <div class="product-info">
                    <h3 class="product-name">
                        <a href="{{ route('shop.product', $product['slug'] ?? 'producto') }}"
                           style="color:inherit;">
                            {{ $product->nom }}
                        </a>
                    </h3>
                    <p class="product-desc">{{ $product->description_courte }}</p>

                    <div class="product-footer">
                        <div class="product-price">
                            <span>Desde</span>
                            <strong>{{ ($product->variants->first() ? "$" . number_format($product->variants->first()->prix, 0, ",", ".") : "Consultar") }}</strong>
                        </div>
                        <button class="add-to-cart"
                                onclick="addToCart({{ $product->id }}, '{{ $product->nom }}')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Añadir
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <div class="products-cta reveal">
            <a href="{{ route('shop.catalog') }}" class="btn btn-outline" style="color:var(--cream); border-color:rgba(253,245,238,.3);">
                Ver todos los productos
            </a>
        </div>

    </div>
</section>


{{-- ================================================================
     CREDIBILITY
================================================================ --}}
<section class="credibility">
    <div class="container">
        <div class="credibility-grid">

            <div class="cred-item reveal">
                <div class="cred-number"><span>100</span>%</div>
                <div class="cred-label">Artesanal</div>
            </div>

            <div class="cred-item reveal reveal-delay-1">
                <div class="cred-number"><span>Docenas</span></div>
                <div class="cred-label">de clientes felices</div>
            </div>

            <div class="cred-item reveal reveal-delay-2">
                <div class="cred-number"><span>48</span>h</div>
                <div class="cred-label">Pedidos previos</div>
            </div>

            <div class="cred-item reveal reveal-delay-3">
                <div class="cred-number"><span>2</span>+</div>
                <div class="cred-label">Años creando</div>
            </div>

        </div>
    </div>
</section>


{{-- ================================================================
     TESTIMONIALS
================================================================ --}}
<section class="testimonials">
    <div class="container">

        <div class="testimonials-header reveal">
            <span class="section-label">Lo que dicen nuestros clientes</span>
            <h2 class="section-title">Palabras que nos llenan el corazón</h2>
        </div>

        <div class="testimonials-grid">

            @php
            $defaultTestimonials = [
                [
                    'text' => 'Las fresas bañadas de mi cumpleaños fueron el centro de atención. ¡Toda la presentación es increíble y el sabor, delicioso!',
                    'name' => 'Valentina M.',
                    'location' => 'Bogotá',
                    'initial' => 'V',
                ],
                [
                    'text' => 'El oso piñata para el baby shower fue un éxito total. Tan increíblemente hermosa y deliciosa. Diana la personaliza en cada detalle — ¡100% recomendada!',
                    'name' => 'Camila B.',
                    'location' => 'Bogotá',
                    'initial' => 'C',
                ],
                [
                    'text' => 'Pedí las delicias para San Valentín y fue la mejor decisión. Dina las personaliza con nuestra historia. Mágico para mí, y el empaque quedó sin palabras.',
                    'name' => 'Sofía T.',
                    'location' => 'Bogotá',
                    'initial' => 'S',
                ],
            ];
            $testimonials = $testimonials ?? $defaultTestimonials;
            @endphp

            @foreach($testimonials as $i => $t)
            <div class="testimonial-card reveal reveal-delay-{{ $i + 1 }}">
                <span class="testimonial-quote-mark">"</span>
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-text">{{ $t['text'] }}</p>
                <div class="testimonial-author">
                    <div class="author-avatar">{{ $t['initial'] }}</div>
                    <div class="author-info">
                        <span class="author-name">{{ $t['name'] }}</span>
                        <span class="author-location">{{ $t['location'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>


{{-- ================================================================
     ORDER CTA
================================================================ --}}
<section class="order-cta" id="contacto">
    <div class="container">
        <div class="order-cta-inner reveal">
            <span class="section-label">¡Lista para tu encargo!</span>
            <h2 class="section-title">Haz tu pedido hoy</h2>
            <p class="order-cta-subtitle">
                Escríbenos por WhatsApp para realizar tu pedido personalizado.
                Atendido con 48 horas de anticipación.
            </p>
            <div class="order-cta-btns">
                <a href="https://wa.me/573117989152?text=Hola%20ChocoBless%2C%20quiero%20hacer%20un%20pedido%20🍫"
                   target="_blank"
                   class="btn btn-whatsapp">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    WhatsApp: 311 798 9152
                </a>
                <a href="{{ route('shop.catalog') }}" class="btn btn-outline" style="color:var(--cream); border-color:rgba(253,245,238,.3);">
                    Ver catálogo
                </a>
            </div>
        </div>
    </div>
</section>


{{-- ================================================================
     FOOTER
================================================================ --}}
<footer class="site-footer">
    <div class="container">

        <div class="footer-top">

            {{-- Brand --}}
            <div class="footer-brand">
                <span class="logo-fallback">ChocoBless</span>
                <p class="footer-tagline">
                    Delicias artesanales a base de chocolate, hechas con amor
                    en Bogotá para hacer tus momentos únicos e inolvidables.
                </p>
                <div class="footer-social">
                    <a href="https://instagram.com/chocobless" target="_blank" class="social-link" aria-label="Instagram">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="https://wa.me/573117989152" target="_blank" class="social-link" aria-label="WhatsApp">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                    <a href="https://tiktok.com/@chocobless" target="_blank" class="social-link" aria-label="TikTok">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.34 6.34 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.23 8.23 0 004.82 1.56V6.8a4.85 4.85 0 01-1.05-.11z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="footer-col-title">Navegación</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('shop.home') }}">Inicio</a></li>
                    <li><a href="{{ route('shop.catalog') }}">Catálogo</a></li>
                    <li><a href="#ocasiones">Ocasiones</a></li>
                    <li><a href="{{ route('shop.nosotras') }}">Nosotras</a></li>
                    <li><a href="{{ route('shop.contact') }}">Contacto</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="footer-col-title">Contacto</h4>
                <div class="footer-contact-item">
                    <span>📱</span>
                    <span>311 798 9152</span>
                </div>
                <div class="footer-contact-item">
                    <span>📍</span>
                    <span>Bogotá, Colombia</span>
                </div>
                <div class="footer-contact-item">
                    <span>⏰</span>
                    <span>Pedidos con 24h de anticipación</span>
                </div>
                <div style="margin-top:20px;">
                    <a href="https://wa.me/573117989152" target="_blank"
                       style="font-family:var(--sans); font-size:12px; color:var(--gold); font-weight:600; letter-spacing:0.08em; text-transform:uppercase; display:inline-flex; align-items:center; gap:6px; transition:opacity 0.2s;" onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">
                        Escribir por WhatsApp →
                    </a>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            <p class="footer-copy">© {{ date('Y') }} ChocoBless · Diana Suárez · Todos los derechos reservados</p>
            <p class="footer-copy" style="display:flex; gap:12px;">
                <a href="#" style="color:inherit;">Política de privacidad</a>
                <span class="footer-divider">·</span>
                <a href="#" style="color:inherit;">Términos</a>
            </p>
        </div>

    </div>
</footer>


{{-- ================================================================
     SCRIPTS
================================================================ --}}
<script>
    // Header scroll effect
    const header = document.getElementById('site-header');
    window.addEventListener('scroll', () => {
        header.classList.toggle('scrolled', window.scrollY > 40);
    }, { passive: true });

    // Mobile menu toggle (homepage)
    const homeMobileBtn   = document.getElementById('home-mobile-btn');
    const homeMobileMenu  = document.getElementById('home-mobile-menu');
    const homeIconMenu    = document.getElementById('home-icon-menu');
    const homeIconClose   = document.getElementById('home-icon-close');

    if (homeMobileBtn && homeMobileMenu) {
        homeMobileBtn.addEventListener('click', () => {
            const isOpen = homeMobileMenu.classList.toggle('open');
            homeMobileBtn.setAttribute('aria-expanded', isOpen);
            homeIconMenu.style.display  = isOpen ? 'none'  : 'block';
            homeIconClose.style.display = isOpen ? 'block' : 'none';
        });
        homeMobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                homeMobileMenu.classList.remove('open');
                homeIconMenu.style.display  = 'block';
                homeIconClose.style.display = 'none';
                homeMobileBtn.setAttribute('aria-expanded', 'false');
            });
        });
        document.addEventListener('click', (e) => {
            if (!header.contains(e.target) && !homeMobileMenu.contains(e.target)) {
                homeMobileMenu.classList.remove('open');
                homeIconMenu.style.display  = 'block';
                homeIconClose.style.display = 'none';
                homeMobileBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // Scroll reveal
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    reveals.forEach(el => observer.observe(el));

    // Add to cart (replace with your actual cart logic)
    function addToCart(productId, productName) {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        })
        .then(r => r.json())
        .then(data => {
            // Update badge
            const badge = document.querySelector('.cart-badge');
            if (data.cart_count > 0) {
                if (badge) {
                    badge.textContent = data.cart_count;
                } else {
                    const btn = document.querySelector('.cart-btn');
                    const newBadge = document.createElement('span');
                    newBadge.className = 'cart-badge';
                    newBadge.textContent = data.cart_count;
                    btn.appendChild(newBadge);
                }
            }
        })
        .catch(() => {
            // Fallback: redirect to product page
            window.location.href = '/productos/' + productId;
        });
    }

    // Smooth anchor scroll
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>

</body>
</html>

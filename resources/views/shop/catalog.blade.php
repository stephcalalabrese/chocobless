@extends('shop.layout')
@section('title', isset($category) ? $category->nom.' — ChocoBless' : 'Catálogo — ChocoBless')

@push('styles')
<style>
    .catalog-hero { background:#3d1c02; padding:56px 0 48px; position:relative; overflow:hidden; }
    .catalog-hero::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 60% 100% at 80% 50%, rgba(201,168,76,.07) 0%, transparent 70%); pointer-events:none; }
    .catalog-hero-label { font-size:11px; font-weight:600; letter-spacing:.2em; text-transform:uppercase; color:#c9a84c; display:block; margin-bottom:10px; }
    .catalog-hero-title { font-family:'Cormorant Garamond',Georgia,serif; font-size:clamp(32px,4vw,52px); font-weight:400; line-height:1.1; color:#fdf5ee; margin-bottom:10px; }
    .catalog-hero-desc { font-size:14px; font-weight:300; color:rgba(253,245,238,.55); max-width:460px; line-height:1.65; }
    .catalog-wrap { max-width:1180px; margin:0 auto; padding:48px 24px 80px; display:grid; grid-template-columns:220px 1fr; gap:40px; align-items:start; }
    @media(max-width:768px){ .catalog-wrap{ grid-template-columns:1fr; gap:24px; } }
    .catalog-sidebar { position:sticky; top:90px; }
    .sidebar-label { font-size:10px; font-weight:700; letter-spacing:.2em; text-transform:uppercase; color:#c9a84c; margin-bottom:14px; display:block; }
    .sidebar-list { list-style:none; display:flex; flex-direction:column; gap:2px; }
    .sidebar-list a { display:flex; align-items:center; justify-content:space-between; padding:9px 14px; border-radius:6px; font-size:13px; color:rgba(61,28,2,.7); transition:all .25s; border:1px solid transparent; }
    .sidebar-list a:hover { background:rgba(201,168,76,.1); color:#3d1c02; border-color:rgba(201,168,76,.2); }
    .sidebar-list a.active { background:#3d1c02; color:#e2c97e; font-weight:500; }
    .sidebar-count { font-size:11px; background:rgba(201,168,76,.15); color:#9c7c2a; padding:1px 7px; border-radius:20px; font-weight:500; }
    .sidebar-list a.active .sidebar-count { background:rgba(201,168,76,.25); color:#e2c97e; }
    .catalog-toolbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; gap:12px; flex-wrap:wrap; }
    .catalog-count { font-size:13px; color:rgba(61,28,2,.5); }
    .catalog-count strong { color:#3d1c02; font-weight:600; }
    .products-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
    @media(max-width:1024px){ .products-grid{ grid-template-columns:repeat(2,1fr); } }
    @media(max-width:560px){ .products-grid{ grid-template-columns:1fr; } }
    .pcard { background:#fff; border-radius:10px; overflow:hidden; border:1px solid rgba(61,28,2,.08); transition:transform .3s,box-shadow .3s,border-color .3s; display:flex; flex-direction:column; }
    .pcard:hover { transform:translateY(-5px); box-shadow:0 20px 50px rgba(61,28,2,.12); border-color:rgba(201,168,76,.35); }
    .pcard-img { aspect-ratio:1; overflow:hidden; background:#f5e8d8; position:relative; flex-shrink:0; }
    .pcard-img img { width:100%; height:100%; object-fit:cover; transition:transform .5s; }
    .pcard:hover .pcard-img img { transform:scale(1.06); }
    .pcard-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:52px; background:linear-gradient(135deg,#f5e8d8,#fdf5ee); }
    .pcard-badge { position:absolute; top:12px; left:12px; background:#c9a84c; color:#1e0d00; font-size:10px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; padding:3px 10px; border-radius:20px; }
    .pcard-body { padding:18px; display:flex; flex-direction:column; flex:1; }
    .pcard-name { font-family:'Cormorant Garamond',Georgia,serif; font-size:18px; font-weight:500; color:#3d1c02; line-height:1.2; margin-bottom:6px; }
    .pcard-desc { font-size:12px; color:rgba(61,28,2,.5); line-height:1.55; margin-bottom:14px; flex:1; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .pcard-footer { display:flex; align-items:center; justify-content:space-between; gap:8px; margin-top:auto; }
    .pcard-price-from { font-size:11px; color:rgba(61,28,2,.4); display:block; font-style:italic; font-family:'Cormorant Garamond',serif; line-height:1; margin-bottom:2px; }
    .pcard-price-value { font-size:20px; font-weight:600; color:#3d1c02; font-family:'Cormorant Garamond',serif; line-height:1; }
    .pcard-btn { flex-shrink:0; background:#3d1c02; color:#e2c97e; font-size:11px; font-weight:600; letter-spacing:.1em; text-transform:uppercase; padding:9px 16px; border-radius:4px; transition:background .25s,transform .25s; display:inline-flex; align-items:center; gap:6px; }
    .pcard-btn:hover { background:#1e0d00; transform:scale(1.04); }
    .empty-state { grid-column:1/-1; text-align:center; padding:80px 20px; color:rgba(61,28,2,.35); }
    .empty-state .emoji { font-size:48px; display:block; margin-bottom:16px; }
    .empty-state p { font-family:'Cormorant Garamond',serif; font-size:22px; }
    .pagination-wrap { margin-top:40px; display:flex; justify-content:center; }
</style>
@endpush

@section('content')

<div class="catalog-hero">
    <div style="max-width:1180px; margin:0 auto; padding:0 24px; position:relative; z-index:1;">
        <span class="catalog-hero-label">ChocoBless</span>
        <h1 class="catalog-hero-title">
            {{ isset($category) ? $category->nom : 'Todo el catálogo' }}
        </h1>
        @if(isset($category) && $category->description)
            <p class="catalog-hero-desc">{{ $category->description }}</p>
        @else
            <p class="catalog-hero-desc">Delicias artesanales a base de chocolate, hechas con amor para cada ocasión especial.</p>
        @endif
    </div>
</div>

<div class="catalog-wrap">

    <aside class="catalog-sidebar">
        <span class="sidebar-label">Categorías</span>
        <ul class="sidebar-list">
            <li>
                <a href="{{ route('shop.catalog') }}" class="{{ !isset($category) ? 'active' : '' }}">
                    <span>Todos los productos</span>
                    <span class="sidebar-count">{{ \App\Models\Product::where('actif',1)->count() }}</span>
                </a>
            </li>
            @foreach($categories as $cat)
            <li>
                <a href="{{ route('shop.category', $cat->slug) }}" class="{{ isset($category) && $category->id === $cat->id ? 'active' : '' }}">
                    <span>{{ $cat->nom }}</span>
                    <span class="sidebar-count">{{ $cat->products_count ?? '' }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </aside>

    <div>
        <div class="catalog-toolbar">
            <p class="catalog-count">
                <strong>{{ $products->total() }}</strong> productos encontrados
            </p>
        </div>

        <div class="products-grid">
            @forelse($products as $product)
                @include('shop.partials.product-card', ['product' => $product])
            @empty
                <div class="empty-state">
                    <span class="emoji">🍫</span>
                    <p>No hay productos disponibles</p>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="pagination-wrap">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>

@endsection

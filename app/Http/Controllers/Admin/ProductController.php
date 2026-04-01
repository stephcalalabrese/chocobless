<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ocasion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request){
        $query=Product::with(['category','variants','ocasiones'])->orderByDesc('cree_le');
        if($request->filled('q')) $query->where('nom','like','%'.$request->q.'%');
        if($request->filled('categorie')) $query->where('categorie_id',$request->categorie);
        if($request->filled('statut')) $query->where('actif',$request->statut==='actif'?1:0);
        if($request->filled('ocasion')) $query->whereHas('ocasiones',fn($q)=>$q->where('ocasiones.id',$request->ocasion));
        $products=$query->paginate(15)->withQueryString();
        $categories=Category::where('actif',1)->orderBy('nom')->get();
        $ocasiones=Ocasion::actif()->get();
        return view('admin.products.index',compact('products','categories','ocasiones'));
    }

    public function create(){
        $categories=Category::where('actif',1)->orderBy('nom')->get();
        $ocasiones=Ocasion::actif()->get();
        return view('admin.products.form',compact('categories','ocasiones'));
    }

    public function store(Request $request){
        $data=$request->validate([
            'nom'               => 'required|string|max:200',
            'categorie_id'      => 'required|exists:categories,id',
            'description_courte'=> 'nullable|string',
            'description'       => 'nullable|string',
            'actif'             => 'boolean',
            'en_vedette'        => 'boolean',
            'image_principale'  => 'nullable|image|max:2048',
            'ocasion_ids'       => 'nullable|array',
            'ocasion_ids.*'     => 'exists:ocasiones,id',
        ]);
        $data['slug']       = Str::slug($data['nom']);
        $data['actif']      = $request->boolean('actif', true);
        $data['en_vedette'] = $request->boolean('en_vedette');

        if($request->hasFile('image_principale'))
            $data['image_principale'] = $request->file('image_principale')->store('products','public');

        $product = Product::create($data);

        // Sync ocasiones
        $product->ocasiones()->sync($request->input('ocasion_ids', []));

        // Variantes
        foreach($request->input('variantes',[]) as $v){
            $product->variants()->create([
                'label'     => $v['label'],
                'prix'      => $v['prix'],
                'prix_promo'=> $v['prix_promo'] ?: null,
                'stock'     => $v['stock'],
                'sku'       => $v['sku'] ?: null,
                'actif'     => 1,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success','Produit créé.');
    }

    public function edit(Product $product){
        $product->load(['variants','images','ocasiones']);
        $categories = Category::where('actif',1)->orderBy('nom')->get();
        $ocasiones  = Ocasion::actif()->get();
        return view('admin.products.form',compact('product','categories','ocasiones'));
    }

    public function update(Request $request, Product $product){
        $data=$request->validate([
            'nom'               => 'required|string|max:200',
            'categorie_id'      => 'required|exists:categories,id',
            'description_courte'=> 'nullable|string',
            'description'       => 'nullable|string',
            'actif'             => 'boolean',
            'en_vedette'        => 'boolean',
            'image_principale'  => 'nullable|image|max:2048',
            'ocasion_ids'       => 'nullable|array',
            'ocasion_ids.*'     => 'exists:ocasiones,id',
        ]);
        $data['actif']      = $request->boolean('actif');
        $data['en_vedette'] = $request->boolean('en_vedette');

        if($request->hasFile('image_principale'))
            $data['image_principale'] = $request->file('image_principale')->store('products','public');

        $product->update($data);

        // Sync ocasiones
        $product->ocasiones()->sync($request->input('ocasion_ids', []));

        // Variantes
        $ids = [];
        foreach($request->input('variantes',[]) as $v){
            if(!empty($v['id'])){
                $var = $product->variants()->find($v['id']);
                if($var){
                    $var->update([
                        'label'     => $v['label'],
                        'prix'      => $v['prix'],
                        'prix_promo'=> $v['prix_promo'] ?: null,
                        'stock'     => $v['stock'],
                        'sku'       => $v['sku'] ?: null,
                    ]);
                    $ids[] = $var->id;
                }
            } else {
                $new = $product->variants()->create([
                    'label'     => $v['label'],
                    'prix'      => $v['prix'],
                    'prix_promo'=> $v['prix_promo'] ?: null,
                    'stock'     => $v['stock'],
                    'sku'       => $v['sku'] ?: null,
                    'actif'     => 1,
                ]);
                $ids[] = $new->id;
            }
        }
        $product->variants()->whereNotIn('id',$ids)->delete();

        return redirect()->route('admin.products.index')->with('success','Produit mis à jour.');
    }

    public function destroy(Product $product){
        $product->delete();
        return back()->with('success','Produit supprimé.');
    }

    public function toggle(Product $product){
        $product->update(['actif'=>!$product->actif]);
        return back()->with('success','Statut mis à jour.');
    }

    public function toggleFeatured(Product $product){
        $product->update(['en_vedette'=>!$product->en_vedette]);
        return back()->with('success','Vedette mis à jour.');
    }
}

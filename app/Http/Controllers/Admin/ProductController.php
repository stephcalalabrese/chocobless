<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ocasion;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            'nom'                  => 'required|string|max:200',
            'categorie_id'         => 'required|exists:categories,id',
            'description_courte'   => 'nullable|string',
            'description'          => 'nullable|string',
            'actif'                => 'boolean',
            'en_vedette'           => 'boolean',
            'image_principale'     => 'nullable|image|max:4096',
            'ocasion_ids'          => 'nullable|array',
            'ocasion_ids.*'        => 'exists:ocasiones,id',
            'images_secondaires'   => 'nullable|array',
            'images_secondaires.*' => 'image|max:4096',
        ]);
        $data['slug']       = Str::slug($data['nom']);
        $data['actif']      = $request->boolean('actif', true);
        $data['en_vedette'] = $request->boolean('en_vedette');

        if($request->hasFile('image_principale'))
            $data['image_principale'] = $request->file('image_principale')->store('products','public');

        $product = Product::create($data);
        $product->ocasiones()->sync($request->input('ocasion_ids', []));

        if($request->hasFile('images_secondaires')){
            foreach($request->file('images_secondaires') as $i => $file){
                ProductImage::create([
                    'produit_id' => $product->id,
                    'url_image'  => $file->store('products','public'),
                    'alt_text'   => $product->nom,
                    'ordre'      => $i + 1,
                ]);
            }
        }

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

        return redirect()->route('admin.products.index')->with('success','Producto creado.');
    }

    public function edit(Product $product){
        $product->load(['variants','images','ocasiones']);
        $categories = Category::where('actif',1)->orderBy('nom')->get();
        $ocasiones  = Ocasion::actif()->get();
        return view('admin.products.form',compact('product','categories','ocasiones'));
    }

    public function update(Request $request, Product $product){
        $data=$request->validate([
            'nom'                  => 'required|string|max:200',
            'categorie_id'         => 'required|exists:categories,id',
            'description_courte'   => 'nullable|string',
            'description'          => 'nullable|string',
            'actif'                => 'boolean',
            'en_vedette'           => 'boolean',
            'image_principale'     => 'nullable|image|max:4096',
            'ocasion_ids'          => 'nullable|array',
            'ocasion_ids.*'        => 'exists:ocasiones,id',
            'images_secondaires'   => 'nullable|array',
            'images_secondaires.*' => 'image|max:4096',
            'delete_images'        => 'nullable|array',
            'delete_images.*'      => 'integer',
        ]);
        $data['actif']      = $request->boolean('actif');
        $data['en_vedette'] = $request->boolean('en_vedette');

        if($request->hasFile('image_principale'))
            $data['image_principale'] = $request->file('image_principale')->store('products','public');

        $product->update($data);
        $product->ocasiones()->sync($request->input('ocasion_ids', []));

        // Supprimer images cochées
        if($request->filled('delete_images')){
            foreach($request->input('delete_images') as $imgId){
                $img = ProductImage::find($imgId);
                if($img && $img->produit_id === $product->id){
                    Storage::disk('public')->delete($img->url_image);
                    $img->delete();
                }
            }
        }

        // Nouvelles images secondaires
        if($request->hasFile('images_secondaires')){
            $maxOrdre = $product->images()->max('ordre') ?? 0;
            foreach($request->file('images_secondaires') as $i => $file){
                ProductImage::create([
                    'produit_id' => $product->id,
                    'url_image'  => $file->store('products','public'),
                    'alt_text'   => $product->nom,
                    'ordre'      => $maxOrdre + $i + 1,
                ]);
            }
        }

        // Variantes
        $ids = [];
        foreach($request->input('variantes',[]) as $v){
            if(!empty($v['id'])){
                $var = $product->variants()->find($v['id']);
                if($var){ $var->update(['label'=>$v['label'],'prix'=>$v['prix'],'prix_promo'=>$v['prix_promo']?:null,'stock'=>$v['stock'],'sku'=>$v['sku']?:null]); $ids[]=$var->id; }
            } else {
                $new=$product->variants()->create(['label'=>$v['label'],'prix'=>$v['prix'],'prix_promo'=>$v['prix_promo']?:null,'stock'=>$v['stock'],'sku'=>$v['sku']?:null,'actif'=>1]);
                $ids[]=$new->id;
            }
        }
        $product->variants()->whereNotIn('id',$ids)->delete();

        return redirect()->route('admin.products.index')->with('success','Producto actualizado.');
    }

    public function destroy(Product $product){ $product->delete(); return back()->with('success','Producto eliminado.'); }
    public function toggle(Product $product){ $product->update(['actif'=>!$product->actif]); return back()->with('success','Estado actualizado.'); }
    public function toggleFeatured(Product $product){ $product->update(['en_vedette'=>!$product->en_vedette]); return back()->with('success','Destacado actualizado.'); }
}

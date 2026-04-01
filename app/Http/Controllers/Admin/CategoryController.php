<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(){ $categories=Category::withCount('products')->with('parent')->orderBy('ordre')->get(); return view('admin.categories.index',compact('categories')); }
    public function create(){ $parents=Category::where('actif',1)->orderBy('nom')->get(); return view('admin.categories.form',compact('parents')); }
    public function store(Request $request){
        $data=$request->validate(['nom'=>'required|string|max:120','parent_id'=>'nullable|exists:categories,id','description'=>'nullable|string','ordre'=>'integer|min:0','actif'=>'boolean']);
        $data['slug']=Str::slug($data['nom']); $data['actif']=$request->boolean('actif',true);
        Category::create($data); return redirect()->route('admin.categories.index')->with('success','Catégorie créée.');
    }
    public function edit(Category $category){ $parents=Category::where('actif',1)->where('id','!=',$category->id)->orderBy('nom')->get(); return view('admin.categories.form',compact('category','parents')); }
    public function update(Request $request, Category $category){
        $data=$request->validate(['nom'=>'required|string|max:120','parent_id'=>'nullable|exists:categories,id','description'=>'nullable|string','ordre'=>'integer|min:0','actif'=>'boolean']);
        $data['actif']=$request->boolean('actif'); $category->update($data);
        return redirect()->route('admin.categories.index')->with('success','Catégorie mise à jour.');
    }
    public function destroy(Category $category){
        if($category->products()->count()>0) return back()->with('error','Impossible : cette catégorie contient des produits.');
        $category->delete(); return back()->with('success','Catégorie supprimée.');
    }
}

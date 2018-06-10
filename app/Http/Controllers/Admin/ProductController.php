<?php
namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\PdtContent;
use App\Entity\PdtImages;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use Illuminate\Http\Request;

class ProductController extends Controller{
    public function toProduct(){
        $products = Product::all();
        foreach ($products as $product){
            $product->category = Category::find($product->category_id);
        }
        return view('admin.product')->with('products',$products);

    }
    public function toProductAdd(){
        $categories = Category::all();
        return view('admin.product_add')->with('categories',$categories);
    }

    public function toProductEdit(Request $request){
        $product_id = $request->input('id','');
        $product_edit = Product::find($product_id);


        $pdt_images =PdtImages::where('product_id',$product_id)->get();

        $categories = Category::all();

        return view('admin.product_edit')->with('product_edit',$product_edit)
                                                ->with('pdt_images',$pdt_images)
                                                ->with('categories',$categories);

    }


    public function toProductInfo(Request $request){
        $product_id = $request->input('id','');
        $product = Product::find($product_id);
        $product->category = Category::find($product->category_id);

        $pdt_content = PdtContent::where('product_id',$product_id)->first();
        $pdt_images = PdtImages::where('product_id', $product_id)->get();

/*        $pdt_images = PdtImages::where('product_id',$product_id)->get();*/
        return view('admin.product_info')->with('pdt_content',$pdt_content)
                                                ->with('pdt_images',$pdt_images)
                                                ->with('product',$product);
    }


//    ***************service**********************
    public function productAdd(Request $request){

        $name = $request->input('name','');
        $summary = $request->input('summary','');
        $category_id = $request->input('category_id','');
        $price = $request->input('price','');
        $content = $request->input('content','');

        $preview = $request->input('preview','');
        $preview1 = $request->input('preview1','');
        $preview2 = $request->input('preview2','');
        $preview3 = $request->input('preview3','');
        $preview4 = $request->input('preview4','');
        $preview5 = $request->input('preview5','');

        $product = new Product();
        $product->name = $name;
        $product->summary = $summary;
        $product->category_id = $category_id;
        $product->price = $price;
        $product->preview = $preview;
        $product->save();

        $pdt_content = new PdtContent();
        $pdt_content->product_id = $product->id;
        $pdt_content->content = $content;
        $pdt_content->save();

        if($preview1 != null){
            $pdt_images = new PdtImages();
            $pdt_images->image_path= $preview1;
            $pdt_images->product_id = $product->id;
            $pdt_images->image_no = 1;
            $pdt_images->save();
        }
        if($preview2 != null){
            $pdt_images = new PdtImages();
            $pdt_images->image_path= $preview2;
            $pdt_images->product_id = $product->id;
            $pdt_images->image_no = 2;
            $pdt_images->save();
        }
        if($preview3 != null){
            $pdt_images = new PdtImages();
            $pdt_images->image_path= $preview3;
            $pdt_images->product_id = $product->id;
            $pdt_images->image_no = 3;
            $pdt_images->save();
        }
        if($preview4 != null){
            $pdt_images = new PdtImages();
            $pdt_images->image_path= $preview4;
            $pdt_images->product_id = $product->id;
            $pdt_images->image_no = 4;
            $pdt_images->save();
        }
        if($preview5 != null){
            $pdt_images = new PdtImages();
            $pdt_images->image_path= $preview5;
            $pdt_images->product_id = $product->id;
            $pdt_images->image_no = 5;
            $pdt_images->save();
        }

        $m3_result = new M3Result();
        $m3_result->status = 0;
        $m3_result->message ='添加产品成功';

        return $m3_result->toJson();

    }
    public function productEdit(Request $request){
        $product_id = $request->input('id','');
        $product = Product::find($product_id);

        $name = $request->input('name','');
        $summary = $request->input('summary','');
        $category_id = $request->input('category_id','');
        $price = $request->input('price','');
        $content = $request->input('content','');

        $preview = $request->input('preview','');
        $preview1 = $request->input('preview1','');
        $preview2 = $request->input('preview2','');
        $preview3 = $request->input('preview3','');
        $preview4 = $request->input('preview4','');
        $preview5 = $request->input('preview5','');

        $product->name = $name;
        $product->summary = $summary;
        $product->category_id = $category_id;
        $product->price = $price;
        $product->preview = $preview;
        $product->save();

        $pdt_content = new PdtContent();
        $pdt_content->product_id = $product->id;
        if ($pdt_content != null){
            $pdt_content->content = $content;

        }
        $pdt_content->save();

        if($preview1 != null){
            $pdt_images = new PdtImages();
            $pdt_images->image_path= $preview1;
            $pdt_images->product_id = $product->id;
            $pdt_images->image_no = 1;
            $pdt_images->save();
        }
        if($preview2 != null){
            $pdt_images = new PdtImages();
            $pdt_images->image_path= $preview2;
            $pdt_images->product_id = $product->id;
            $pdt_images->image_no = 2;
            $pdt_images->save();
        }
        if($preview3 != null){
            $pdt_images = new PdtImages();
            $pdt_images->image_path= $preview3;
            $pdt_images->product_id = $product->id;
            $pdt_images->image_no = 3;
            $pdt_images->save();
        }
        if($preview4 != null){
            $pdt_images = new PdtImages();
            $pdt_images->image_path= $preview4;
            $pdt_images->product_id = $product->id;
            $pdt_images->image_no = 4;
            $pdt_images->save();
        }
        if($preview5 != null){
            $pdt_images = new PdtImages();
            $pdt_images->image_path= $preview5;
            $pdt_images->product_id = $product->id;
            $pdt_images->image_no = 5;
            $pdt_images->save();
        }

        $m3_result = new M3Result();
        $m3_result->status = 0;
        $m3_result->message ='添加产品成功';

        return $m3_result->toJson();

    }

    public function productDelete(Request $request){
        $product_id = $request->input('id','');
        Product::find($product_id)->delete();
        PdtContent::where('product_id',$product_id)->delete();
        PdtImages::where('product_id',$product_id)->delete();


        $m3_result = new M3Result();
        $m3_result->status = 0;
        $m3_result->message ='删除产品成功';
        return $m3_result->toJson();
    }

    public function itemsDelete(Request $request){
        //删product
        $product_ids = $request->input('ids','');
        $m3_result = new M3Result();
        if ($product_ids == null){
            $m3_result->status = 1;
            $m3_result->message ='删除产品失败，没有删除id';
            return $m3_result->toJson();

        }
        $product_ids_arr = explode(',',$product_ids);

        Product::whereIn('id',$product_ids_arr)->delete();
        PdtContent::whereIn('product_id',$product_ids_arr)->delete();
        PdtImages::whereIn('product_id',$product_ids_arr)->delete();
        //删pdt_content

        $m3_result->status = 0;
        $m3_result->message ='删除产品成功';
        return $m3_result->toJson();
/*        $product_ids = $request->input('ids','');
        $product_ids_arr = explode(',',$product_ids);
        $m3_result = new M3Result();
        if ($product_ids == null){
            $m3_result->status = 1;
            $m3_result->message='删除失败，类别id为空';
            return $m3_result->toJson();
        }
        Product::whereIn('id',$product_ids_arr)->delete();


        $m3_result->status = 0;
        $m3_result->message='删除成功';
        return $m3_result->toJson();*/
    }


}
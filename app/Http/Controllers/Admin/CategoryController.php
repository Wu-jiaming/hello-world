<?php
namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use Illuminate\Http\Request;

class CategoryController extends Controller{
    public function toCategory(){
        $categories = Category::all();

        foreach ($categories as $category){
            if ($category->parent_id != null && $category->parent_id != ''){
                $category->product = Category::find($category->parent_id);//指定￥category里面的parent为category的对象
            }
        }
        return view('admin.category')->with('categories',$categories);
    }

    public function toCategoryAdd(){
        $categories = Category::whereNull('parent_id')->get();

        return view('admin.category_add')->with('categories',$categories);
    }

    public function toCategoryEdit(Request $request){
        $categories = Category::whereNull('parent_id')->get();

        $category_id = $request->input('id','');
//        $categories_edit = Category::where($category_id)->get();where(参数)参数是数据库的字段名
        $category_edit = Category::find($category_id);//find(参数) 参数可以是字符串，（可以自己另外编写）
        return view('admin.category_edit')->with('category_edit',$category_edit)
                                                ->with('categories',$categories);
    }


//    ******************service***************************
    public function categoryAdd(Request $request){
        $name = $request->input('name','');
        $category_no = $request->input('category_no','');
        $parent_id = $request->input('parent_id','');
        $image = $request->input('image','');

        $category = new Category();
        $category->name = $name;
        $category->category_no = $category_no;
        $category->preview = $image;

        if ($parent_id != ''){
            $category->parent_id = $parent_id;
        }
        $category->save();

        $m3_result = new M3Result();
        $m3_result->status = 0;
        $m3_result->message='添加成功';
        return $m3_result->toJson();


    }

    public function categoryEdit(Request $request){
        $category_id = $request->input('id','');
        $category = Category::find($category_id);

        $name = $request->input('name','');
        $category_no = $request->input('category_no','');
        $parent_id = $request->input('parent_id','');
        $image = $request->input('image','');

        $category->preview = $image;
        $category->name = $name;
        $category->category_no = $category_no;
        if($parent_id != '') {
            $category->parent_id = $parent_id;
        }

        $category->save();

        $m3_result = new M3Result();
        $m3_result->status = 0;
        $m3_result->message='修改成功';
        return  $m3_result->toJson();
//        return response($m3_result->toJson());
    }

    public function categoryDelete(Request $request){
        $category_id = $request->input('id','');
        Category::find($category_id)->delete();

        $m3_result = new M3Result();
        $m3_result->status = 0;
        $m3_result->message='删除成功';
        return $m3_result->toJson();
    }


    public function itemsDelete(Request $request){
        $category_ids = $request->input('ids','');
        $category_ids_arr = explode(',',$category_ids);
        $m3_result = new M3Result();
        if ($category_ids == null){
            $m3_result->status = 1;
            $m3_result->message='删除失败，类别id为空';
            return $m3_result->toJson();
        }
        Category::whereIn('id',$category_ids_arr)->delete();


        $m3_result->status = 0;
        $m3_result->message='删除成功';
        return $m3_result->toJson();
    }
}
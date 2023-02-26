<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductContorller extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);
        return view('product.index', compact('products'));
    }
    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:products|max:255',
            'product_image' => 'required|mimes:jpg,jpeg,png',
            'bom_id' => 'required',
            'brand_id' => 'required',
            'type_id' => 'required',
            'quantity' => 'required',
            'model_id' => 'required',
        ], [
            'product_id.required' => "กรุณาป้อนรหัสสินค้า",
            'product_id.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'product_id.unique' => "มีรหัสสินค้านี้แล้ว",

            'product_name.required' => "กรุณาป้อนชื่อสินค้า",
            'product_name.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'product_name.unique' => "มีสินค้านี้แล้ว",

            'product_image.required' => "กรุณาใส่ภาพสินค้า",

            
            'type_id.required' => "กรุณาใส่ประเภทสินค้า",
            'quantity.required' => "กรุณาใส่จำนวนสินค้า",
            'bom_id.required' => "กรุณาใส่ bom id",
            'model_id.required' => "กรุณาใส่ Model id",
            'brand_id.required' => "กรุณาใส่ brand id",
        ]
        );
        ///เข้ารหัสรูปภาพ
        $product_image = $request->file('product_image');
        ///Gen ภาพ
        $name_gen = hexdec(uniqid());
        //ดึงนามสกุล
        $img_ext = strtolower($product_image->getClientOriginalExtension());

        $img_name = $name_gen . '.' . $img_ext;

        //upload_img
        $upload_location = 'image/products/';
        $full_path = $upload_location . $img_name;

        Product::insert([
            'product_name' => $request->product_name,
            'product_image' => $full_path,
            'brand_id' => $request->brand_id,
            'type_id' => $request->type_id,
            'model_id' => $request->model_id,
            'bom_id' => $request->bom_id,
            'quantity' => $request->quantity,
            'created_at' => Carbon::now(),
        ]);
        $product_image->move($upload_location, $img_name);
        return redirect()->route('product.index')->with('success', "เพิ่มข้อมูลสำเร็จ");
    }
    public function edit($id)
    {
        $product = Product::find($id);
        return view('product.edit', compact('product'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'max:255',
            'product_image' => 'mimes:jpg,jpeg,png',
            'brand_id' => 'required',
            'type_id' => 'required',
            'quantity' => 'required',
        ], [
            'product_id.required' => "กรุณาป้อนรหัสสินค้า",
            'product_id.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'product_id.unique' => "มีรหัสสินค้านี้แล้ว",

            'product_name.required' => "กรุณาป้อนชื่อสินค้า",
            'product_name.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'product_name.unique' => "มีสินค้านี้แล้ว",

            'product_image.required' => "กรุณาใส่ภาพสินค้า",

            'brand_id.required' => "กรุณาใส่ยี่ห้อสินค้า",
            'type_id.required' => "กรุณาใส่ประเภทสินค้า",
            'quantity.required' => "กรุณาใส่จำนวนสินค้า",
        ]
        );
        ///เข้ารหัสรูปภาพ
        $product_image = $request->file('product_image');
        //อัพเดทภาพและชือ
        if ($product_image) {
            $name_gen = hexdec(uniqid());
            //ดึงนามสกุล
            $img_ext = strtolower($product_image->getClientOriginalExtension());

            $img_name = $name_gen . '.' . $img_ext;

            //upload_img
            $upload_location = 'image/products/';
            $full_path = $upload_location . $img_name;

            Product::find($id)->update([
                'product_name' => $request->product_name,
                'product_image' => $full_path,
                'brand_id' => $request->brand_id,
                'type_id' => $request->type_id,
                'model_id' => $request->model_id,
                'bom_id' => $request->bom_id,
                'quantity' => $request->quantity,
                'created_at' => Carbon::now(),
            ]);
            //ลบภาพเก่าและอัพภาพใหม่

            $old_image = $request->old_image;
            unlink($old_image);
            $product_image->move($upload_location, $img_name);
            return redirect()->route('product.index')->with('success', "อัพเดทข้อมูลสำเร็จ");
        } else {
            //อัพเดทชื่ออย่างเดียว
            Product::find($id)->update([
                'product_name' => $request->product_name,
                'brand_id' => $request->brand_id,
                'type_id' => $request->type_id,
                'model_id' => $request->model_id,
                'bom_id' => $request->bom_id,
                'quantity' => $request->quantity,
                
            ]);
            return redirect()->route('product.index')->with('success', "อัพเดทข้อมูลสำเร็จ");
        }

        /*return redirect()->route('supplier.index')->with('success' ,"แก้ไข้ข้อมูลสำเร็จ");*/
    }
    public function destroy($id)
    {
        //ลบภาพ
        $img = Product::find($id)->product_image;
        unlink($img);
        //ลบข้อมูลจากฐานข้อมูล
        $delete = Product::find($id)->delete();
        return redirect()->route('product.index')->with('success', "ลบข้อมูลสำเร็จ");
    }
}

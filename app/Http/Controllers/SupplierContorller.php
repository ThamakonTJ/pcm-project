<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierContorller extends Controller
{
    function sup(){
        $data['suppliers'] = Supplier::orderBy('id','asc')->paginate(5);
        return view('supplier.index', $data);
    }

    public function create() {

        return view('supplier.create');
    }
    
    public function store(Request $request){
        $request ->validate([
            'sup_id' => 'required',
            'sup_name' => 'required',
            'address' => 'required',
            'product_type' => 'required',
            'phone' => 'required',
            'fax' => 'required',
            'since' => 'required',
            'registered_capital' => 'required',
            'contact_name' => 'required',
            'email' => 'required'

        ],[
            
            'sup_id' => 'กรุณาใส่รหัสซํพพลายเออร์',
            'sup_name' => 'กรุณาใส่ชื่อซัพพลายเออร์',
            'address' => 'กรุณาใส่ที่อยู่',
            'product_type' => 'กรุณาใส่ประเภทสินค้า',
            'phone' => 'กรุณาใส่เบอร์โทรศัพท์',
            'fax' => 'กรุณาใส่หมายเลขแฟกซ์',
            'since' => 'กรุณาใส่ปีที่ก่อตั้ง',
            'registered_capital' => 'กรุณาใส่ทุนจดทะเบียน',
            'contact_name' => 'กรุณาใส่ช่องทางติดต่อ',
            'email' => 'กรุณาใส่อีเมล'
        ]);

        $supplier = new Supplier;
        $supplier->sup_id = $request->sup_id;
        $supplier->sup_name = $request->sup_name;
        $supplier->address = $request->address;
        $supplier->product_type = $request->product_type;
        $supplier->phone = $request->phone;
        $supplier->fax = $request->fax;
        $supplier->since = $request->since;
        $supplier->registered_capital = $request->registered_capital;
        $supplier->contact_name = $request->contact_name;
        $supplier->email = $request->email;

        $supplier->save();

        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'newahp';
    
        $koneksi = mysqli_connect($host,$username,$password);
    
        if (!$koneksi)
        {
            echo "Tidak dapat terkoneksi dengan server";
            exit();
        }
    
        if(!mysqli_select_db($koneksi, $database))
        {
            echo "Tidak dapat menemukan database";
            exit();
        }

        $query 	= "INSERT INTO alternatif (nama,product_type) VALUES ('$request->sup_name','$request->product_type')";
        $tambah	= mysqli_query($koneksi, $query);
    
        if (!$tambah) {
            echo "invalid";
            exit();
        }
        
        return redirect()->route('supplier.index')->with('success' ,"เพิ่มข้อมูลสำเร็จ");
    }

    public function edit(Supplier $supplier) {
        return view('supplier.edit', compact('supplier'));

    }

    public function update(Request $request, $id) {
        $request ->validate([
            'sup_id' => 'required',
            'sup_name' => 'required',
            'address' => 'required',
            'product_type' => 'required',
            'phone' => 'required',
            'fax' => 'required',
            'since' => 'required',
            'registered_capital' => 'required',
            'contact_name' => 'required',
            'email' => 'required'

        ]);

        $supplier = Supplier::find($id);
        $supplier->sup_id = $request->sup_id;
        $supplier->sup_name = $request->sup_name;
        $supplier->address = $request->address;
        $supplier->product_type = $request->product_type;
        $supplier->phone = $request->phone;
        $supplier->fax = $request->fax;
        $supplier->since = $request->since;
        $supplier->registered_capital = $request->registered_capital;
        $supplier->contact_name = $request->contact_name;
        $supplier->email = $request->email;

        $supplier->save();
        return redirect()->route('supplier.index')->with('success' ,"แก้ไข้ข้อมูลสำเร็จ");
    }

    public function destroy(Supplier $supplier){
        $supplier->delete();
        return redirect()->route('supplier.index')->with('success' ,"ลบข้อมูลสำเร็จ");
    }

}

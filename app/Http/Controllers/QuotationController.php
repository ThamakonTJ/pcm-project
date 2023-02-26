<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Quotation;
use Carbon\Carbon;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations= Quotation::paginate(5);
        return view('quotation.index', compact('quotations'));
    }
    public function create()
    {
        return view('quotation.create');
    }
    public function pimquo($id)
    {
        $quoid = request()->id;
        $quotations= Quotation::all();
        return view('quotation.pimquo', compact('quotations') , compact('quoid'));
    }
    public function edit($id)
    {
        $quoid = Quotation::find($id);
        //$quotation= Quotation::all();
        //$quotations = Quotation::find($id);
        //$quoid = request()->id;
        //dd($quoid);
        return view('quotation.edit', compact('quoid'));
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'job_no' => 'required|unique:quotations|max:255',
            'sup_name' => 'required|max:255',
            'recipient' => 'required',
            'quotation_file' => 'required|mimes:pdf,jpg,jpeg,png'
        ], [
            'job_no.required' => "กรุณาป้อนรหัสใบเสนอราคา",
            'job_no.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'job_no.unique' => "มีรหัสนี้แล้ว",

            'sup_name.required' => "กรุณาป้อนชื่อบริษัท",
            'sup_name.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'recipient.required' => "กรุณาป้อนชื่อผู้รับ",

            'quotation_file.required' => "กรุณาใส่ไฟล์ใบเสนอราคา",
        ]
        );
        ///เข้ารหัสรูปภาพ
        $quotation_file = $request->file('quotation_file');
        ///Gen ภาพ
        $name_gen = hexdec(uniqid());
        //ดึงนามสกุล
        $file_ext = strtolower($quotation_file->getClientOriginalExtension());

        $file_name = $name_gen . '.' . $file_ext;

        //upload_img
        $upload_location = 'image/quotations/';
        $full_path = $upload_location . $file_name;

        Quotation::insert([
            
            'job_no' => $request->job_no,
            'sup_name' => $request->sup_name,
            'recipient' => $request->recipient,
            'quotation_file' => $full_path,
            'date' => $request->date,
            //'created_at' => Carbon::now(),
        ]);
        $quotation_file->move($upload_location, $file_name);
        return redirect()->route('quotation.index')->with('success', "เพิ่มข้อมูลสำเร็จ");
      
    }

    public function update(Request $request,$id){
        $request->validate([
            'job_no' => 'max:255',
            'sup_name' => 'max:255',
            'recipient' => 'required',
            'quotation_file' => 'mimes:pdf,jpg,jpeg,png'
        ], [
            'job_no.required' => "กรุณาป้อนรหัสใบเสนอราคา",
            'job_no.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'job_no.unique' => "มีรหัสนี้แล้ว",

            'sup_name.required' => "กรุณาป้อนชื่อบริษัท",
            'sup_name.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'recipient.required' => "กรุณาป้อนชื่อผู้รับ",

            'quotation_file.required' => "กรุณาใส่ไฟล์ใบเสนอราคา",
        ]
        );
        ///เข้ารหัสรูปภาพ
        $quotation_file = $request->file('quotation_file');
        ///Gen ภาพ
        if ($quotation_file) {
        $name_gen = hexdec(uniqid());
        //ดึงนามสกุล
        $file_ext = strtolower($quotation_file->getClientOriginalExtension());

        $file_name = $name_gen . '.' . $file_ext;

        //upload_img
        $upload_location = 'image/quotations/';
        $full_path = $upload_location . $file_name;

        Quotation::find($id)->update([
            
            'job_no' => $request->job_no,
            'sup_name' => $request->sup_name,
            'recipient' => $request->recipient,
            'quotation_file' => $full_path,
            'date' => $request->date,
            'created_at' => Carbon::now(),
        ]);
        $quotation_file->move($upload_location, $file_name);
        return redirect()->route('quotation.index')->with('success', "อัพเดทข้อมูลสำเร็จ");
    }
    else {
        //อัพเดทชื่ออย่างเดียว
        Quotation::find($id)->update([
            'job_no' => $request->job_no,
            'sup_name' => $request->sup_name,
            'recipient' => $request->recipient,
            'date' => $request->date,
            
        ]);
        return redirect()->route('quotation.index')->with('success', "อัพเดทข้อมูลสำเร็จ");
    }
    }

    public function destroy($id)
    {
        //ลบข้อมูลจากฐานข้อมูล
        $delete = Quotation::find($id)->delete();
        return redirect()->route('quotation.index')->with('success', "ลบข้อมูลสำเร็จ");
    }


}

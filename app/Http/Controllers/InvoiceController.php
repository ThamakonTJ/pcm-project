<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::paginate(5);
        return view('invoice.index', compact('invoices'));
    }
    public function create()
    {
        return view('invoice.create');
    }
    public function piminvoice($id)
    {
        $invoiceid = request()->id;
        $invoices = Invoice::all();
        return view('invoice.piminvoice', compact('invoices'), compact('invoiceid'));
    }
    public function destroy($id)
    {
        //ลบข้อมูลจากฐานข้อมูล
        $delete = Invoice::find($id)->delete();
        return redirect()->route('invoice.index')->with('success', "ลบข้อมูลสำเร็จ");
    }
    public function edit($id)
    {
        $invoiceid = Invoice::find($id);
        //$quotation= Quotation::all();
        //$quotations = Quotation::find($id);
        //$quoid = request()->id;
        //dd($quoid);
        return view('invoice.edit', compact('invoiceid'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'PO_NO' => 'required|unique:invoices|max:255',
            'In_No' => 'required|unique:invoices|max:255',
            'sup_name' => 'required|max:255',
            'recipient' => 'required',
            'price' => 'required',
            'invoices_file' => 'required|mimes:pdf,jpg,jpeg,png',
        ], [
            'PO_NO.required' => "กรุณาใส่รหัสใบเสนอราคา",
            'PO_NO.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'PO_NO.unique' => "มีรหัสนี้แล้ว",

            'In_No.required' => "กรุณาใส่รหัสใบเสนอราคา",
            'In_No.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'In_No.unique' => "มีรหัสนี้แล้ว",

            'sup_name.required' => "กรุณาใส่ชื่อบริษัท",
            'sup_name.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'recipient.required' => "กรุณาป้อนชื่อผู้รับ",

            'invoices_file.required' => "กรุณาใส่ไฟล์ใบเสร็จ",
            'price.required' => "กรุณาใส่ราคารวมทั้งหมด",
        ]
        );
        ///เข้ารหัสรูปภาพ
        $invoices_file = $request->file('invoices_file');
        ///Gen ภาพ
        $name_gen = hexdec(uniqid());
        //ดึงนามสกุล
        $file_ext = strtolower($invoices_file->getClientOriginalExtension());

        $file_name = $name_gen . '.' . $file_ext;

        //upload_img
        $upload_location = 'image/invoices/';
        $full_path = $upload_location . $file_name;

        Invoice::insert([
            'PO_NO' => $request->PO_NO,
            'In_No' => $request->In_No,
            'sup_name' => $request->sup_name,
            'recipient' => $request->recipient,
            'price' => $request->price,
            'invoices_file' => $full_path,
            'created_at' => Carbon::now(),

        ]);
        $invoices_file->move($upload_location, $file_name);
        return redirect()->route('invoice.index')->with('success', "เพิ่มข้อมูลสำเร็จ");

    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'PO_NO' => 'max:255',
            'In_No' => 'max:255',
            'sup_name' => 'max:255',
            'price' => 'max:255',
            'recipient' => 'required',
            'invoices_file' => 'mimes:pdf,jpg,jpeg,png',
        ], [
            'PO_NO.required' => "กรุณาป้อนรหัสใบเสนอราคา",
            'PO_NO.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'PO_NO.unique' => "มีรหัสนี้แล้ว",

            'In_No.required' => "กรุณาป้อนรหัสใบเสนอราคา",
            'In_No.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'In_No.unique' => "มีรหัสนี้แล้ว",

            'sup_name.required' => "กรุณาป้อนชื่อบริษัท",
            'sup_name.max' => "ความยาวชื่อสินค้าเกิน 255 ตัวอักษร",
            'recipient.required' => "กรุณาป้อนชื่อผู้รับ",

            'invoices_file.required' => "กรุณาใส่ไฟล์ใบเสร็จ",
        ]
        );
        ///เข้ารหัสรูปภาพ
        $invoices_file = $request->file('invoices_file');
        ///Gen ภาพ
        if ($invoices_file) {
            $name_gen = hexdec(uniqid());
            //ดึงนามสกุล
            $file_ext = strtolower($invoices_file->getClientOriginalExtension());

            $file_name = $name_gen . '.' . $file_ext;

            //upload_img
            $upload_location = 'image/invoices/';
            $full_path = $upload_location . $file_name;

            Invoice::find($id)->update([
                'PO_NO' => $request->PO_NO,
                'In_No' => $request->In_No,
                'sup_name' => $request->sup_name,
                'recipient' => $request->recipient,
                'invoices_file' => $full_path,
                'updated_at' => Carbon::now(),
                'price' => $request->price,
            ]);
            $invoices_file->move($upload_location, $file_name);
            return redirect()->route('invoice.index')->with('success', "อัพเดทข้อมูลสำเร็จ");
        } else {
            //อัพเดทชื่ออย่างเดียว
            Invoice::find($id)->update([
                'PO_NO' => $request->PO_NO,
                'In_No' => $request->In_No,
                'sup_name' => $request->sup_name,
                'recipient' => $request->recipient,
                'updated_at' => Carbon::now(),
                'price' => $request->price,
            ]);
            return redirect()->route('invoice.index')->with('success', "อัพเดทข้อมูลสำเร็จ");
        }
    }
}

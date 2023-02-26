<?php

namespace App\Http\Controllers;

use App\Models\po;
use App\Models\po_details;
use App\Models\Pr;
use App\Models\prmulti;
use App\Models\Pr_Details;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('dashboards.users.index');
    }
    public function profile()
    {
        return view('dashboards.users.profile');
    }
    public function setting()
    {
        return view('dashboards.users.setting');
    }
    public function pr()
    {
        $pr = Pr::all();
        return view('dashboards.users.pr', compact('pr'));
    }
    public function po()
    {
        $po = po_details::all();
        return view('dashboards.users.po', compact('po'));
    }
    public function quo()
    {
        return view('dashboards.users.quo');
    }
    public function pimpr($Doc_NO)
    {
        //$po = Pr::query()->find($Doc_NO);
        $pr = request()->Doc_NO;
        //dd($pim);
        return view('dashboards.users.pimpr', compact('pr'));
        //$request->file->getClientOriginalName();
    }
    public function pimpo()
    {
        $po = request()->PO_NO;
        return view('dashboards.users.pimpo', compact('po'));
    }

    public function index2()
    {
        return view('dashboards.users.pr');
    }
    public function submit(Request $request)
    {
        $request->toArray();
        $data = new pr();
        $data->Doc_NO = $request->Doc_NO;
        $data->date = $request->date;
        $data->company_name = $request->company_name;
        $data->department = $request->department;
        $data->reason_to_buy = $request->reason_to_buy;
        $data->save();
        foreach ($request->pcs as $key => $product) {
            $data = new prmulti();
            $data->Doc_NO = $request->Doc_NO;
            $data->product = $request->product[$key];
            $data->pcs = $request->pcs[$key];
            $data->price_pcs = $request->price_pcs[$key];
            $data->total_price = $request->total_price[$key];
            $data->note = $request->note[$key];
            $data->save();
        }
        return redirect()->route('user.pr')->with('success');
    }
    public function editpr($id)
    {
        $editpr = Pr::find($id);

        return view('dashboards.users.editpr', compact('editpr'));
    }
    public function updatepr(Request $request, $id)
    {
        $update = Pr::find($id)->update([
            'Doc_NO' => $request->Doc_NO,
            'date' => $request->date,
            'company_name' => $request->company_name,
            'department' => $request->department,
            'reason_to_buy' => $request->reason_to_buy,
        ]);
        $ids = $request->input('id');
        $products = $request->input('product');
        $pcss = $request->input('pcs');
        $price_pcss = $request->input('price_pcs');
        $total_prices = $request->input('total_price');
        $notes = $request->input('note');
        for ($count = 0; $count < count($ids); $count++) {
            $update = prmulti::find($ids[$count])->update([
                'product' => $products[$count],
                'pcs' => $pcss[$count],
                'price_pcs' => $price_pcss[$count],
                'total_price' => $total_prices[$count],
                'note' => $notes[$count],
            ]);
        }
        $newIds = $request->input('newId');
        
        if(!empty($newIds)){
            $newProducts = $request->input('newProduct');
            $newPcss = $request->input('newPcs');
            $newPrice_pcss = $request->input('newPrice_pcs');
            $newTotal_prices = $request->input('newTotal_price');
            $newNotes = $request->input('newNote');
            for ($count = 0; $count < count($newIds); $count++) {
                $update = prmulti::insert([
                    'Doc_NO' => $request->Doc_NO,
                    'product' => $newProducts[$count],
                    'pcs' => $newPcss[$count],
                    'price_pcs' => $newPrice_pcss[$count],
                    'total_price' => $newTotal_prices[$count],
                    'note' => $newNotes[$count],
                ]);
            }
        }

        return redirect()->route('user.pr')->with('success');
    }
    public function detroypr(Request $request, $id)
    {
        $delete = prmulti::query()->find($request->input('delete'));
        $editpr = Pr::find($id);
        $delete->delete();

   
        return redirect()->route('user.editpr', ['id' => $id])->with('success');
    }

    public function delete($Doc_NO)
    {
        //ลบข้อมูลจากฐานข้อมูล
        $pr = Pr::query()->find($Doc_NO);
        //$prx =prmulti::query()->find($Doc_NO);
        //DD($Doc_NO);
        //if(is_null($pr)) {
        //    abort(404);
        //}
        $pr->delete();
        return redirect()->route('user.pr')->with('success');
    }

//PO
    public function submit2(Request $request)
    {
        $request->toArray();
        $data = new po_details();
        $data->Doc_NO = $request->Doc_NO;
        $data->PO_NO = $request->PO_NO;
        $data->date = $request->date;
        $data->teams_of_payment = $request->teams_of_payment;
        $data->delivery_date = $request->delivery_date;
        $data->attn = $request->attn;
        $data->company_name = $request->company_name;
        $data->reason_to_buy = $request->reason_to_buy;
        $data->save();
        foreach ($request->pcs as $key => $product) {
            $data = new po();
            $data->PO_NO = $request->PO_NO;
            $data->product = $request->product[$key];
            $data->pcs = $request->pcs[$key];
            $data->price_pcs = $request->price_pcs[$key];
            $data->total_price = $request->total_price[$key];
            $data->save();
        }
        return redirect()->route('user.po')->with('success');
    }
    public function delete2($PO_NO)
    {
        //ลบข้อมูลจากฐานข้อมูล
        $po = po::query()->find($PO_NO);
        //$prx =prmulti::query()->find($Doc_NO);
        //DD($Doc_NO);
        //if(is_null($pr)) {
        //    abort(404);
        //}
        $po->delete();
        
        return redirect()->route('user.po')->with('success');
    }

    public function editpo($id)
    {
        $editpo = po_details::find($id);
        
        return view('dashboards.users.editpo', compact('editpo'));
    }

    public function updatepo(Request $request, $id)
    {
        po_details::find($id)->update([
            'PO_NO' => $request->PO_NO,
            'date' => $request->date,
            'teams_of_payment' => $request->teams_of_payment,
            'delivery_date' => $request->delivery_date,
            'attn' => $request->attn,
            'company_name' => $request->company_name,
            'reason_to_buy' => $request->reason_to_buy,
        ]);
        $ids = $request->input('id');
        $products = $request->input('product');
        $pcss = $request->input('pcs');
        $price_pcss = $request->input('price_pcs');
        $total_prices = $request->input('total_price');
        for ($count = 0; $count < count($ids); $count++) {
            $update = po::find($ids[$count])->update([
                'product' => $products[$count],
                'pcs' => $pcss[$count],
                'price_pcs' => $price_pcss[$count],
                'total_price' => $total_prices[$count],
               
            ]);
        }
        $newIds = $request->input('newId');
        
        if(!empty($newIds)){
            $newProducts = $request->input('newProduct');
            $newPcss = $request->input('newPcs');
            $newPrice_pcss = $request->input('newPrice_pcs');
            $newTotal_prices = $request->input('newTotal_price');
           
            for ($count = 0; $count < count($newIds); $count++) {
                $update = po::insert([
                    'PO_NO' => $request->PO_NO,
                    'product' => $newProducts[$count],
                    'pcs' => $newPcss[$count],
                    'price_pcs' => $newPrice_pcss[$count],
                    'total_price' => $newTotal_prices[$count],
                    
                ]);
            }
        }
        return redirect()->route('user.po')->with('success');
    }
    public function detroypo(Request $request, $id)
    {
        $delete = po::query()->find($request->input('delete'));
        $editpr = po_details::find($id);
        $delete->delete();

   
        return redirect()->route('user.editpo', ['id' => $id])->with('success');
    }

    public function updateInfo(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $query = User::find(Auth::user()->id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if (!$query) {
                return response()->json(['status' => 0, 'msg' => 'Something went wrong.']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Your profile info has been update successfuly.']);
            }
        }
    }

    public function updatePicture(Request $request)
    {
        $path = 'users/images/';
        $file = $request->file('user_image');
        $new_name = 'UIMG_' . date('Ymd') . uniqid() . '.jpg';

        //Upload new image
        $upload = $file->move(public_path($path), $new_name);

        if (!$upload) {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong, upload new picture failed.']);
        } else {
            //Get Old picture
            $oldPicture = User::find(Auth::user()->id)->getAttributes()['picture'];

            if ($oldPicture != '') {
                if (\File::exists(public_path($path . $oldPicture))) {
                    \File::delete(public_path($path . $oldPicture));
                }
            }

            //Update DB
            $update = User::find(Auth::user()->id)->update(['picture' => $new_name]);

            if (!$upload) {
                return response()->json(['status' => 0, 'msg' => 'Something went wrong, updating picture in db failed.']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Your profile picture has been updated successfully']);
            }
        }
    }

    public function changePassword(Request $request)
    {
        //Validate form
        $validator = \Validator::make($request->all(), [
            'oldpassword' => [
                'required', function ($attribute, $value, $fail) {
                    if (!\Hash::check($value, Auth::user()->password)) {
                        return $fail(__('The current password is incorrect'));
                    }
                },
                'min:8',
                'max:30',
            ],
            'newpassword' => 'required|min:8|max:30',
            'cnewpassword' => 'required|same:newpassword',
        ], [
            'oldpassword.required' => 'Enter your current password',
            'oldpassword.min' => 'Old password must have atleast 8 characters',
            'oldpassword.max' => 'Old password must not be greater than 30 characters',
            'newpassword.required' => 'Enter new password',
            'newpassword.min' => 'New password must have atleast 8 characters',
            'newpassword.max' => 'New password must not be greater than 30 characters',
            'cnewpassword.required' => 'ReEnter your new password',
            'cnewpassword.same' => 'New password and Confirm new password must match',
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $update = User::find(Auth::user()->id)->update(['password' => \Hash::make($request->newpassword)]);

            if (!$update) {
                return response()->json(['status' => 0, 'msg' => 'Something went wrong, Failed to update password in db']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Your password has been changed successfully']);
            }
        }
    }

}

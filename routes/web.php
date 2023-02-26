<?php

use App\Models\Invoice;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SaffController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\SupplierContorller;
use App\Http\Controllers\ProductContorller;
use App\Models\Product;
use App\Http\Controllers\AhpController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\prmulti;
use App\Models\Pr;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['middleware'=>'PreventBackHistroy'])->group(function () {
    Auth::routes();
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('roleMain', [LoginController::class , 'roleMain']);

Route::group(['prefix'=>'admin','middleware'=>['isAdmin','auth','PreventBackHistroy']],function(){
    Route::resource('Admin', AdminController::class);
    Route::get('dashboard', [AdminController::class,'index'])->name('admin.dashboard');
    Route::get('profile', [AdminController::class,'profile'])->name('admin.profile');
    Route::get('setting', [AdminController::class,'setting'])->name('admin.setting');

    Route::get('roleMain', [LoginController::class , 'roleMain']);

    
    Route::post('update-profile-info',[AdminController::class,'updateInfo'])->name('adminUpdateInfo');
    Route::post('change-profile-picture',[AdminController::class,'updatePicture'])->name('adminPictureUpdate');
    Route::post('change-password',[AdminController::class,'changePassword'])->name('adminChangePassword');

    ///add user
    Route::resource('manage_user', AdminController::class);
    Route::get('manage_user', [AdminController::class,'manage_user_index'])->name('manage_user.index');
    Route::get('create', [AdminController::class,'create'])->name('manage_user.create');
    Route::post('store', [AdminController::class,'store'])->name('manage_user.store');

    

       ///PR
       Route::get('pr', [UserController::class,'pr'])->name('admin.pr');
       Route::get('/pimpr/{Doc_NO}', [UserController::class,'pimpr'])->name('admin.pimpr');
       Route::get('/editpr/{id}', [UserController::class,'editpr'])->name('admin.editpr');
       Route::post('/update/{id}', [UserController::class,'updatepr'])->name('admin.update');
       Route::get('/multi-insert', [UserController::class,'index2'])->name('multi-insert');
       Route::post('/submit', [UserController::class,'submit'])->name('admin.submit');
       Route::delete('/delete/{id}', [UserController::class,'delete'])->name('admin.delete');
       Route::delete('/delete/{Doc_NO}', [UserController::class,'delete'])->name('admin.delete');
       
       Route::get('/detroy/{id}', [UserController::class,'detroypr'])->name('admin.detroy');
   
   
   
       ///PO
       Route::get('po', [UserController::class,'po'])->name('admin.po');
       Route::get('/pimpo/{PO_NO}', [UserController::class,'pimpo'])->name('admin.pimpo');
       Route::post('/submit2', [UserController::class,'submit2'])->name('admin.submit2');
       Route::delete('/delete2/{id}', [UserController::class,'delete2'])->name('admin.delete2');
       Route::delete('/delete2/{Doc_NO}', [UserController::class,'delete2'])->name('admin.delete2');
       Route::get('/editpo/{id}', [UserController::class,'editpo'])->name('admin.editpo');
       Route::post('/updatepo/{id}', [UserController::class,'updatepo'])->name('admin.updatepo');
       Route::get('/detroy_po/{id}', [UserController::class,'detroypo'])->name('admin.detroy_po');

});

Route::group(['prefix'=>'user','middleware'=>['isUser','auth','PreventBackHistroy']],function(){
    Route::get('dashboard', [UserController::class,'index'])->name('user.dashboard');
    Route::get('profile', [UserController::class,'profile'])->name('user.profile');
    Route::get('setting', [UserController::class,'setting'])->name('user.setting');
  
    Route::get('roleMain', [LoginController::class , 'roleMain']);


    Route::post('update-profile-info',[UserController::class,'updateInfo'])->name('userUpdateInfo');
    Route::post('change-profile-picture',[UserController::class,'updatePicture'])->name('userPictureUpdate');
    Route::post('change-password',[UserController::class,'changePassword'])->name('userChangePassword');



       ///PR
       Route::get('pr', [UserController::class,'pr'])->name('user.pr');
       Route::get('/pimpr/{Doc_NO}', [UserController::class,'pimpr'])->name('user.pimpr');
       Route::get('/editpr/{id}', [UserController::class,'editpr'])->name('user.editpr');
       
       Route::post('/update/{id}', [UserController::class,'updatepr'])->name('user.update');
       
       Route::get('/detroy/{id}', [UserController::class,'detroypr'])->name('user.detroy');

       Route::get('/multi-insert', [UserController::class,'index2'])->name('multi-insert');
       Route::post('/submit', [UserController::class,'submit'])->name('user.submit');
       Route::delete('/delete/{id}', [UserController::class,'delete'])->name('user.delete');
       Route::delete('/delete/{Doc_NO}', [UserController::class,'delete'])->name('user.delete');
   
   
   
   
       ///PO
       Route::get('po', [UserController::class,'po'])->name('user.po');
       Route::get('/pimpo/{PO_NO}', [UserController::class,'pimpo'])->name('user.pimpo');
       Route::post('/submit2', [UserController::class,'submit2'])->name('user.submit2');
       Route::delete('/delete2/{id}', [UserController::class,'delete2'])->name('user.delete2');

       Route::get('/detroy_po/{id}', [UserController::class,'detroypo'])->name('user.detroy_po');
       
       Route::delete('/delete2/{Doc_NO}', [UserController::class,'delete2'])->name('user.delete2');
       Route::get('/editpo/{id}', [UserController::class,'editpo'])->name('user.editpo');

       Route::post('/updatepo/{id}', [UserController::class,'updatepo'])->name('user.updatepo');
   

});

Route::group(['prefix'=>'saff','middleware'=>['isSaff','auth','PreventBackHistroy']],function(){
    Route::get('dashboard', [SaffController::class,'index'])->name('saff.dashboard');
    Route::get('profile', [SaffController::class,'profile'])->name('saff.profile');
    Route::get('setting', [SaffController::class,'setting'])->name('saff.setting');
    Route::get('invoice', [SaffController::class,'invoice'])->name('saff.invoice');

    Route::get('po', [SaffController::class,'po'])->name('saff.po');
    Route::get('/pimpo/{PO_NO}', [UserController::class,'pimpo'])->name('saff.pimpo');
    Route::delete('/delete2/{id}', [SaffController::class,'delete2'])->name('saff.delete2');


    Route::post('update-profile-info',[SaffController::class,'updateInfo'])->name('saffUpdateInfo');
    Route::post('change-profile-picture',[SaffController::class,'updatePicture'])->name('saffPictureUpdate');
    Route::post('change-password',[SaffController::class,'changePassword'])->name('saffChangePassword');

});

 ///Sup
 Route::resource('supplier', SupplierContorller::class);
 Route::get('supplier', [SupplierContorller::class,'sup'])->name('supplier.index');
 Route::get('create', [SupplierContorller::class,'create'])->name('supplier.create');

 ///product
 Route::resource('product', ProductContorller::class);
 Route::get('product', [ProductContorller::class,'index'])->name('product.index');
 Route::get('create', [ProductContorller::class,'create'])->name('product.create');
 Route::post('store', [ProductContorller::class,'store'])->name('product.store');

 

///PQO
Route::resource('quotation', QuotationController::class);
Route::get('quotation', [QuotationController::class,'index'])->name('quotation.index');
Route::get('create', [QuotationController::class,'create'])->name('quotation.create');
Route::post('store', [QuotationController::class,'store'])->name('quotation.store');
Route::get('/pimquo/{id}',[QuotationController::class,'pimquo'])->name('quotation.pimquo');
Route::delete('/delete/{id}', [QuotationController::class,'delete'])->name('quotation.delete');
Route::get('/editquo/{id}', [QuotationController::class,'edit'])->name('quotation.edit');
Route::put('/update/{id}', [QuotationController::class,'update'])->name('quotation.update');


 ///Invoice
 Route::resource('invoice', InvoiceController::class);
 Route::get('invoice', [InvoiceController::class,'index'])->name('invoice.index');
 Route::get('create', [InvoiceController::class,'create'])->name('invoice.create');
 Route::post('store', [InvoiceController::class,'store'])->name('invoice.store');
 Route::get('/piminvoice/{id}',[InvoiceController::class,'piminvoice'])->name('invoice.piminvoice');
 Route::delete('/delete/{id}', [InvoiceController::class,'delete'])->name('invoice.delete');
 Route::get('/editinvoice/{id}', [InvoiceController::class,'edit'])->name('invoice.edit');
 Route::put('/update/{id}', [InvoiceController::class,'update'])->name('invoice.update');


 ///AHP
 Route::resource('ahp', AhpContorller::class);
 Route::get('ahp', [AhpController::class,'index'])->name('ahp.index');

 ///addsup
 Route::get('criteria', [AhpController::class,'criteria'])->name('ahp.criteria');
 Route::post('criteria', [AhpController::class,'criteria'])->name('ahp.criteria');
 Route::get('edit',[AhpController::class,'edit'])->name('ahp.edit');
 Route::post('edit',[AhpController::class,'edit'])->name('ahp.edit');

 
 Route::get('tambah', [AhpController::class,'tambah'])->name('ahp.tambah');
 Route::post('tambah', [AhpController::class,'tambah'])->name('ahp.tambah');
 

 Route::get('alternative', [AhpController::class,'alternative'])->name('ahp.alternative');
 Route::post('alternative', [AhpController::class,'alternative'])->name('ahp.alternative');
 

 Route::get('bobot_criteria', [AhpController::class,'bobot_criteria'])->name('ahp.bobot_criteria');
 Route::get('bobot', [AhpController::class,'bobot'])->name('ahp.bobot');
 Route::get('output', [AhpController::class,'output'])->name('ahp.output');


 Route::get('proses',[AhpController::class,'proses'])->name('ahp.proses');
 Route::post('proses',[AhpController::class,'proses'])->name('ahp.proses');


 Route::get('bobot_hasil',[AhpController::class,'bobot_hasil'])->name('ahp.bobot_hasil');
 Route::post('bobot_hasil',[AhpController::class,'bobot_hasil'])->name('ahp.bobot_hasil');


<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\Employee;
use App\Models\Exchange;
use App\Models\Installment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//Route::apiResource('cars', CarController::class);
//Route::apiResource('sales', SaleController::class);
//Route::apiResource('users', UserController::class);

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::get('/cars', [CarController::class, 'index']);
    Route::get('/cars/{car}', [CarController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'role:manager'])->group(function () {
    Route::post('/add_to_box', [BoxController::class, 'add_money_to_box'])->name('box.add');

    /******************************* user **************************************/
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::post('/block_user', [UserController::class, 'BlockUser'])->name('user.block');
    /******************************* user **************************************/

    /******************************* employee **************************************/
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::post('/store_employee', [EmployeeController::class, 'store'])->name('employee.store');
    Route::post('/delete_employee', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    /******************************* employee **************************************/


    /******************************* deal **************************************/
    Route::get('/all_deals', [DealController::class, 'index'])->name('deal.index');
    Route::get('/cash_deals', [DealController::class, 'CashDeal'])->name('cash_deal.index');
    Route::get('/installment_deals', [DealController::class, 'InstallmentDeal'])->name('installment_deal.index');
    /******************************* deal **************************************/


    /******************************* exchange **************************************/
    Route::get('/exchanges', [ExchangeController::class, 'index'])->name('exchange.index');
    Route::post('/store_exchange', [ExchangeController::class, 'store'])->name('exchange.store');
    Route::post('/update_exchange', [ExchangeController::class, 'update'])->name('exchange.update');
    Route::get('/show_exchange/{exchange_id}', [ExchangeController::class, 'show'])->name('exchange.show');
    Route::post('/delete_exchange', [ExchangeController::class, 'destroy'])->name('exchange.destroy');
    /******************************* exchange **************************************/
});
// Route::apiResource('cars', CarController::class)->except(['store', 'update', 'destroy']);
// Route::apiResource('sales', SaleController::class);

Route::middleware(['auth:sanctum', 'role:employee'])->group(function () {
    /******************************* supplier **************************************/
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/store_supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::post('/update_supplier', [SupplierController::class, 'update'])->name('supplier.update');
    Route::get('/show_supplier/{supplier_id}', [SupplierController::class, 'show'])->name('supplier.show');
    Route::post('/delete_supplier', [SupplierController::class, 'destroy'])->name('supplier.destroy');

    /******************************* supplier **************************************/


    /******************************* company **************************************/

    Route::get('/companies', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/store_company', [CompanyController::class, 'store'])->name('company.store');
    Route::post('/update_company', [CompanyController::class, 'update'])->name('company.update');
    Route::get('/show_company/{company_id}', [CompanyController::class, 'show'])->name('company.show');
    Route::post('/delete_company', [CompanyController::class, 'destroy'])->name('company.destroy');
    /******************************* company **************************************/

    /******************************* car **************************************/
    Route::get('/cars', [CarController::class, 'index'])->name('car.index');
    Route::post('/store_car', [CarController::class, 'store'])->name('car.store');
    Route::post('/pay_car_maintaince_costs', [CarController::class, 'pay_car_maintaince_costs'])->name('car.pay_maintaince');
    Route::post('/pay_car_transport_costs', [CarController::class, 'pay_car_transport_costs'])->name('car.pay_transport');
    Route::get('profits', [ProfitController::class, 'index'])->name('profit.index');
    /******************************* car **************************************/

    /******************************* deal **************************************/

    Route::post('/add_money_to_wallet', [UserController::class, 'add_money_to_wallet'])->name('user.add_money_to_wallet');
    Route::post('/create_cash_deal', [DealController::class, 'create_cash_deal'])->name('deal.create_cash_deal');
    Route::post('/pay_for_cash_deal', [DealController::class, 'pay_for_cash_deal'])->name('deal.pay_for_cash_deal');
    Route::post('/create_installment_deal', [DealController::class, 'create_installment_deal'])->name('deal.create_installment_deal');
    Route::post('/store_installment', [InstallmentController::class, 'store'])->name('installment.store');


    /******************************* deal **************************************/
});
Route::post('/user_register', [AuthController::class, 'user_register']);
Route::post('/manager_register', [AuthController::class, 'manager_register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');











// Route::post('/cars', [CarController::class, 'store']);
// Route::put('/cars/{car}', [CarController::class, 'update']);
// Route::delete('/cars/{car}', [CarController::class, 'destroy']);

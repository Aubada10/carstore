<?php

namespace App\Http\Controllers;

use App\Events\BoxEvent;
use App\Events\CompanyEvent;
use App\Events\SupplierEvent;
use App\Events\TransactionEvent;
use App\Events\WithdrawFromBoxEvent;
use App\Models\Box;
use App\Models\Car;
use App\Models\Car_Cost;
use App\Models\CarPhoto;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Profit;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function index()
    {
        return Car::with('profit')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'model' => ['required', 'string'],
            'year' => ['required', 'integer'],
            'color' => ['required', 'string'],
            'company' => ['required', 'string'],
            'plate_number' => ['required', 'string'],
            'price' => ['required'],
            'supplier_id' => ['required'],
            'profit_id' => ['required'],
            'images' => ['required'],
            'images.*' => ['image'],

        ]);
        $box = Box::first();
        if ($box->value < $request->price) {
            return response()->json([
                'message' => 'box cant afford car price'
            ]);
        }
        $supplier = Supplier::find($request->supplier_id);
        if ($request->user() instanceof Employee) {
            $car = Car::create([
                'model' => $request->model,
                'year' => $request->year,
                'color' => $request->color,
                'company' => $request->company,
                'plate_number' => $request->plate_number,
                'price' => $request->price,
                'supplier_id' => $request->supplier_id,
                'profit_id' => $request->profit_id,
                'employee_id' => $request->user()->employee_id,
            ]);
            $images = $request->file('images');
            foreach ($images as $image) {
                $image_ext =  $image->getClientOriginalExtension();
                $image_name = time() . '.' . $image_ext;
                $path = 'images/cars';
                $image->move($path, $image_name);
                CarPhoto::create([
                    'path' => $path . '/' . $image_name,
                    'car_id' => $request->car_id
                ]);
            }

            BoxEvent::dispatch($box, -$request->price);
            SupplierEvent::dispatch($supplier, $request->price);
            TransactionEvent::dispatch($car, $box->box_id);
            return response()->json([
                'data' => $car,
                'message' => 'added successfully'
            ]);
        } else {
            $car = Car::create([
                'model' => $request->model,
                'year' => $request->year,
                'color' => $request->color,
                'company' => $request->company,
                'plate_number' => $request->plate_number,
                'price' => $request->price,
                'supplier_id' => $request->supplier_id,
                'profit_id' => $request->profit_id,
            ]);
            TransactionEvent::dispatch($car);
        }
        return response()->json([
            'data' => $car,
            'message' => 'added successfully'
        ]);
    }

    public function pay_car_maintaince_costs(Request $request)
    {
        $request->validate([
            'car_id' => 'required',
            'company_id' => 'required',
            'amount' => 'required',
        ]);
        $box = Box::first();
        if ($box->value < $request->amount) {
            return response()->json([
                'message' => 'box cant afford car maintaince'
            ]);
        }
        Car_Cost::create([
            'company_id' => $request->company_id,
            'car_id' => $request->car_id,
            'type' => 'maintaince',
            'amount' => $request->amount
        ]);

        $company = Company::find($request->company_id);
        BoxEvent::dispatch($box, -$request->amount);
        CompanyEvent::dispatch($company, $box->box_id);
        TransactionEvent::dispatch($company, $box->box_id, $request->car_id, $request->amount);
        return response()->json([
            'mesage' => 'costs payed successfully'
        ]);
    }



    public function pay_car_transport_costs(Request $request)
    {
        $request->validate([
            'car_id' => 'required',
            'company_id' => 'required',
            'amount' => 'required',
        ]);
        $box = Box::first();
        if ($box->value < $request->amount) {
            return response()->json([
                'message' => 'box cant afford car transport'
            ]);
        }
        Car_Cost::create([
            'company_id' => $request->company_id,
            'car_id' => $request->car_id,
            'type' => 'transport',
            'amount' => $request->amount
        ]);

        $company = Company::find($request->company_id);
        BoxEvent::dispatch($box, -$request->amount);
        CompanyEvent::dispatch($company, $box->box_id);
        TransactionEvent::dispatch($company, $box->box_id, $request->car_id, $request->amount);
        return response()->json([
            'mesage' => 'costs payed successfully'
        ]);
    }




















    public function show(Car $car)
    {
        return $car;
    }

    public function update(Request $request, Car $car)
    {
        $this->authorizeAction('employee');
        $car->update($request->all());

        return response()->json($car, 200);
    }

    public function destroy(Car $car)
    {
        $this->authorizeAction('employee');
        $car->delete();

        return response()->json(null, 204);
    }

    private function authorizeAction($role)
    {
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized');
        }
    }
}

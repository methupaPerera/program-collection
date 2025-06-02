<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Http\Resources\v1\CustomerResource;
use App\Filters\v1\CustomerFilter;
use App\Helpers\InputDataHelper;

use App\Http\Requests\v1\StoreCustomerRequest;
use App\Http\Requests\v1\UpdateCustomerRequest;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $filter = new CustomerFilter();
        $queryItems = $filter->transform($request);
        $customers = Customer::where($queryItems);

        if ($request->query("includeInvoices")) {
            $customers = $customers->with("invoices");
        }

        return CustomerResource::collection($customers->paginate(10)->appends($request->query()));
    }

    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $data = InputDataHelper::updateWithSnakeCase($request->validated(), ["postal_code"]);
        $customer->update($data);

        return new CustomerResource($customer);
    }

    public function destroy(Customer $customer)
    {
        //
    }
}

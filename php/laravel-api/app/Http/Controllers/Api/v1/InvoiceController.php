<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Models\Invoice;
use App\Http\Resources\v1\InvoiceResource;
use App\Filters\v1\InvoiceFilter;
use App\Http\Requests\v1\BulkStoreInvoiceRequest;
use App\Http\Requests\v1\StoreInvoiceRequest;
use App\Http\Requests\v1\UpdateInvoiceRequest;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $filter = new InvoiceFilter();
        $queryItems = $filter->transform($request);
        $invoices = Invoice::where($queryItems);

        if ($request->query("includeCustomers")) {
            $invoices = $invoices->with("customer");
        }

        return InvoiceResource::collection($invoices->paginate(10)->appends($request->query()));
    }

    public function create()
    {
        //
    }

    public function store(StoreInvoiceRequest $request)
    {
        return new InvoiceResource(Invoice::create($request->validated()));
    }

    public function bulk_store(BulkStoreInvoiceRequest $request)
    {
        $bulk = collect($request->all())->map(function ($arr, $key) {
            return Arr::except($arr, ["paidDate"]);
        });

        Invoice::insert($bulk->toArray());
    }

    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    public function edit(Invoice $invoice)
    {
        //
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    public function destroy(Invoice $invoice)
    {
        //
    }
}

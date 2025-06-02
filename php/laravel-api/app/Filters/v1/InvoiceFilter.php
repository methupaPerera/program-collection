<?php

namespace App\Filters\v1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class InvoiceFilter extends ApiFilter
{
    protected $safeParams = [
        "customerId" => ["eq"],
        "amount" => ["eq", "gt", "lt", "gte", "lte"],
        "status" => ["eq", "ne"],
        "billedDate" => ["eq", "gt", "lt", "gte", "lte"],
        "paidDate" => ["eq", "gt", "lt", "gte", "lte"],
    ];

    protected $columnMap = [
        "customerId" => "customer_id",
        "billedDate" => "billed_date",
        "paidDate" => "paid_date",
    ];

    protected $operatorMap = [
        "eq" => "=",
        "gt" => ">",
        "lt" => "<",
        "lte" => "<=",
        "gte" => ">=",
        "ne" => "!=",
    ];
}

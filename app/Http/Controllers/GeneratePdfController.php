<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class GeneratePdfController extends Controller
{
    public function generateEmployeePdf(Employee $employee)
    {
        $employee = new Buyer([
            'name ar' => $employee->name_ar,
            'name en' => $employee->name_en,
            'custom_fields' => [
                'email' => $employee->email,
            ],
        ]);

        $item = InvoiceItem::make('Service 1')->pricePerUnit(2);

        $invoice = Invoice::make()
            ->buyer($employee)
            ->discountByPercent(10)
            ->taxRate(15)
            ->shipping(1.99)
            ->addItem($item);

        return $invoice->stream();
    }
}

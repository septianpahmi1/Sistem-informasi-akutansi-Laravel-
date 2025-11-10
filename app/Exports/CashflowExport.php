<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Controllers\Reports\AruskasController;

class CashflowExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $controller = new AruskasController;
        $data = $controller->getData($this->request);
        return view('admin.reports.printable.cashflow', $data->getData());
    }
}

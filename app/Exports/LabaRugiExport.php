<?php

namespace App\Exports;

use App\Http\Controllers\Reports\LabarugiController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LabaRugiExport implements FromView
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
        $controller = new LabarugiController;
        $data = $controller->getData($this->request);
        return view('admin.reports.printable.laba', $data->getData());
    }
}

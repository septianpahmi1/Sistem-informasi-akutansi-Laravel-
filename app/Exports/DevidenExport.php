<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Controllers\Reports\DevidenController;

class DevidenExport implements FromView
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
        $controller = new DevidenController;
        $data = $controller->getData($this->request);
        return view('admin.reports.printable.deviden', $data->getData());
    }
}

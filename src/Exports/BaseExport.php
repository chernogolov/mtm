<?php

namespace Chernogolov\Mtm\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BaseExport implements FromView
{
    protected $prefix;
    protected $resource;
    protected $data;

    public function __construct($prefix, $resource, $data)
    {
        $this->prefix = $prefix;
        $this->resource = $resource;
        $this->data = $data;
    }

    public function view(): View
    {
        $view = $this->prefix . '.export';
        if(!view()->exists($view)){
            $view = 'mtm::crud_base.export';
        }
        return view($view, [
            'res' => $this->resource,
            'data' => $this->data
        ]);
    }
}

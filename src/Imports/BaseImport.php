<?php

namespace Chernogolov\Mtm\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BaseImport implements ToModel, WithHeadingRow
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

    public function model(array $row)
    {
        $model = 'App\Models\\' . $this->resource->model_name;
        if(isset($row['id']))
        {
            $m = $model::where('id', $row['id'])->first();
            if($m)
            {
                foreach ($m->toArray() as $key => $value)
                    if(isset($row[$key]))
                        $m->$key = $row[$key];
            }
            else
            {
//            $m = new $model([
//
//            ]);
            }
        }

        return $m;
    }
}

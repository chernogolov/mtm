<?php

namespace Chernogolov\Mtm\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
//use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class BaseImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas, WithChunkReading
{
    protected $prefix;
    protected $resource;
    protected $data;
    protected $i = 0;
    protected $unique_fields = 'id';
    public $result;


    public function __construct($prefix, $resource, $data)
    {
        $this->prefix = $prefix;
        $this->resource = $resource;
        $this->data = $data;
        if(isset($this->resource->unique_fields) && $this->resource->unique_fields)
            $this->unique_fields = $this->resource->unique_fields;
    }

    public function collection(Collection $rows)
    {

        $model = 'App\Models\\' . $this->resource->model_name;
        $m = new $model();
        $tableName = $m->getTable();
        $columns = Schema::getColumnListing($tableName);
        $i = 0;

        foreach ($rows as $row)
        {
            foreach ($columns as $column_name)
            {
                if(isset($row[$column_name]))
                {
                    $this->result[$i][$column_name] = $row[$column_name];
                }
            }


            $i++;
        }

        foreach ($this->result as $item)
        {
            $result = $m::updateOrCreate(
                $item,
                [$this->unique_fields => $item[$this->unique_fields]]
            );
        }
    }


//    public function batchSize(): int
//    {
//        return 1000;
//    }

    public function chunkSize(): int
    {
        return 500;
    }
}

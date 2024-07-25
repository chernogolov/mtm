<?php

namespace Chernogolov\Mtm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'one_name', 'route_prefix', 'view_prefix', 'model_name', 'editable_fields', 'catalog_fields', 'fields', 'template', 'form_fields', 'api_fields','view_fields','export_fields'
    ];

    public function getFieldsAttribute($value)
    {
        return json_decode($value);
    }

    public function setFieldsAttribute($value)
    {
        $this->attributes['fields'] = json_encode($value);
    }

    public function getTemplateAttribute($value)
    {
        return json_decode($value);
    }

    public function setTemplateAttribute($value)
    {
        $this->attributes['template'] = json_encode($value);
    }

    public function getEditableFieldsAttribute($value)
    {
        return $value;
    }

    public function setEditableFieldsAttribute($value)
    {
        $this->attributes['editable_fields'] = $value;
    }

    public function getCatalogFieldsAttribute($value)
    {
        return $value;
    }

    public function setCatalogFieldsAttribute($value)
    {
        $this->attributes['catalog_fields'] = $value;
    }

}

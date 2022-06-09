<?php

namespace App\Models;

use App\Constants\SettingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = ['key', 'value', 'content_type_id', 'system'];

    public $timestamps = false;

    public function contentType()
    {
        return $this->belongsTo(ContentType::class, 'content_type_id', 'id');
    }

    public function value()
    {
        return SettingType::displatHtmlHandler($this->content_type_id, $this->value);
    }

    public function getDataHtml()
    {
        return SettingType::displatHtmlHandler($this->content_type_id, $this->value);
    }
}

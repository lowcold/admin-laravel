<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminRule extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $dateFormat = 'U';
    protected $fillable = [
        'pid', 'sort', 'title', 'name', 'path', 'component', 'icon', 'admin', 'show', 'menu', 'layout'
    ];

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

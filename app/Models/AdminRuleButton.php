<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminRuleButton extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $dateFormat = 'U';
    protected $fillable = [
        'rule_id', 'title', 'icon', 'component', 'admin', 'show', 'type'
    ];

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

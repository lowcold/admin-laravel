<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use lowcold\ClosureTable\ClosureTable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable implements JWTSubject
{
    use SoftDeletes, HasFactory, Notifiable, ClosureTable;

    // 定义上级字段
    const parent = 'parent';
    // 定义关联表
    const closure = 'member_closure';

    protected $dateFormat = 'U';

    /**
     * 显示字段
     */
    protected $fillable = [
        'uid',
        'gid',
        'parent',
        'password',
        'username',
        'nikename',
        'realname',
        'money',
        'integral',
        'consume',
        'direct_kpi',
        'team_kpi'
    ];

    /**
     * 隐藏字段
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

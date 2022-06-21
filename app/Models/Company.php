<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';

    // timestampの自動更新をfalseにする
    public $timestamps = false;

    protected $fillable = [
        'company_code',
        'company_name',
        'user_id',
        'email',
        'telno',
        'faxno',
        'zipcode',
        'pref',
        'address1',
        'address2',
        'plan_type',
        'register_ymd',
        'unsubscribe_ymd',
        'invitor_name'
    ];
}

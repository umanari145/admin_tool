<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanTerminal extends Model
{
    use HasFactory;

    protected $table = 'scan_terminal';

    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'name',
        'mac_address'
    ];
}

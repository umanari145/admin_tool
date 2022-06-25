<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public static function getScanTerminalList(array $requestData = null)
    {
        $scan_terminals = self::with('company');

        if (!empty($requestData['company_id'])) {
            $scan_terminals->where('company_id', $requestData['company_id']);
        }

        return $scan_terminals;
    }
}

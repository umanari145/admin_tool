<?php

namespace App\Constant;

use BenSampo\Enum\Enum;

class ConfigConst extends Enum
{
    /** SERVICE のレスポンスコード **/
    public const SERVICE_SUCCESS = 1;
    public const SERVICE_ERROR = 99;

    /** CSVカテゴリーコード **/
    public const CSV_PRODUCT_MASTER_UPLOAD = 10;
    public const CSV_PRODUCT_MASTER_DOWNLOAD = 20;
}
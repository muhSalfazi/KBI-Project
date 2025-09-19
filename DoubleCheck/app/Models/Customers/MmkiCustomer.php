<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;

class MmkiCustomer extends BaseCustomer
{
    public function getTableName(): string
    {
        return 'tbl_deliverynote';
    }

    public function getLogChannel(): string
    {
        return 'mmki_log';
    }

    public function getTableMasterparts(): string
    {
        return 'masterpart_mmki';
    }

    public function vwTblData(): string
    {
        return 'vw_data_mmki';
    }

    public function vwTblKbn(): string
    {
        return 'vw_kbndelivery_mmki';
    }

    public function getReduction()
    {
        return 10; //panjang dn/manifest
    }
}

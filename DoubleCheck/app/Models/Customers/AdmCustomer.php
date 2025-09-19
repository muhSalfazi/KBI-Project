<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;

class AdmCustomer extends BaseCustomer
{
    /**
     * Get the table name associated with the model.
     *
     * @return string
     */
    public function getTableName(): string
    {
        return 'tbl_deliveryadm';
    }

    /**
     * Get the log channel for the model.
     *
     * @return string
     */
    protected function getLogChannel(): string
    {
        return 'adm_log';
    }

    public function getTableMasterparts(): string
    {
        return 'masterpart_adm';
    }

    public function vwTblData(): string
    {
        return 'vw_data_adm';
    }

    public function vwTblKbn(): string
    {
        return 'vw_kbndelivery_adm';
    }

    public function getReduction()
    {
        return 16; //panjang dn ADM
    }
}

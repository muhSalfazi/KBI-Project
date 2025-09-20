<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            'PT. ASTRA DAIHATSU MOTOR',
            'PT. HINO MOTORS MANUFACTURING INDONESIA',
            'PT. HONDA PROSPECT MOTOR',
            'PT. ISUZU ASTRA MOTOR INDONESIA',
            'PT. KRAMA YUDHA TIGA BERLIANMOTORS',
            'PT. MITSUBISHI MOTORS KRAMA YUDHA INDONESIA',
            'PT. MITSUBISHI MOTORS KRAMA YUDHA SALES INDONESIA',
            'PT. SUZUKI INDOMOBIL SALES',
        ];
        $usernames = [
            'ADM',
            'HMMI',
            'HPM',
            'ISUZU',
            'KTB',
            'MMKI',
            'MMKSI',
            'SUZUKI',
        ];

        foreach ($customers as $index => $customer) {
            Customer::create([
                'name' => $customer,
                'username' => $usernames[$index]
            ]);
        }
    }
}

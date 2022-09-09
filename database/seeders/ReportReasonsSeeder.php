<?php

namespace Database\Seeders;

use App\Models\ReportReason;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!ReportReason::exists()){
            DB::table('report_reasons')->insert([
               [
                   'reason' => 'Abuse'
               ],
               [
                   'reason' => 'Other'
               ]
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shops = array(
            array('id' => '1','type' => 'SuperLike','quantity' => '10','price' => '100.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '2','type' => 'SuperLike','quantity' => '20','price' => '150.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '3','type' => 'SuperLike','quantity' => '40','price' => '200.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '4','type' => 'SuperLike','quantity' => '50','price' => '250.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '5','type' => 'SuperLike','quantity' => '100','price' => '300.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2022-02-24 08:20:38'),
            array('id' => '6','type' => 'Favorite','quantity' => '10','price' => '10.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '7','type' => 'Favorite','quantity' => '20','price' => '15.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '8','type' => 'Favorite','quantity' => '50','price' => '25.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '9','type' => 'Favorite','quantity' => '100','price' => '40.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '10','type' => 'Favorite','quantity' => '200','price' => '80.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '11','type' => 'Photo','quantity' => '1','price' => '100.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '12','type' => 'Photo','quantity' => '2','price' => '150.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '13','type' => 'Photo','quantity' => '5','price' => '200.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '14','type' => 'Photo','quantity' => '8','price' => '250.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '15','type' => 'Photo','quantity' => '10','price' => '300.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '16','type' => 'Video','quantity' => '1','price' => '100.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2022-02-24 08:42:41'),
            array('id' => '17','type' => 'Video','quantity' => '1','price' => '150.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2022-02-24 08:42:41'),
            array('id' => '18','type' => 'Video','quantity' => '20','price' => '200.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2022-02-23 10:20:29'),
            array('id' => '19','type' => 'Video','quantity' => '25','price' => '250.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2022-02-23 10:20:30'),
            array('id' => '20','type' => 'Video','quantity' => '30','price' => '300.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2022-02-23 10:20:30'),
            array('id' => '21','type' => 'Like','quantity' => '100','price' => '150.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2022-02-24 08:21:13'),
            array('id' => '22','type' => 'Like','quantity' => '150','price' => '200.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2022-02-24 08:21:13'),
            array('id' => '23','type' => 'Like','quantity' => '200','price' => '250.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '24','type' => 'Like','quantity' => '250','price' => '300.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '25','type' => 'Like','quantity' => '300','price' => '350.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2022-02-09 18:16:51'),
            array('id' => '26','type' => 'Call','quantity' => '10','price' => '100.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2022-02-24 08:47:31'),
            array('id' => '27','type' => 'Call','quantity' => '20','price' => '150.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '28','type' => 'Call','quantity' => '30','price' => '220.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2021-12-08 08:23:03'),
            array('id' => '29','type' => 'Call','quantity' => '40','price' => '250.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '30','type' => 'Call','quantity' => '60','price' => '350.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2021-12-08 08:24:47'),
            array('id' => '31','type' => 'VIP','quantity' => '1','price' => '100.00','is_active' => '1','package_id' => 'com.twoagainaps.vip1month','created_at' => NULL,'updated_at' => NULL),
            array('id' => '32','type' => 'VIP','quantity' => '3','price' => '250.00','is_active' => '1','package_id' => 'com.twoagainaps.vip3month','created_at' => NULL,'updated_at' => NULL),
            array('id' => '33','type' => 'VIP','quantity' => '6','price' => '400.00','is_active' => '1','package_id' => 'com.twoagainaps.vip6month','created_at' => NULL,'updated_at' => NULL),
            array('id' => '34','type' => 'VIP','quantity' => '12','price' => '700.00','is_active' => '1','package_id' => 'com.twoagainaps.vip12month','created_at' => NULL,'updated_at' => NULL),
            array('id' => '35','type' => 'BS','quantity' => '1','price' => '200.00','is_active' => '1','package_id' => 'com.twoagainaps.bigspender1month','created_at' => NULL,'updated_at' => NULL),
            array('id' => '36','type' => 'BS','quantity' => '3','price' => '400.00','is_active' => '1','package_id' => 'com.twoagainaps.bigspender3month','created_at' => NULL,'updated_at' => NULL),
            array('id' => '37','type' => 'BS','quantity' => '6','price' => '800.00','is_active' => '1','package_id' => 'com.twoagainaps.bigspender6month','created_at' => NULL,'updated_at' => NULL),
            array('id' => '38','type' => 'BS','quantity' => '12','price' => '1900.00','is_active' => '1','package_id' => 'com.twoagainaps.bigspender12month','created_at' => NULL,'updated_at' => NULL),
            array('id' => '39','type' => 'Gold','quantity' => '200','price' => '100.00','is_active' => '1','package_id' => 'com.twoagainaps.goldcoin1package','created_at' => NULL,'updated_at' => '2022-02-22 11:35:08'),
            array('id' => '40','type' => 'Gold','quantity' => '500','price' => '400.00','is_active' => '1','package_id' => 'com.twoagainaps.goldcoin2package','created_at' => NULL,'updated_at' => NULL),
            array('id' => '41','type' => 'Gold','quantity' => '1000','price' => '500.00','is_active' => '1','package_id' => 'com.twoagainaps.goldcoin3package','created_at' => NULL,'updated_at' => NULL),
            array('id' => '42','type' => 'Gold','quantity' => '2000','price' => '1000.00','is_active' => '1','package_id' => 'com.twoagainaps.goldcoin4package','created_at' => NULL,'updated_at' => NULL),
            array('id' => '43','type' => 'Gold','quantity' => '5000','price' => '2000.00','is_active' => '1','package_id' => 'com.twoagainaps.goldcoin5package','created_at' => NULL,'updated_at' => NULL),
            array('id' => '44','type' => 'Gold','quantity' => '8000','price' => '3000.00','is_active' => '1','package_id' => 'com.twoagainaps.goldcoin6package','created_at' => NULL,'updated_at' => NULL),
            array('id' => '45','type' => 'Gold','quantity' => '10000','price' => '4000.00','is_active' => '1','package_id' => 'com.twoagainaps.goldcoin7package','created_at' => NULL,'updated_at' => NULL),
            array('id' => '46','type' => 'Gold','quantity' => '15000','price' => '5000.00','is_active' => '1','package_id' => 'com.twoagainaps.goldcoin8package','created_at' => NULL,'updated_at' => NULL),
            array('id' => '47','type' => 'Gold','quantity' => '25000','price' => '8000.00','is_active' => '1','package_id' => 'com.twoagainaps.goldcoin9package','created_at' => NULL,'updated_at' => NULL),
            array('id' => '48','type' => 'Gold','quantity' => '50000','price' => '9999.99','is_active' => '1','package_id' => 'com.twoagainaps.goldcoin10package','created_at' => NULL,'updated_at' => NULL),
            array('id' => '49','type' => 'Boost','quantity' => '1','price' => '100.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => '2022-02-24 08:50:12'),
            array('id' => '50','type' => 'Boost','quantity' => '30','price' => '200.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '51','type' => 'Boost','quantity' => '60','price' => '300.00','is_active' => '1','package_id' => '0','created_at' => NULL,'updated_at' => NULL),
            array('id' => '53','type' => 'SuperLike','quantity' => '200','price' => '350.00','is_active' => '1','package_id' => '0','created_at' => '2022-02-22 13:55:46','updated_at' => '2022-02-24 08:20:39')
          );

          if(!Shop::exists()){
            DB::table('shops')->insert($shops);
          }
    }
}

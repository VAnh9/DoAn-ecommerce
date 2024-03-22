<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorShopProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'vendor@gmail.com')->first();

        $vendor = new Vendor();
        $vendor->banner = 'uploads/123.jpg';
        $vendor->name = 'Vendor Shop';
        $vendor->phone = '123782957';
        $vendor->email = 'vendorshop@gmail.com';
        $vendor->address = '255 Street, USA';
        $vendor->description = 'vendor shop descritpion';
        $vendor->user_id = $user->id;
        $vendor->save();
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminVendorProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@gmail.com')->first();

        $vendor = new Vendor();
        $vendor->banner = 'uploads/123.jpg';
        $vendor->name = 'Admin Vendor Shop';
        $vendor->phone = '123787';
        $vendor->email = 'advendorshop@gmail.com';
        $vendor->address = '212 Street, USA';
        $vendor->description = 'shop descritpion';
        $vendor->user_id = $user->id;
        $vendor->save();
    }
}

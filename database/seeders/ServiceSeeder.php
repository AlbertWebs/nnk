<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            'Welfare Fund',
            'Normal /Development Loan',
            'Refinancing Loan',
            'School Fees Loan',
            'Emergency Loan',
            'Holiday Loan'
        ];

        foreach ($services as $title) {
            Service::create([
                'title' => $title,
                'slung' => Str::slug($title),
                'description' => 'This is a sample description for ' . $title . '.',
                'image' => 'default.jpg', // You can update this as needed
            ]);
        }
    }
}

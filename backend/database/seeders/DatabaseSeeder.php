<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organization::factory()->create([
            'name' => 'PulseDesk Demo',
            'slug' => 'pulsedesk-demo',
        ]);

        User::factory()->withOrganization($org)->create([
            'name' => 'Admin User',
            'email' => 'admin@pulsedesk.test',
            'password' => Hash::make('password'),
        ]);

        User::factory()->count(2)->withOrganization($org)->create();
    }
}

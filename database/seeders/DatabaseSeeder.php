<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin'
        ]);
        User::factory()->create([
            'name' => 'Guru',
            'email' => 'guru@gmail.com',
            'role' => 'guru'
        ]);
        Kelas::create([
            'nama' => "12 IPS 2",
            'guru_id' => 2,
        ]);
        
        User::factory()->create([
            'name' => 'Budi',
            'email' => 'siswa@gmail.com',
            'role' => 'siswa',
            'kelas_id' => 1
        ]);
        User::factory(5)->create(['kelas_id'=>1]);
    }
}

    <?php

namespace\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $roles = [
            'Admin',
            'Pegawai',
            'Kepala Bidang P2M',
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role],
                [
                    'name' => $role,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Role Admin
        |--------------------------------------------------------------------------
        */

        $adminRoleId = DB::table('roles')
            ->where('name', 'Admin')
            ->value('id');

        /*
        |--------------------------------------------------------------------------
        | Default Admin User
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            ['email' => 'admin@siparama.web.id'],
            [
                'username' => 'admin@siparama.web.id',
                'password' => Hash::make('adminsiparama@'),
                'email_verified_at' => now(),
                'role_id' => $adminRoleId,
                'status' => 'Aktif',
            ]
        );
    }
}

<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'description' => 'De admin is de beheerder of het systeem',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Webmaster',
                'description' => 'De webmaster mag gebruikers toevoegen die gespecificeerd zijn.',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Verzekering',
                'description' => 'Het toevoegen van gebruikers en ziekenhuizen.',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Ziekenhuis',
                'description' => 'Het maken van rapportage.',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Specialist',
                'description' => 'Het toevoegen van medicijnen en medicaties.',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Huisarts',
                'description' => 'Het toevoegen van medicijnen en medicaties.',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Verpleegkundige',
                'description' => 'Het behandelen van patiënten via de app.',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Gebruiker',
                'description' => 'Het inzien van haar eigen gegevens.',
                'created_at' => Carbon::now(),
            ],
        ]);

        DB::table('role_user')->insert([
            [
                'role_id' => 1,
                'user_id' => 1,
            ]
        ]);
    }
}

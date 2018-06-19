<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'Name' => 'Registreer'
            ],
            [
                'Name' => 'Rollen'
            ],
            [
                'Name' => 'Permissies'
            ],
            [
                'Name' => 'Rapportages'
            ],
            [
                'Name' => 'Behandelingen'
            ],
            [
                'Name' => 'Consult'
            ],
            [
                'Name' => 'Medicijnen'
            ],
            [
                'Name' => 'Aandoeningen'
            ],
            [
                'Name' => 'Verzekerden'
            ],
            [
                'Name' => 'Behandelden'
            ],
            [
                'Name' => 'Rapport'
            ],
            [
                'Name' => 'Groepen'
            ],
            [
                'Name' => 'Koppelen'
            ],
            [
                'Name' => 'Agenda'
            ],
            [
                'Name' => 'Statistieken'
            ],
            [
                'Name' => 'Beeldbank'
            ]
        ]);
    }
}

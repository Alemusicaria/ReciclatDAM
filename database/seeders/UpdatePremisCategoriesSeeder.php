<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdatePremisCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mapeig de premios a categories
        $premisActualizar = [
            11 => ['categoria' => 'electrònica', 'stock' => 8, 'temps_enviament' => '3-5 dies', 'rating' => 4.5],
            12 => ['categoria' => 'transport', 'stock' => 3, 'temps_enviament' => '7-10 dies', 'rating' => 4.8],
            13 => ['categoria' => 'transport', 'stock' => 12, 'temps_enviament' => '2-3 dies', 'rating' => 4.6],
            14 => ['categoria' => 'transport', 'stock' => 2, 'temps_enviament' => '10-14 dies', 'rating' => 4.9],
            15 => ['categoria' => 'accessoris', 'stock' => 20, 'temps_enviament' => '1-2 dies', 'rating' => 4.4],
            16 => ['categoria' => 'accessoris', 'stock' => 5, 'temps_enviament' => '3-5 dies', 'rating' => 3.8],
            17 => ['categoria' => 'esports', 'stock' => 6, 'temps_enviament' => '2-4 dies', 'rating' => 4.2],
        ];

        foreach ($premisActualizar as $id => $data) {
            DB::table('premis')
                ->where('id', $id)
                ->update($data);
        }

        // Agregar més opiniones de prueba
        $opinionsAddicionals = [
            [
                'autor' => 'Albert N.',
                'comentari' => 'Perfecte! El servei és ràpid i eficient. Molt satisfet amb la meva compra!',
                'estrelles' => 4.5,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'autor' => 'Sílvia T.',
                'comentari' => 'Un programa genial. Estic molt orgullós de contribuir al reciclatge!',
                'estrelles' => 5.0,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'autor' => 'Josep M.',
                'comentari' => 'Moltes gràcies! Els premios són d\'alta qualitat i valia totalment la pena.',
                'estrelles' => 4.8,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
            [
                'autor' => 'Carme B.',
                'comentari' => 'Fantàstic programa! Faré reciclatge per anys més gràcies a vosaltres.',
                'estrelles' => 4.7,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'autor' => 'Miquel P.',
                'comentari' => 'Excelent atenció al client i productes de qualitat. Altament recomanat!',
                'estrelles' => 4.9,
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(12),
            ],
            [
                'autor' => 'Núria R.',
                'comentari' => 'Els meus fills adoren els premios que he rebut. Moltes gràcies!',
                'estrelles' => 4.6,
                'created_at' => now()->subDays(14),
                'updated_at' => now()->subDays(14),
            ],
            [
                'autor' => 'David S.',
                'comentari' => 'Un programa innovador que fa que reciclar sigui divertit i gratificant.',
                'estrelles' => 4.8,
                'created_at' => now()->subDays(16),
                'updated_at' => now()->subDays(16),
            ],
            [
                'autor' => 'Esther L.',
                'comentari' => 'Els premios arriben a temps i en perfecte estat. Estoy molt satisfeta!',
                'estrelles' => 4.7,
                'created_at' => now()->subDays(18),
                'updated_at' => now()->subDays(18),
            ],
            [
                'autor' => 'Marc G.',
                'comentari' => 'Increïble! La millor manera de contribuir al medi ambient.',
                'estrelles' => 4.9,
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(20),
            ],
            [
                'autor' => 'Miriam T.',
                'comentari' => 'Recomano aquest programa a tots els meus amics. Val totalment la pena!',
                'estrelles' => 4.8,
                'created_at' => now()->subDays(22),
                'updated_at' => now()->subDays(22),
            ],
        ];

        foreach ($opinionsAddicionals as $opinion) {
            DB::table('opinions')->updateOrInsert(
                ['autor' => $opinion['autor']],
                $opinion
            );
        }

        $this->command->info('Premios y opiniones actualizados correctamente! ✅');
    }
}


<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Premi;
use App\Models\Opinions;

class SyncAlgoliaIndices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-algolia-indices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronitza els índexs de Premis i Opinions a Algolia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Sincronitzant índexs de Algolia...');

        try {
            $this->info('📦 Sincronitzant Premios...');
            Premi::query()->searchable();
            $this->info('✅ Premios sincronitzats correctament');

            $this->info('💬 Sincronitzant Opinions...');
            Opinions::query()->searchable();
            $this->info('✅ Opinions sincronitzades correctament');

            $this->info('🎉 Tots els índexs han estat sincronitzats correctament!');
        } catch (\Exception $e) {
            $this->error('Error sincronitzant índexs: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}


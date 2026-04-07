<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class CheckTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:check {--base=ca : Base locale to compare against}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks missing translation keys across ca/es/en messages files';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $locales = ['ca', 'es', 'en'];
        $base = (string) $this->option('base');

        if (!in_array($base, $locales, true)) {
            $this->error("Base locale '{$base}' is not supported. Use: ca, es, en.");
            return self::FAILURE;
        }

        $translations = [];
        foreach ($locales as $locale) {
            $file = lang_path("{$locale}/messages.php");
            if (!file_exists($file)) {
                $this->error("Missing file: {$file}");
                return self::FAILURE;
            }

            $content = include $file;
            if (!is_array($content)) {
                $this->error("Invalid translation file: {$file}");
                return self::FAILURE;
            }

            $translations[$locale] = Arr::dot($content);
        }

        $baseKeys = array_keys($translations[$base]);
        sort($baseKeys);

        $hasIssues = false;
        foreach ($locales as $locale) {
            if ($locale === $base) {
                continue;
            }

            $targetKeys = array_keys($translations[$locale]);
            sort($targetKeys);

            $missing = array_values(array_diff($baseKeys, $targetKeys));
            $extra = array_values(array_diff($targetKeys, $baseKeys));

            if ($missing || $extra) {
                $hasIssues = true;
                $this->newLine();
                $this->warn("Locale '{$locale}' differences against base '{$base}':");

                if ($missing) {
                    $this->line('  Missing keys:');
                    foreach ($missing as $key) {
                        $this->line("    - {$key}");
                    }
                }

                if ($extra) {
                    $this->line('  Extra keys:');
                    foreach ($extra as $key) {
                        $this->line("    - {$key}");
                    }
                }
            }
        }

        if ($hasIssues) {
            $this->newLine();
            $this->error('Translation key mismatches found.');
            return self::FAILURE;
        }

        $this->info("All translation keys are aligned for locales: " . implode(', ', $locales));
        return self::SUCCESS;
    }
}

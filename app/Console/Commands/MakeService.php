<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * Nama command yang akan diketik di terminal
     */
    protected $signature = 'make:service {name}';

    /**
     * Deskripsi command
     */
    protected $description = 'Create a new Service class';

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Services/{$name}.php");

        // Buat folder Services jika belum ada
        if (!File::exists(app_path('Services'))) {
            File::makeDirectory(app_path('Services'));
        }

        if (File::exists($path)) {
            $this->error("Service {$name} already exists!");
            return;
        }

        // Template dasar/stub untuk class Service
        $stub = <<<EOT
<?php

namespace App\Services;

class {$name}
{
    public function __construct()
    {
        // 
    }
}
EOT;

        File::put($path, $stub);
        $this->info("Service {$name} created successfully.");
    }
}
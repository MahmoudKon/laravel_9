<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new blade template.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $view = $this->argument('view');

        $path = $this->viewPath($view);

        $this->createDir($path);

        if (File::exists($path))
        {
            $this->error("File {$path} already exists!");
            return;
        }

        File::put($path, $this->appendText());

        $this->line('<bg=green;fg=white;options=bold>View</> Created Successfully!');
    }

    /**
     * Get the view full path.
     *
     * @param string $view
     *
     * to replace . to / => [backend.clients.form => backend/clients/form]
     *
     * @return string
     */
    public function viewPath($view)
    {
        $view = str_replace('.', '/', $view) . '.blade.php';

        $path = "resources/views/{$view}";

        return $path;
    }

    /**
     * Create view directory if not exists.
     *
     * @param $path
     */
    public function createDir($path)
    {
        $dir = dirname($path);

        if (!file_exists($dir))
        {
            mkdir($dir, 0777, true);
        }
    }

    public function appendText()
    {
        return "@push('style') \n {{-- CSS Style --}} \n @endpush \n\n <div class='row'> \n {{-- HTML Code --}} \n </div> \n\n @push('script') \n {{-- JS Code --}} \n @endpush";
    }
}

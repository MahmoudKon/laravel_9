<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class CreateServiceClass extends GeneratorCommand
{
/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name} {model?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To create service class for model';

    protected $type = 'class';

    protected function getStub()
    {
        return  base_path() . '/stubs/service.stub';
    }

    /**
     * The root location where your new file should
     * be written to.
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Services';
    }

    public function handle()
    {
        if ($this->isReservedName($this->getNameInput())) {
            $this->error('The name "'.$this->getNameInput().'" is reserved by PHP.');
            return false;
        }

        $name = $this->qualifyClass($this->getNameInput());
        $model = $this->argument('model')
                    ? $this->qualifyClass(trim($this->argument('model')))
                    : $this->qualifyModel($this->getNameInput());


        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');
            return false;
        }

        $this->makeDirectory($path);
        $this->files->put($path, $this->getSourceFile($name, $model));
        $this->info($this->type.' created successfully.');

        if (in_array(CreatesMatchingTest::class, class_uses_recursive($this))) {
            $this->handleTestCreation($path);
        }
    }

    private function getSourceFile($class, $model)
    {
        $service = ucwords($this->getNameInput());
        $service = stripos($service, 'Service') !== false ? $service : $service . 'Service';
        $vars = [
            '{{ namespace }}' => $class,
            '{{ class }}' => $service,
            '{{ modelNamespace }}' => $model,
            '{{ model }}' => last(explode('\\', $model)),
        ];

        return $this->getStubContent($this->getStub(), $vars);
    }

    private function getStubContent($stub, $stub_vars = [])
    {
        $content  = file_get_contents($stub);

        foreach ($stub_vars as $name => $value)
        {
            $content = str_replace($name, $value, $content);
        }

        return $content;
    }
}

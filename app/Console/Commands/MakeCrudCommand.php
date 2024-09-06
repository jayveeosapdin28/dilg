<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;

class MakeCrudCommand extends Command
{
    protected $signature = 'make:crud {name}';
    protected $description = 'Make an Interface, Repository, Model and Migration file';
    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle()
    {
        $this->generateModel();
        $this->generateController();
        Artisan::call('make:request '.$this->argument('name').'/Store'.$this->argument('name').'Request');
        Artisan::call('make:request '.$this->argument('name').'/Update'.$this->argument('name').'Request');
        Artisan::call('make:migration '.$this->generateMigrationName().' --create='.strtolower(Pluralizer::plural($this->argument('name'))));
        $this->generateIndex();
        $this->generateForm();
    }

    public function generateMigrationName(){
        return 'create_'.strtolower(Pluralizer::plural($this->argument('name'))).'_table';
    }

    public function generateModel()
    {
        $this->createModelFromStub('model');
        $this->createModelFromStub('scope');
        $this->createModelFromStub('relation');
    }

    public function generateController()
    {
        $this->createControllerFromStub('controller');
    }
    public function generateIndex()
    {
        $this->createIndexFromStub('index');
    }
    public function generateForm()
    {
        $this->createFormFromStub('form');
    }

    public function createModelFromStub($stub)
    {
        $path = $this->getModelSourceFilePath(ucwords(Pluralizer::plural($stub)));
        $this->generateFile($path, $stub);
    }

    public function createControllerFromStub($stub)
    {
        $path = $this->getPageControllerSourceFilePath(ucwords(Pluralizer::plural($stub)));
        $this->generateFile($path, $stub);
    }

    public function createIndexFromStub($stub)
    {
        $path = $this->getPageIndexSourceFilePath();
        $this->generateFile($path, $stub);
    }
    public function createFormFromStub($stub)
    {
        $path = $this->getPageFormSourceFilePath();
        $this->generateFile($path, $stub);
    }

    public function createStub($stub)
    {
        $path = $this->getSourceFilePath(ucwords(Pluralizer::plural($stub)));
        $this->generateFile($path, $stub);
    }

    public function generateFile($path, $stub)
    {
        $this->makeDirectory(dirname($path));
        $contents = $this->getSourceFile($stub);
        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

    public function getStubPath($stub_name): string
    {
        return __DIR__ . '/../../../stubs/custom/' . $stub_name . '.stub';
    }

    public function getStubVariables($namespace): array
    {
        return [
            'NAMESPACE' => 'App\\' . ucwords(Pluralizer::plural($namespace)) . '\\' . $this->getSingularClassName($this->argument('name')),
            'CLASS_NAME' => $this->getSingularClassName($this->argument('name')),
            'CLASS_NAME_LOWER' => strtolower(Pluralizer::singular($this->argument('name'))),
        ];
    }

    public function getSourceFile($stub_name): bool|array|string
    {
        return $this->getStubContents($this->getStubPath($stub_name), $this->getStubVariables($stub_name));
    }

    public function getStubContents($stub, $stubVariables = []): array|bool|string
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;

    }

    public function getSourceFilePath($string): string
    {
        if($string == ucwords(Pluralizer::plural('interface'))){
            return base_path('App\\' . ucwords(Pluralizer::plural($string))) . '\\' . $this->getSingularClassName($this->argument('name')) . '\\' . $this->getSingularClassName($this->argument('name')) .'Repository'. ucwords(Pluralizer::singular($string)) . '.php';
        }
        return base_path('App\\' . ucwords(Pluralizer::plural($string))) . '\\' . $this->getSingularClassName($this->argument('name')) . '\\' . $this->getSingularClassName($this->argument('name')) . ucwords(Pluralizer::singular($string)) . '.php';
    }

    public function getModelSourceFilePath($string): string
    {
        if ($string != ucwords(Pluralizer::plural('model'))) {
            return base_path('App\\Models\\' . $this->getSingularClassName($this->argument('name')) . '\\' . ucwords(Pluralizer::plural($string)) . '\\' . $this->getSingularClassName($this->argument('name')) . ucwords(Pluralizer::singular($string))) . '.php';
        }
        return base_path('App\\' . ucwords(Pluralizer::plural($string))) . '\\' . $this->getSingularClassName($this->argument('name')) . '\\' . $this->getSingularClassName($this->argument('name')) . '.php';
    }

    public function getPageControllerSourceFilePath($string): string
    {
        return base_path('App\\HTTP\\'.$string.'\\V1\\' . $this->getSingularClassName($this->argument('name')).'\\'.$this->getSingularClassName($this->argument('name'))) . 'Controller.php';
    }
    public function getPageIndexSourceFilePath(): string
    {
//        resources/js/Pages/Document/Index.vue
        return base_path('resources\\js\\Pages\\' . $this->getSingularClassName($this->argument('name')).'\\') . 'Index.vue';
    }
    public function getPageFormSourceFilePath(): string
    {
        return base_path('resources\\js\\Pages\\' . $this->getSingularClassName($this->argument('name')).'\\') .  $this->getSingularClassName($this->argument('name')).'Form.vue';
    }

    public function getSingularClassName($name): string
    {
        return ucwords(Pluralizer::singular($name));
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}

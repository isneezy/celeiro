<?php

namespace Isneezy\Celeiro\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;


class RepositoryGeneratorCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:repository {repo}{--model=null}';

    /**
     * @var string
     */
    protected $description = "Generate a new repository given a Model name";


    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;


    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }


    public function handle()
    {
        $repositoryName = ucfirst($this->argument('repo'));
        $modelNameRaw= $this->option('model');
        $namespace = "App";
        if($modelNameRaw != null && $modelNameRaw != 'null'){
            $modelName = ucfirst($modelNameRaw);
            $namespace = 'App\\'.str_replace('/','\\',$modelName);
            $pieces = explode("/", $modelName);
            $modelName = ucfirst($pieces[sizeof($pieces) - 1]) . '::class';
        }


        echo $pieces [sizeof($pieces) - 1];

        $defaultDir = base_path() . "/app/Repositories";


        if(!is_dir($defaultDir)){
            mkdir($defaultDir, 0755);
        }

        $destinationFileName = $defaultDir . '/'.$repositoryName . '.php';

        copy(__DIR__ . '/../../resources/template/RepositoryTemplate.php', $destinationFileName );
        $str = file_get_contents(__DIR__ . '/../../resources/template/RepositoryTemplate.php');
        $str = str_replace("RepositoryTemplate", $repositoryName, $str);
        $str = str_replace("ReplaceModel", $modelName, $str);
        $str = str_replace("ReplaceNamespace", $namespace, $str);
        file_put_contents($destinationFileName, $str);
        $this->line('Repositorio: ' . $repositoryName.' - Model: '.$modelNameRaw);

    }


}
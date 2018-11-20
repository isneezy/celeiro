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
    protected $signature = 'make:repository {repo}';

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


   // abstract protected function getStub();


    public function handle()
    {
        $repositoryName = ucfirst($this->argument('repo').'Repository');
        $namespace = $this->qualifyClass($repositoryName);
        $path = $this->getPath($namespace);
        echo $path;


        $this->line('Hello World');

       /* copy(__DIR__ . '/../../resources/template/RepositoryTemplate.php', __DIR__ . '/../../resources/template/'.$repositoryName.'.php');
        $str=file_get_contents(__DIR__ . '/../../resources/template/RepositoryTemplate.php');
        $str=str_replace("RepositoryTemplate", $repositoryName,$str);
        file_put_contents(__DIR__ . '/../../resources/template/'.$repositoryName.'.php', $str);
        $this->line('Hello World '.$repositoryName);*/

    }



    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        $name = ltrim($name, '\\/');
        $rootNamespace = $this->rootNamespace();
        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }
        $name = str_replace('/', '\\', $name);
        $namespace = $this->qualifyClass($this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name);
        return $namespace;
    }


    protected function rootNamespace()
    {
        $rootnamespace = $this->laravel->getNamespace();
        return $rootnamespace;
    }


    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }


    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }







}
<?php

namespace Isneezy\Celeiro\Tests;

class CommandsTest extends TestCase
{
    public function test_console_command()
    {
        $this->artisan('make:repository', ['repo' => 'User','--model'=>'Modelo'])
            ->expectsOutput('Repositorio: User - Model: Modelo')
            ->assertExitCode(0);
    }

    public function test_file_exists () {
        $this->assertFileExists(base_path().'/app/Repositories/User.php');
    }
}
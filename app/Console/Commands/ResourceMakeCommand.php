<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ToneflixCode\ResourceModifier\Commands\ResourceMakeCommand as ToneflixCodeResourceMakeCommand;

class ResourceMakeCommand extends ToneflixCodeResourceMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:resource';
}

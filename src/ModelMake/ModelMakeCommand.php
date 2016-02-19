<?php

namespace ApolloPY\Eloquent\ModelMake;

use Illuminate\Foundation\Console\ModelMakeCommand as AbstractModelMakeCommand;

class ModelMakeCommand extends AbstractModelMakeCommand
{
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/model.stub';
    }
}

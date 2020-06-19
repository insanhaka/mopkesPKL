<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:crud 
                            {name : Class (singular) for example User} 
                            {--type=backend : Type Location "backend" or "frontend", default is "backend")}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Simple Crud';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    // Make Model
    protected function model($name)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );

        file_put_contents(app_path("/{$name}.php"), $modelTemplate);
    }

    // Make Controller
    protected function controller($name,$type="backend")
    {
        $modelNamePluralLowerCase = strtolower(\Str::plural($name));
        $modelNameSingularLowerCase = strtolower($name);
        $typeCamelCase = ucfirst(strtolower($type));
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
                '{{typeViewCamelCase}}',
                '{{typeViewLowerCase}}'
            ],
            [
                $name,
                $modelNamePluralLowerCase,
                $modelNameSingularLowerCase,
                $typeCamelCase,
                strtolower($type)
            ],
            $this->getStub('Controller')
        );
        if(!file_exists($path = app_path("/Http/Controllers/{$typeCamelCase}")))
        mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Controllers/{$typeCamelCase}/{$name}Controller.php"), $controllerTemplate);
    }

    // Make View
    protected function view($name,$type="backend")
    {
        $modelNameSingularLowerCase = strtolower($name);
        $modelNamePluralLowerCase = strtolower(\Str::plural($name));
        $typeLowerCase = strtolower($type);
        $routeLowerCase = ($typeLowerCase=='backend')?'admin.'.$modelNameSingularLowerCase:$modelNameSingularLowerCase;
        $controllerTemplateViewIndex = str_replace(
            [
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
                '{{routeLowerCase}}',
                '{{typeViewLowerCase}}',
                '{{name}}'
            ],
            [
                $modelNameSingularLowerCase,
                $modelNamePluralLowerCase,
                $routeLowerCase,
                $typeLowerCase,
                $name
            ],
            $this->getStub('ViewIndex')
        );
        $controllerTemplateViewCreate = str_replace(
            [
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
                '{{routeLowerCase}}',
                '{{typeViewLowerCase}}',
                '{{name}}'
            ],
            [
                $modelNameSingularLowerCase,
                $modelNamePluralLowerCase,
                $routeLowerCase,
                $typeLowerCase,
                $name
            ],
            $this->getStub('ViewCreate')
        );
        $controllerTemplateViewEdit = str_replace(
            [
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
                '{{routeLowerCase}}',
                '{{typeViewLowerCase}}',
                '{{name}}'
            ],
            [
                $modelNameSingularLowerCase,
                $modelNamePluralLowerCase,
                $routeLowerCase,
                $typeLowerCase,
                $name
            ],
            $this->getStub('ViewEdit')
        );
        if(!file_exists($path = (resource_path("/views/{$typeLowerCase}/{$modelNamePluralLowerCase}"))))
        mkdir($path, 0777, true);

        file_put_contents(resource_path("/views/{$typeLowerCase}/{$modelNamePluralLowerCase}/index.blade.php"), $controllerTemplateViewIndex);
        file_put_contents(resource_path("/views/{$typeLowerCase}/{$modelNamePluralLowerCase}/create.blade.php"), $controllerTemplateViewCreate);
        file_put_contents(resource_path("/views/{$typeLowerCase}/{$modelNamePluralLowerCase}/edit.blade.php"), $controllerTemplateViewEdit);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $type = $this->option('type');

        $this->controller($name,$type);
        $this->info("Create Controller {$name}Controller Successfully!");
        $this->model($name);
        $this->info("Create Model {$name} Successfully!");
        // \Artisan::call('make:model',['name'=>$name]);
        $this->view($name,$type);
        $this->info("Create View {$name} (index,create,edit) Successfully!");

        $modelNameSingularLowerCase = strtolower($name);
        $modelNamePluralLowerCase = strtolower(\Str::plural($name));
        $routeGroupName = (\strtolower($type)=='backend')?'admin':'';
        $routeGroupNameDelete = (\strtolower($type)=='backend')?'admin.':'';
        \File::append(base_path('routes/'.strtolower($type).'.php'),
            "
Route::resource('{$modelNameSingularLowerCase}', '{$name}Controller');
Route::post('{$modelNameSingularLowerCase}/delete', '{$name}Controller@delete')->name('{$modelNameSingularLowerCase}.delete');
",null);
    $this->info("Add Route {$modelNameSingularLowerCase} in {$type} Successfully!");
    
    $this->info("Crud Created Successfully!");
    }
}

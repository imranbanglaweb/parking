<?php

namespace App\Providers;


use App\Events\Voyager\FormFieldsRegistered;
use App\Facades\Voyager as VoyagerFacade;
use App\FormFields\DateTimePickerFormField;
use App\FormFields\JsonFormField;
use App\Http\Middleware\VoyagerAdminMiddleware;
use App\Models\MenuItem;
use App\Models\Setting;
use App\Models\User;
use App\Policies\CustomBasePolicy as BasePolicy;
use App\Policies\MenuItemPolicy;
use App\Policies\SettingPolicy;
use App\Providers\Voyager\VoyagerEventServiceProvider;
use App\Voyager\Alert;
use App\Voyager\Commands\AdminCommand;
use App\Voyager\Commands\ControllersCommand;
use App\Voyager\Commands\InstallCommand;
use App\Voyager\Commands\MakeModelCommand;
use App\Voyager\FormFields\After\DescriptionHandler;
use App\Voyager\Translator\Collection as TranslatorCollection;
use App\Voyager\Voyager;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Intervention\Image\ImageServiceProvider;
use Larapack\DoctrineSupport\DoctrineSupportServiceProvider;
use PDOException;

/*use App\Voyager\Voyager;*/

class VoyagerServiceProvider extends ServiceProvider
{

    protected $packageBasePath = null;
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Setting::class => SettingPolicy::class,
        MenuItem::class => MenuItemPolicy::class,
    ];

    protected $gates = [
        'browse_admin',
        'browse_bread',
        'browse_database',
        'browse_media',
        'browse_compass',
        'browse_hooks',
    ];

    public function __construct($app)
    {
        parent::__construct($app);

        $this->packageBasePath = base_path('vendor' . DIRECTORY_SEPARATOR . 'tcg' . DIRECTORY_SEPARATOR . 'voyager');
    }

    /**
     * public function getPublishablePath()
     * {
     * return $this->packageBasePath . DIRECTORY_SEPARATOR . "publishable";
     * }
*/
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->register(VoyagerEventServiceProvider::class);
        $this->app->register(ImageServiceProvider::class);
        /* $this->app->register(VoyagerHooksServiceProvider::class); */
        $this->app->register(DoctrineSupportServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Voyager', VoyagerFacade::class);

        $this->app->singleton('voyager', function () {
            return new Voyager();
        });

        $this->app->singleton('VoyagerAuth', function () {
            return auth();
        });

        $this->loadHelpers();

        $this->registerAlertComponents();
        $this->registerFormFields();

        /*  $this->registerConfigs(); */

        if ($this->app->runningInConsole()) {
            /*  $this->registerPublishableResources(); */
            $this->registerConsoleCommands();
        }

        if (!$this->app->runningInConsole() || config('app.env') == 'testing') {
            $this->registerAppCommands();
        }
    }

    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router, Dispatcher $event)
    {
        if (config('voyager.user.add_default_role_on_register')) {
            $app_user = config('voyager.user.namespace') ?: config('auth.providers.users.model');
            $app_user::created(function ($user) {
                if (is_null($user->role_id)) {
                    VoyagerFacade::model('User')->findOrFail($user->id)
                        ->setRole(config('voyager.user.default_role'))
                        ->save();
                }
            });
        }

        $this->loadViewsFrom(resource_path('views' . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "voyager"), 'voyager');

        $router->aliasMiddleware('admin.user', VoyagerAdminMiddleware::class);

        $this->loadTranslationsFrom(resource_path('lang' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . "voyager"), 'voyager');

        /*        if (config('voyager.database.autoload_migrations', true)) {
                    $this->loadMigrationsFrom($this->getMigrationPath());
                }*/

        $this->loadAuth();

        $this->registerViewComposers();

        $event->listen('voyager.alerts.collecting', function () {
            $this->addStorageSymlinkAlert();
        });

        $this->bootTranslatorCollectionMacros();
    }

    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(app_path('Helpers') . DIRECTORY_SEPARATOR . '*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Register view composers.
     */
    protected function registerViewComposers()
    {
        // Register alerts
        View::composer('voyager::*', function ($view) {
            $view->with('alerts', VoyagerFacade::alerts());
        });
    }

    /**
     * Add storage symlink alert.
     */
    protected function addStorageSymlinkAlert()
    {
        if (app('router')->current() !== null) {
            $currentRouteAction = app('router')->current()->getAction();
        } else {
            $currentRouteAction = null;
        }
        $routeName = is_array($currentRouteAction) ? Arr::get($currentRouteAction, 'as') : null;

        if ($routeName != 'voyager.dashboard') {
            return;
        }

        $storage_disk = (!empty(config('voyager.storage.disk'))) ? config('voyager.storage.disk') : 'public';

        if (request()->has('fix-missing-storage-symlink')) {
            if (file_exists(public_path('storage'))) {
                if (@readlink(public_path('storage')) == public_path('storage')) {
                    rename(public_path('storage'), 'storage_old');
                }
            }

            if (!file_exists(public_path('storage'))) {
                $this->fixMissingStorageSymlink();
            }
        } elseif ($storage_disk == 'public') {
            if (!file_exists(public_path('storage')) || @readlink(public_path('storage')) == public_path('storage')) {
                $alert = (new Alert('missing-storage-symlink', 'warning'))
                    ->title(__('voyager::error.symlink_missing_title'))
                    ->text(__('voyager::error.symlink_missing_text'))
                    ->button(__('voyager::error.symlink_missing_button'), '?fix-missing-storage-symlink=1');
                VoyagerFacade::addAlert($alert);
            }
        }
    }

    protected function fixMissingStorageSymlink()
    {
        app('files')->link(storage_path('app/public'), public_path('storage'));

        if (file_exists(public_path('storage'))) {
            $alert = (new Alert('fixed-missing-storage-symlink', 'success'))
                ->title(__('voyager::error.symlink_created_title'))
                ->text(__('voyager::error.symlink_created_text'));
        } else {
            $alert = (new Alert('failed-fixing-missing-storage-symlink', 'danger'))
                ->title(__('voyager::error.symlink_failed_title'))
                ->text(__('voyager::error.symlink_failed_text'));
        }

        VoyagerFacade::addAlert($alert);
    }

    /**
     * Register alert components.
     */
    protected function registerAlertComponents()
    {
        $components = ['title', 'text', 'button'];

        foreach ($components as $component) {
            $class = 'App\\Voyager\\Alert\\Components\\' . ucfirst(Str::camel($component)) . 'Component';

            $this->app->bind("voyager.alert.components.{$component}", $class);
        }
    }

    protected function bootTranslatorCollectionMacros()
    {
        Collection::macro('translate', function () {
            $transtors = [];

            foreach ($this->all() as $item) {
                $transtors[] = call_user_func_array([$item, 'translate'], func_get_args());
            }

            return new TranslatorCollection($transtors);
        });
    }

    /*
        private function registerPublishableResources()
        {
            $publishablePath = $this->getPublishablePath();

            $publishable = [
                'voyager_avatar' => [
                    $publishablePath . DIRECTORY_SEPARATOR . "dummy_content" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR => storage_path('app/public/users'),
                ],
                'seeds' => [
                    $publishablePath . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "seeds" . DIRECTORY_SEPARATOR => database_path('seeds'),
                ],
                'config' => [
                    $publishablePath . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "voyager.php" => config_path('voyager.php'),
                ],
            ];

            foreach ($publishable as $group => $paths) {
                $this->publishes($paths, $group);
            }
        }

        public function registerConfigs()
        {
            $publishablePath = $this->getPublishablePath();
            $this->mergeConfigFrom(
                $publishablePath . '/config/voyager.php', 'voyager'
            );
        }*/

    public function loadAuth()
    {
        /** DataType Policies
         * This try catch is necessary for the Package Auto-discovery
         * otherwise it will throw an error because no database
         * connection has been made yet.
         * */
        try {
            if (Schema::hasTable(VoyagerFacade::model('DataType')->getTable())) {
                $dataType = VoyagerFacade::model('DataType');
                $dataTypes = $dataType->select('policy_name', 'model_name')->get();

                foreach ($dataTypes as $dataType) {
                    $policyClass = BasePolicy::class;
                    if (isset($dataType->policy_name) && $dataType->policy_name !== ''
                        && class_exists($dataType->policy_name)) {
                        $policyClass = $dataType->policy_name;
                    }

                    $this->policies[$dataType->model_name] = $policyClass;
                }

                $this->registerPolicies();
            }
        } catch (PDOException $e) {
            Log::error('No Database connection yet in VoyagerServiceProvider loadAuth()');
        }

        // Gates
        foreach ($this->gates as $gate) {
            Gate::define($gate, function ($user) use ($gate) {
                /** @var User $user */
                return $user->hasPermission($gate);
            });
        }
    }

    protected function registerFormFields()
    {
        $formFields = [
            'checkbox',
            'multiple_checkbox',
            'color',
            'date',
            'file',
            'image',
            'multiple_images',
            'media_picker',
            'number',
            'password',
            'radio_btn',
            'rich_text_box',
            'code_editor',
            'markdown_editor',
            'select_dropdown',
            'select_multiple',
            'text',
            'text_area',
            'time',
            'timestamp',
            'hidden',
            'coordinates',
        ];

        foreach ($formFields as $formField) {
            $class = Str::studly("{$formField}_handler");

            VoyagerFacade::addFormField("App\\Voyager\\FormFields\\{$class}");
        }

        VoyagerFacade::addFormField(DateTimePickerFormField::class);
        VoyagerFacade::addFormField(JsonFormField::class);

        VoyagerFacade::addAfterFormField(DescriptionHandler::class);

        event(new FormFieldsRegistered($formFields));
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(InstallCommand::class);
        $this->commands(ControllersCommand::class);
        $this->commands(AdminCommand::class);
    }

    /**
     * Register the commands accessible from the App.
     */
    private function registerAppCommands()
    {
        $this->commands(MakeModelCommand::class);
    }
}

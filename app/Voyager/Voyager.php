<?php

namespace App\Voyager;

use App\Events\Voyager\AlertsCollection;
use App\Models\Category;
use App\Models\DataRow;
use App\Models\DataType;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Translation;
use App\Models\User;
use App\Voyager\Actions\DeleteAction;
use App\Voyager\Actions\EditAction;
use App\Voyager\Actions\RestoreAction;
use App\Voyager\Actions\ViewAction;
use App\Voyager\FormFields\After\HandlerInterface as AfterHandlerInterface;
use App\Voyager\FormFields\HandlerInterface;
use App\Voyager\Traits\Translatable;
use Arrilot\Widgets\Facade as Widget;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Voyager
{
    protected $version;
    protected $filesystem;

    protected $alerts = [];
    protected $alertsCollected = false;

    protected $formFields = [];
    protected $afterFormFields = [];

    protected $viewLoadingEvents = [];

    protected $packageBasePath = null;

    protected $actions = [
        DeleteAction::class,
        RestoreAction::class,
        EditAction::class,
        ViewAction::class,
    ];

    protected $models = [
        'Category' => Category::class,
        'DataRow' => DataRow::class,
        'DataType' => DataType::class,
        'Menu' => Menu::class,
        'MenuItem' => MenuItem::class,
        'Page' => Page::class,
        'Permission' => Permission::class,
        'Post' => Post::class,
        'Role' => Role::class,
        'Setting' => Setting::class,
        'User' => User::class,
        'Translation' => Translation::class,
    ];

    /** @var null | array */
    public $setting_cache = null;

    public function __construct()
    {
        $this->filesystem = app(Filesystem::class);
        $this->packageBasePath = base_path('vendor' . DIRECTORY_SEPARATOR . 'tcg' . DIRECTORY_SEPARATOR . 'voyager');

        $this->findVersion();
    }

    public function model($name)
    {
        return app($this->models[Str::studly($name)]);
    }

    public function modelClass($name)
    {
        return $this->models[$name];
    }

    /**
     * @param $name
     * @param $object
     * @return $this
     * @throws \Exception
     */
    public function useModel($name, $object)
    {
        if (is_string($object)) {
            $object = app($object);
        }

        $class = get_class($object);

        if (isset($this->models[Str::studly($name)]) && !$object instanceof $this->models[Str::studly($name)]) {
            throw new \Exception("[{$class}] must be instance of [{$this->models[Str::studly($name)]}].");
        }

        $this->models[Str::studly($name)] = $class;

        return $this;
    }

    public function view($name, array $parameters = [])
    {

        foreach (Arr::get($this->viewLoadingEvents, $name, []) as $event) {
            $event($name, $parameters);
        }
        /*
                $pos = stripos($name, 'voyager::');
                if($pos !== -1){
                    $name = str_replace("voyager::", "vendor.voyager.", $name);
                }*/
        return view($name, $parameters);
    }

    public function onLoadingView($name, \Closure $closure)
    {
        if (!isset($this->viewLoadingEvents[$name])) {
            $this->viewLoadingEvents[$name] = [];
        }

        $this->viewLoadingEvents[$name][] = $closure;
    }

    public function formField($row, $dataType, $dataTypeContent)
    {
        $formField = $this->formFields[$row->type];

        return $formField->handle($row, $dataType, $dataTypeContent);
    }

    public function afterFormFields($row, $dataType, $dataTypeContent)
    {
        return collect($this->afterFormFields)->filter(function ($after) use ($row, $dataType, $dataTypeContent) {
            return $after->visible($row, $dataType, $dataTypeContent, $row->details);
        });
    }

    public function addFormField($handler)
    {
        if (!$handler instanceof HandlerInterface) {
            $handler = app($handler);
        }

        $this->formFields[$handler->getCodename()] = $handler;

        return $this;
    }

    public function addAfterFormField($handler)
    {
        if (!$handler instanceof AfterHandlerInterface) {
            $handler = app($handler);
        }

        $this->afterFormFields[$handler->getCodename()] = $handler;

        return $this;
    }

    public function formFields()
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver", 'mysql');

        return collect($this->formFields)->filter(function ($after) use ($driver) {
            return $after->supports($driver);
        });
    }

    public function addAction($action)
    {
        array_push($this->actions, $action);
    }

    public function replaceAction($actionToReplace, $action)
    {
        $key = array_search($actionToReplace, $this->actions);
        $this->actions[$key] = $action;
    }

    public function actions()
    {
        return $this->actions;
    }

    /**
     * Get a collection of the dashboard widgets.
     *
     * @return \Arrilot\Widgets\WidgetGroup
     */
    public function dimmers()
    {
        $widgetClasses = config('voyager.dashboard.widgets');
        $dimmers = Widget::group('voyager::dimmers');

        foreach ($widgetClasses as $widgetClass) {
            $widget = app($widgetClass);

            if ($widget->shouldBeDisplayed()) {
                $dimmers->addWidget($widgetClass);
            }
        }

        return $dimmers;
    }

    public function setting($key, $default = null)
    {
        $globalCache = config('voyager.settings.cache', false);

        if ($globalCache && Cache::tags('settings')->has($key)) {
            return Cache::tags('settings')->get($key);
        }

        if ($this->setting_cache === null) {
            if ($globalCache) {
                // A key is requested that is not in the cache
                // this is a good opportunity to update all keys
                // albeit not strictly necessary
                Cache::tags('settings')->flush();
            }

            foreach (self::model('Setting')->all() as $setting) {
                $keys = explode('.', $setting->key);
                $this->setting_cache[$keys[0]][$keys[1]] = $setting->value;

                if ($globalCache) {
                    Cache::tags('settings')->forever($setting->key, $setting->value);
                }
            }
        }

        $parts = explode('.', $key);

        if (count($parts) == 2) {
            return @$this->setting_cache[$parts[0]][$parts[1]] ?: $default;
        } else {
            return @$this->setting_cache[$parts[0]] ?: $default;
        }
    }

    public function image($file, $default = '')
    {

        if (!empty($file)) {
            return str_replace('\\', '/', Storage::disk(config('voyager.storage.disk'))->url($file));
        }

        return $default;
    }

    /**
     *  return void
     */
    public function routes()
    {
        require base_path('routes/voyager.php');
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function addAlert(Alert $alert)
    {
        $this->alerts[] = $alert;
    }

    public function alerts()
    {
        if (!$this->alertsCollected) {
            event(new AlertsCollection($this->alerts));

            $this->alertsCollected = true;
        }

        return $this->alerts;
    }

    protected function findVersion()
    {
        if (!is_null($this->version)) {
            return;
        }

        if ($this->filesystem->exists(base_path('composer.lock'))) {
            // Get the composer.lock file
            $file = json_decode(
                $this->filesystem->get(base_path('composer.lock'))
            );

            // Loop through all the packages and get the version of voyager
            foreach ($file->packages as $package) {
                if ($package->name == 'tcg/voyager') {
                    $this->version = $package->version;
                    break;
                }
            }
        }
    }

    /**
     * @param string|Model|Collection $model
     *
     * @return bool
     */
    public function translatable($model)
    {
        if (!config('voyager.multilingual.enabled')) {
            return false;
        }

        if (is_string($model)) {
            $model = app($model);
        }

        if ($model instanceof Collection) {
            $model = $model->first();
        }

        if (!is_subclass_of($model, Model::class)) {
            return false;
        }

        $traits = class_uses_recursive(get_class($model));

        return in_array(Translatable::class, $traits);
    }

    public function getLocales()
    {
        return array_diff(scandir(resource_path("lang" . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "voyager")), ['..', '.']);
    }
    /*    public function getLocales()
        {
            return array_diff(scandir($this->packageBasePath . DIRECTORY_SEPARATOR . "publishable" . DIRECTORY_SEPARATOR . "lang"), ['..', '.']);
        }*/
}

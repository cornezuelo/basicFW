# basicFW
A basic framework in PHP using a MVC-like philosophy, with Twig as the renderer. Suitable for bootstraping really small projects.

# Installation
Copy `config/config.php.default` to `config/config.php` and `config/routing.php.default` to `config/routing.php`.
Do a `composer install` for installing twig.

You could delete the test controllers and managers defined as examples if you want.

# Documentation
## Global Variables
In `config/config.php` you have got three kinds of variables:
### Config Variables
Defined in `$_configApp`, those are internal variables that define how the framework behaves. You can configure the following parameters:
* errors : true/false. Activate the error printing in the whole application.
### Parameters
Defined in `$_paramsApp`, those are your app-related variables. Here you can define your endpoints, etc. that can be then retrieved in your controllers or managers.
### Services
Defined in `$_servicesApp`. Here lies the injection information for your manager constructors. The syntax would be:
`"name_of_manager" => ["param1","param2","param3"...]`

There are two kinds of special params that can be injected:
* Other managers : If you want to inject another manager into a manager, you could do it with the following syntax: `"@name_of_the_manager_to_inject@"`. So, if you want to inject `Test2Manager` in `TestManager`, you could declare the service as: `"TestManager" => ["@Test2Manager@"]`. 
* Config parameters : If you want to inject some of your app parameters, you could do it with the following syntax: `"%name_of_the_parameter%"`. So, if you want to inject the parameter `paramtest` in the `Test2Manager`, you could declare the service as: `"Test2Manager" => ["%paramtest%"]`.

## Routing
You define your routes in `config/routing.php` with the following syntax: `'route' => ['controller','action']`
So, if you want to be routed to the `mainAction` action of the `MainController` controller when someone enters the url `index.php/test/route`, you would add the following route: `'/test/route' => ['MainController','mainAction']`.

The route for `index.php` without any route is defined as `__default__`. So, if you want to route the user to the `testAction` of the `TestController` when he access `http://www.server.com/index.php`, you would define a route like the following: `'__default__' => ['TestController','testAction']`

## Controllers
Your controllers should go in the `controllers/` folder. As seen is `TestController.php`. they should be classes that extend from the main controller, `Controller`.

In a controller, you define actions, than you'll then use in your `routing.php` config file.

Here, you can invoke your managers via `$this->_getManager('manager_name');`, for example, for invoking `TestManager` as seen in the `TestController`, you could do something like `$this->_getManager('TestManager');`.

It may be important to note down that `$this->_getManager()` will return a new instance of the class each time it's invoked. You should use a local variable if you want to work over the same instance of the class.

You could also use the methods `$this->_getConfig('config_key');` for accessing config variables of the app, and `$this->_getParam('param_key');` for accessing your parameters. Both types of global variables are defined in the `config/config.php` file.

You have got access to twig through `$this->twig` in the controllers as well. Usually you would want to do a `echo $this->twig->render()` at the end of your actions in order to render your view.

## Managers
Your managers should go in the `managers/` folder. They don't need to extend from anything, and you can inject whatever you need on them. Remember what we saw on the `Global Variables` section, you could magicly construct those managers using the services system. For example, if we had the service `"TestManager" => ["@Test2Manager@"]`, the `__construct()` method of our `TestManager` class would look like:

`function __construct(Test2Manager $test2Manager) {
    $this->test2Manager = $test2Manager;
}`

The framework will take care of constructing the `Test2Manager` manager (injecting parameters and managers if needed and declared on the services configuration) and pass it to the constructor.

## Views
Your views go in the `views/` folder, using the Twig templating engine. You have got a `{{ dump(variable) }}` method enabled for debuging variables if you need it. 

# TO-DO
* Create a system for managing the twig functions. Dump, path and param as internal functions, but with the posibility to extend it with other ones.
* Refactoring of the routing system, in order to use an alias for the route (which can be used with a `path()` function in twig) and accept multiple routes. In case of repeating routes, we'll use either the first or the last one that gets matched.
* `path()` method in twig for rendering routes.
* `param()` method in twig for printing parameters.
* Cache system, with the posibility of activate or deactivate it in the config.php. Cache activated will imply activating both the twig cache, and the configuration cache (Study how to use a cache for routes and services, maybe start only with creating an easy parseable routing file, and do some tests about the timing with or without the cache before doing something serious)
* Separate the parameters, the config and services in individual files.
* Use YAML, INI, or something like that for the configs instead of php files.

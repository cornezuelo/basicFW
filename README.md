# basicFW
A basic framework in PHP using a MVC-like philosophy, with Twig as the renderer. Suitable for bootstraping really small projects.

# Installation
Copy `config/config.php.default` to `config/config.php` and `config/routing.php.default` to `config/routing.php`.
Do a `composer install` for installing twig.

# Documentation
## Config Variables
Defined in `$_configApp`, in the file `config/config.php`, those are internal variables that define how the framework behaves. You can configure the following parameters:
* errors : true/false. Activate the error printing in the whole application.
## Parameters
Defined in `$_paramsApp`, in the file `config/parameters.php`, those are your app-related variables. Here you can define your endpoints, etc. that can be then retrieved in your controllers or managers.
## Services
Defined in `$_servicesApp`, in the file `config/services.php`. Here lies the injection information for your manager constructors. The syntax would be:
`"name_of_manager" => ["param1","param2","param3"...]`

There are two kinds of special params that can be injected:
* Other managers : If you want to inject another manager into a manager, you could do it with the following syntax: `"@name_of_the_manager_to_inject@"`. So, if you want to inject `Test2Manager` in `TestManager`, you could declare the service as: `"TestManager" => ["@Test2Manager@"]`. 
* Config parameters : If you want to inject some of your app parameters, you could do it with the following syntax: `"%name_of_the_parameter%"`. So, if you want to inject the parameter `paramtest` in the `Test2Manager`, you could declare the service as: `"Test2Manager" => ["%paramtest%"]`.

## Routing
You define your routes in `config/routing.php` with the following syntax: `'route_alias' => ['controller','action',['route1','route2','route3'...]]`
So, if you want to be routed to the `mainAction` action of the `MainController` controller when someone enters the url `index.php/test/route`, you would add the following route: `'test_route' => ['MainController','mainAction',['/test/route']]`.

The route for `index.php` without any route is defined with the alias name and route `__default__`. So, if you want to route the user to the `testAction` of the `TestController` when he access `http://www.server.com/index.php`, you would define a route like the following: `'__default__' => ['TestController','testAction',['__default__']]`

## Controllers
Your controllers should go in the `controllers/` folder. They should be classes that extend from the main controller, `Controller`.

In a controller, you define actions, than you'll then use in your `routing.php` config file.

Here, you can invoke your managers via `$this->_getManager('manager_name');`, for example, for invoking `TestManager` as seen in the `TestController`, you could do something like `$this->_getManager('TestManager');`.

It may be important to note down that `$this->_getManager()` will return a new instance of the class each time it's invoked. You should use a local variable if you want to work over the same instance of the class.

You could also use the methods `$this->_getConfig('config_key');` for accessing config variables of the app, and `$this->_getParam('param_key');` for accessing your parameters. Both types of global variables are defined in the `config/config.php` file.

You have got access to twig through `$this->twig` in the controllers as well. Usually you would want to do a `echo $this->twig->render()` at the end of your actions in order to render your view.

And example of how `TestController` could look like:

***controllers/TestController.php***
```
class TestController extends Controller {
	public function testAction() {						
		$obj = $this->_getManager('TestManager');
		$test_string = $obj->test();
		echo $this->twig->render('test.html.twig', [
			'test_string' => $test_string,
			'errors_app_param' => $this->_getConfig('errors')
			
		]);
	}	
}
```

## Managers
Your managers should go in the `managers/` folder. They don't need to extend from anything, and you can inject whatever you need on them. Remember what we saw on the `Global Variables` section, you could magicly construct those managers using the services system. For example, if we had the service `"TestManager" => ["@Test2Manager@"]`, the `__construct()` method of our `TestManager` class would look like:

`function __construct(Test2Manager $test2Manager) {
    $this->test2Manager = $test2Manager;
}`

The framework will take care of constructing the `Test2Manager` manager (injecting parameters and managers if needed and declared on the services configuration) and pass it to the constructor.

An example of how `TestManager` and `Test2Manager` would look like:

**managers/TestManager.php**
```
class TestManager {
	private $test2Manager;
	function __construct(Test2Manager $test2Manager) {
		$this->test2Manager = $test2Manager;
	}
	public function test() {
		$param = $this->test2Manager->getParam();
		return '<p>This is a test string sent from a manager with param '.$param.'.</p>';
	}
}
```

**managers/Test2Manager.php**
```
class Test2Manager {
	private $param;	
	
	function __construct($param) {
		$this->param = $param;
	}
	
	function getParam() {
		return $this->param;
	}
}
```

## Views
Your views go in the `views/` folder, using the Twig templating engine. 

You have got a `{{ dump(variable) }}` method enabled for debuging variables if you need it. 
You have got a `{{ path('route_alias') }}` method enabled for rendering the first route for an alias method.
You have got a `{{ param('param_key') }}` method enabled for rendering the value of a parameter.

You can create your own twig functions. For this, create a class in the `twig/` folder, with the following requeriments:
* The script should be named with the name of the function. So, for the `{{dump()}}` function, the script should be `twig/dump.php`.
* The class name should be `twig_[function_name]`. So, for the `{{dump()}}` function, the class should be named `twig_dump()`.
* The class should have a `_exec()` public and static method, that should return an anonymous function, containing the code you want to be applied when your function is invoked.

And example of how a test twig view could contain:
***views/test.html.twig***
```
Hello world!

{{ dump(test_string|default('')) }}

Errors {% if errors_app_param %}<span style="color:green">activated</span>{% else %}<span style="color:red">deactivated</span>{% endif %}.

Path twig function: {{path('__default__')}}<br>
Param twig function: {{param('paramtest')}}
```
# TO-DO
* Passing parameters in the route and detect them using regexes if we weren't able to find a literal route, so you could use something like /page/{number} for rendering your routes more cleanly instead of using get parameters. Twig path function should be able to receive the params to inject.
* $this->_getPath('route_name', $params) in controller, for beeing able to render paths.
* Cache system, with the posibility of activate or deactivate it in the config.php. Cache activated will imply activating both the twig cache, and the configuration cache (Study how to use a cache for routes and services, maybe start only with creating an easy parseable routing file, and do some tests about the timing with or without the cache before doing something serious)

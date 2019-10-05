### Routes

#### Route callbacks

There are many ways of passing a callback to a route.

The second parameter of the `Route::{method}()` method takes a variety of options that will be converted to callables.

Below is a variety of possibilities:

```php
/**
 * Using a controller class with an action method is the preferred method. If a FQCN is not passed in, the route will
 * assume the controller class has the namespace `Mediavine\Grow\Controllers`.
 *
 * Action methods are denoted by an `@` and can optionally receive the `\WP_REST_Request` as a parameter.
 *
 * Format: `ControllerClass@method`.
 */
Route::get('/posts', 'PostsController@index');
```

```php
/**
 * Controllers can also be passed as a callable if they implement an `__invoke` method to perform the desired action.
 *
 * Controller classes can be sent with their FQCN by using the `::class` method.
 */
Route::get('/posts', ShowPosts::class);
```

```php
/**
 * A callable array pair with an object at the first index and a method name as the second can also be sent.
 */
Route::get('/posts', [new PostsController, 'index']);
```

```php
/**
 * Passing an anonymous function to the route is the simples method. Best used for testing routes/idea and short-term use routes.
 */
Route::get('/posts', function( WP_REST_Request $request ) {
	return response(get_posts());
});
```

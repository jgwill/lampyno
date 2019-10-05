# Mediavine WordPress Support Package

## Description
This package serves as a home for PHP classes and methods that should be consistent throughout projects but don't have a specific namespace.

## Installation
To add this package to a plugin/theme, modify the `composer.json` file to require `mediavine/wordpress-support` and add the following repository key.

```json
"repositories": [
	{
        "type": "vcs",
        "url":  "git@github.com:mediavine/wordpress-support.git"
    }
]
```

It should look something like this:

```json
"require": {
    "mediavine/wordpress-support": "dev-master"
},
"repositories": [
	{
        "type": "vcs",
        "url":  "git@github.com:mediavine/wordpress-support.git"
    }
]
```

## Classes

[Arr](./docs/arr.md) - A class for interfacing with arrays.

[Str](./docs/str.md) - A class for interfacing with strings.

[Collection](./docs/collection.md) - A class for working with collections of data.

## Testing

**Run setup operations**

This command will install the `composer` dependencies and setup the wordpress testing environment. It will install the WordPress test library in your system's `/tmp` directory and create a test database for running WP-related tests.

```
composer run setup
```

**Run the test suite**

This command will run the entire test suite.

```
composer run test
```
 To filter by test class or by test method, add `--` and the `--filter` option.

 ```
composer run test -- --filter="ArrTest"
composer run test -- --filter="a_collection_can_be_iterated_over"
 ```

### Test Coverage

 To generate a coverage report for the PHPUnit tests, run the following command.

 ```
composer run coverage
 ```

 You'll find the reports in the `tests/_reports/coverage/` directory. Copy the path of `index.html` and view it in your browser for a full report of the project tests coverage.


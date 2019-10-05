# Adding Custom Fields to a Create Card

In version 1.1 of Create, we're adding the ability to register custom fields to cards.

## Registering Custom Fields

In order to register custom fields to cards, use the `mv_create_fields` filter like so:

```php
add_filter('mv_create_fields', function($arr) {
  $arr[] = array(
    'slug' => 'wwpoints',
    'card' => 'recipe', // can also be an array of strings: array('recipe', 'diy'). Leave this attribute blank to apply the custom field to all card types.
    'type' => 'text', // can be 'text', 'textarea', 'select', or 'boolean'
    'placeholder' => 'Point total',
    'label' => 'Weight Watcher Points',
    'instructions' => __('Enter the number of Weight Watcher points'),
  );
  return $arr;
});
```

`$arr` is an array of arrays, each representing a single custom field. Each field accepts the following options:

* `slug` - (required) The unique key by which this value can be accessed
* `card' - (optional) The card type or types to which the field belongs. If left empty, _all_ cards will show this field.
* `type` - (required) The type of UI to be displayed to users. Can be `text`, `textarea`, `select`, or `boolean`
* `label` - (required) Label to be displayed in admin UI
* `instructions` - (optional) Instructions to be displayed in admin UI
* `defaultValue` - (optional) Default value
* `placeholder` - (optional) Placeholder text to be displayed in admin UI (this will be overwritten by "defaultValue", if provided)
* `options` - (required if `type` is `"select"`) An associative array where key is value and value is label. This **must** be an associative array.

Down the road, we'll add other options for the `type` param, including the ability to register custom UI components.


For convenience, you can use the function `mv_create_register_custom_field` which accepts an array for a single field as the argument.

```php
$field = array(
    'slug' => 'wwpoints',
    'card' => 'recipe', // can also be an array of strings: array('recipe', 'diy'). Leave this attribute blank to apply the custom field to all card types.
    'type' => 'text', // can be 'text', 'textarea', 'select', or 'boolean'
    'placeholder' => 'Point total',
    'label' => 'Weight Watcher Points',
    'instructions' => __('Enter the number of Weight Watcher points'),
);
mv_create_register_custom_field( $field );
```


## Accessing Field Data

### By ID

If you know the ID of a card to which you've added custom field data, you can use the `mv_create_get_field` function to access the value.

```php
/**
 * @param {int}    $id    ID of card
 * @param {string} $slug  Slug of field
 */
mv_create_get_field( $id, $slug );
```

For instance, to access the value of the example listed above for a recipe with the ID `42`, you could call:

```php
$ww_points = mv_create_get_field( 42, 'wwpoints' );
```

### In Custom Template
If you've [added custom templates](LINK TO CUSTOM TEMPLATE GUIDE) to your theme, all custom field data is attached to the `$args` variable scoped to template files, at `$args['creation']['custom_fields'];`.

For example, if you wanted to add an "age range" param to your DIY projects, you could add something like this to a template file:

```php
<div>
  <?php _e('Suitable for ages'); ?> <?php echo $args['creation']['custom_fields']['age_range']; ?>
</div>
```

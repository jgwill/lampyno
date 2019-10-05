# Card Templating Guide

Out of the box, Mediavine Create comes with 5 different styles for cards:

* Simple Square <sub><sup>*designed by [Purr Design](https://www.purrdesign.com/)*</sup></sub>
* Simple Square (Dark) <sub><sup>*designed by [Purr Design](https://www.purrdesign.com/)*</sup></sub>
* Classy Circle <sub><sup>*designed by [Purr Design](https://www.purrdesign.com/)*</sup></sub>
* Classy Circle (Dark) <sub><sup>*designed by [Purr Design](https://www.purrdesign.com/)*</sup></sub>
* Hero Image <sub><sup>*designed by [Purr Design](https://www.purrdesign.com/)*</sup></sub>

While these card styles are all awesome, we totally understand that you might want to customize them.

## Declaring theme support
First things first – in your theme, you must declare that you support custom Create templates. This is so that when we're rendering the cards, we can avoid looking up files if you're _not_ using this functionality. (We love site speed.)

In your theme's functions.php file:

```
mv_create_theme_support('v1');
```

(This doesn't need to be in a hook.)

The reason we ask that you specify the version of card styles is so that if – in the future – we release breaking changes that are incompatible with custom templates you've written, we don't break them. For now, just pass 'v1' as the argument and we'll cross that bridge in a future release.

## Template structure

In your theme, add a directory named `mv_create`. This is where you'll be able to override specific templates. (This is similar to what you may have used in other plugins, like WooCommerce.)

### Supported Templates'

Each card is broken up into several template parts, depending on the type of card being displayed. The supported template parts are:

* `shortcode-mv-create-description.php` (renders "description" field)
* `shortcode-mv-create-footer.php` (renders footer, including taxonomy information)
* `shortcode-mv-create-image-container.php` (renders wrap around featured image)
* `shortcode-mv-create-image.php` (renders featured image)
* `shortcode-mv-create-instructions.php` (renders "instructions" field)
* `shortcode-mv-create-notes.php` (renders "notes" field)
* `shortcode-mv-create-nutrition.php` (renders nutrition information – this is just for recipes, of course)
* `shortcode-mv-create-pin-button.php` (renders Pin button)
* `shortcode-mv-create-print-button.php` (renders print button)
* `shortcode-mv-create-products.php` (renders recommended products)
* `shortcode-mv-create-rating.php` (renders ratings UI)
* `shortcode-mv-create-supplies.php` (renders supply fields, like ingredients, tools, or materials)
* `shortcode-mv-create-times.php` (renders time field)
* `shortcode-mv-create-title.php` (renders title)
* `shortcode-mv-create-video.php` (renders video from either Mediavine or YouTube)
* `shortcode-mv-create.php` (renders the card's outer HTML)

Inside this directory, we'll look for templates in this order:

* `<card style>/<part>-<type>.php` (e.g. `centered/shortcode-mv-create-title-recipe.php`)
* `<card style>/<part>.php` (e.g. `centered/shortcode-mv-create-title.php`)
* `<part>-<type>.php` (e.g. `shortcode-mv-create-title-recipe.php`)
* `<part>.php` (e.g. `shortcode-mv-create-title.php`)

...where all paths are relative to `wp-content/themes/<theme>/mv_create`. We would recommend copying and pasting the source code from this plugin to get started.

### Content Type Overrides

As noted above, you can add a content type slug to the end of each template to override that template _only_ for a specific type, similar to how WordPress' own `get_template_part` function works.

The slugs for content types are:

* Recipes - `recipe`
* HowTo - `diy`

This means that you could override the footer for _every_ card by including a file `<theme>/mv_create/shortcode-mv-create-footer.php` or _just_ recipes by including a file `<theme>/mv_create/shortcode-mv-create-footer-recipe.php`. (If you look at our source code, you can see that we do this for Supplies.)

### Order

In order to render each successive template part, we use hooks of different priorities. If you want to change the order in which parts are displayed, you can remove and re-add hooks in any order you'd like. For example, `instructions` and `notes` render with priorities of `40` and `50` respectively on the Simple Square card style.

Due to the nature of having multiple cards style support, these hooks are generated at render. This means that if you wanted to flip these orders, you would first need to hook into an action that is run _after_ the hook is generated at render. Then you would need to remove and add the new actions within that function to properly access the hook. To flip these orders, you could add this to your `functions.php` file:

```php
add_action( 'mv_create_modify_card_style_hooks', 'mv_create_modify_card_style_hooks' );

function mv_create_modify_card_style_hooks( $card_style ) {
    if ( 'square' === $card_style ) {
        remove_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_instructions' ), 40 );
        remove_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_notes' ), 50 );
        add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_instructions' ), 40 );
        add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_notes' ), 40 );
    }
}
```

#### Card Style Orders

One very important detail is that WordPress _requires_ the hook's priority to match when removing. This is the reason for adding the `$card_style` parameter to `mv_create_modify_card_style_hooks`. If you don't don't need to filter by a specific card style, then there's no need to wrap it in a conditional.

Here's the current list of all added card style hooks with their priority:

*Simple Square Light (Default) and Dark Hooks*
```php
add_action( 'mv_create_card_before', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_schema' ), 10 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_title' ), 10 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_pin_button' ), 20 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_image_container' ), 30 );
add_action( 'mv_create_card_image_container', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_image' ), 10 );
add_action( 'mv_create_card_image_container', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_rating' ), 20 );
add_action( 'mv_create_card_image_container', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_print_button' ), 30 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_description' ), 30 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_times' ), 10 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_ad_div' ), 20 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_supplies' ), 30 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_instructions' ), 40 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_notes' ), 50 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_video' ), 60 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_products' ), 70 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_nutrition' ), 80 );
add_action( 'mv_create_card_footer', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_footer' ), 10 );
```

*Classy Circle Light and Dark Hooks*
```php
add_action( 'mv_create_card_before', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_schema' ), 10 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_image' ), 10 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_pin_button' ), 20 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_title' ), 30 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_times' ), 40 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_description' ), 50 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_rating' ), 60 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_print_button' ), 70 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_ad_div' ), 10 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_supplies' ), 20 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_instructions' ), 30 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_notes' ), 40 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_video' ), 50 );
add_action( 'mv_create_card_video_script', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_video_script' ), 10 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_products' ), 60 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_nutrition' ), 70 );
add_action( 'mv_create_card_footer', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_footer' ), 10 );
```

*Hero Image Hooks*
```php
add_action( 'mv_create_card_before', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_schema' ), 10 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_image' ), 10 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_pin_button' ), 20 );
add_action( 'mv_create_card_header', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_title' ), 30 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_times' ), 10 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_description' ), 20 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_print_button' ), 30 );
// 'mv_create_rating' is included in print button template
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_ad_div' ), 40 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_supplies' ), 50 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_instructions' ), 60 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_notes' ), 70 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_video' ), 80 );
add_action( 'mv_create_card_video_script', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_video_script' ), 10 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_products' ), 90 );
add_action( 'mv_create_card_content', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_nutrition' ), 100 );
add_action( 'mv_create_card_footer', array( 'Mediavine\Create\Creations_Views_Hooks', 'mv_create_footer' ), 10 );
```

## In each template
In the scope of each template file, you'll have access to an `$args` variable containing all of the data associated with the published card. `$args` will have the following properties:

* `print` - A boolean indicating whether the context is in the printed card or screen card
* `creation` - An associative array of all of the data associated with each card. The exact structure varies depending on the card, but you'll have access to all of your card data here.

There are a few other undocumented `$args` properties, too, that we use the manage some internal logic.

# Polymorphic EAV-model integration

[![Latest Version on Packagist](https://img.shields.io/packagist/v/davidwesdijk/laravel-polymorphic-eav.svg?style=flat-square)](https://packagist.org/packages/davidwesdijk/laravel-polymorphic-eav)
[![Total Downloads](https://img.shields.io/packagist/dt/davidwesdijk/laravel-polymorphic-eav.svg?style=flat-square)](https://packagist.org/packages/davidwesdijk/laravel-polymorphic-eav)

Integrate the entity-attribute-value model with polymorphic Eloquent-relations in your Laravel application.

## Installation

You can install the package via composer:

```bash
composer require davidwesdijk/laravel-polymorphic-eav
```

## Usage

### Preparing your models

In order to implement the Entity-Attribute-Value-model to your Eloquent models, the only required action is to add the 
`HasEntityAttributeValues` Trait. That's all action required to use the full features this package brings.

``` php
use DavidWesdijk\LaravelPolymorphicEav\Traits\HasEntityAttributeValues;

class Product extends Model
{
     use HasEntityAttributeValues;

    // Implementation of your Eloquent model
}
```

### Assigning attributes

Attributes are, when the Trait is added, accessable and assignable by the `props` accessor on your Eloquent Model. 
Just set its value!

``` php
class ProductController extends Controller
{
    public function update(AnyValidatedRequest $request, Product $product)
    {
        $product->props->details->color = $request->color; // E.g. 'red'

        // That's it!
    }
}
```

### Accessing attributes

The assigned attributes are simply accessible by defining the group and the attribute in the `props` accessor like 
the following example. The concept is that all required properties must be accessible, without throwing exceptions, to 
keep you code clean, readable and maintainable.

``` php
// This attribute has been set before
$product->props->details->color; // 'red'

// This attribute has never been set before 
$product->props->details->sku; // null

// Even if the group has never been defined 
$product->props->foo->bar; // null
```

### Other functionality

If you'd like e.g. remove a property you can either set it's value to null, or you can simply unset the value. The 
database entry will be removed.

``` php
unset($product->props->details->color);

$product->props->details->color; // null
```

### Serializing

You might run into a situation where you have to have all assigned properties available in an array or json. This 
package respects the `Arrayable` and `Jsonable` interfaces. 

``` php
$product->props->details->toArray(); ['color' => 'red']
$product->props->details->toJson(); '{color: "red"}'
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email david@favor.media instead of using the issue tracker.

## Credits

- [David Wesdijk](https://github.com/davidwesdijk)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

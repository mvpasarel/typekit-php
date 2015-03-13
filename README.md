# mvpasarel/typekit-php
[![Latest Version](https://img.shields.io/github/release/mvpasarel/typekit-php.svg?style=flat-square)](https://github.com/mvpasarel/typekit-php/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/mvpasarel/typekit-php/master.svg?style=flat-square)](https://travis-ci.org/mvpasarel/typekit-php)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/mvpasarel/typekit-php.svg?style=flat-square)](https://scrutinizer-ci.com/g/mvpasarel/typekit-php/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/mvpasarel/typekit-php.svg?style=flat-square)](https://scrutinizer-ci.com/g/mvpasarel/typekit-php)
[![Total Downloads](https://img.shields.io/packagist/dt/mvpasarel/typekit-php.svg?style=flat-square)](https://packagist.org/packages/mvpasarel/typekit-php)

Typekit Client implementation with PHP

## Install

Via Composer

```
$ composer require mvpasarel/typekit-php
```

## Usage


Initialize the client with your developer API token. You can get your API token [here](https://typekit.com/account/tokens). All method calls return the JSON representation of the return from calling the Typekit API.


```
$typekit = new \Mvpasarel\Typekit\TypekitClient('<API token>');
```

### Get all kits

To get all your kits, use the following command:

```
$typekit->getKits();
```

### Get kit

To get information about a specific kit, input the kit id as the argument:

```
$typekit->getKit($kitId);
```

### Create kit

To create a new kit, use the method `createKit($name, $domains, $families)`. `Name` and `domains` 
fields are required, but the `families` field is not.

The arguments are in the following format:

- **$name**: string
- **$domains**: PHP array of strings of format `array('localhost', '*.domain.com', '127.0.0.1')`
- **$families**: set of arrays with the following key => values
    - 'id' : font family id (string)
    - (optional) 'variations' : comma separated variations (string).

An example of the families format is: `$families = array(array('id' => 'ftnk', 'variations' => 'n3,n4'), array('id' => 'pcpv', 'variations' => 'n4'))` in which case we would create a kit with the font families Futura-PT and Droid Sans with font variations normal 3 ($font-weight:300 and not italicized or strong), normal 4 and normal 4, respectively.

Example usage:

    $name = 'example typekit kit';

    $domains = array('localhost', '*.domain.com');

    $families = array(array('id' => 'ftnk', 'variations' => 'n3,n4'), array('id' => 'pcpv', 'variations' => 'n4'));

    $typekit->createKit($name, $domains, $families);

### Update kit

To create a new kit, use the method `updateKit($kitId, $name='', $domains=array(), $families=array())`. 
The only required field is `$kitId` and `name`. `domains` and `families` fields are not required.

Field formats are the same as `createKit`.

Example usage:

    $name = 'Example';
    
    $typekit->updateKit($kitId, $name);

### Remove kit

To remove a kit, use the method `removeKit($kitId)`. The `$kitId` field is required.

```
$typekit->removeKit($kitId);
```

### Publish kit

To publish a kit, use the method `publishKit($kitId)`. The `$kitId` field is required.
```
$typekit->publishKit($kitId);
```

### Get font family

To retrieve information regarding a given font family, use the method `getFontFamily($font)`. The argument `font` is 
a string and can be a Typekit font id or a slug of the font as named in Typekit. The method does not slugify the input, so make sure to slugify it before entering the argument.

```
$typekit->getFontFamily('<font_id>');
```

### Get font variations

To retrieve all possible variations of a given font, use the method `getFontVariations($font)`. The argument is the 
same as for `getFontFamily($font)`. This method returns a PHP array of all possible variations of the font.

    $variations = $typekit->getFontVariations('futura-pt'); # using font slug
    
    or
    
    $variations = $typekit->getFontVariations('ftnk'); # using font id
    
    OUTPUT:
    array('n3', 'i3', 'n4', 'i4', 'n5', 'i5', 'n7', 'i7', 'n8', 'i8')

### Add font to kit

To add font to kit, use the method `kitAddFont($kitId, $font, $variations)`. Arguments for this method is the 
same format as the ones above, BUT variations should be in array. Returns nothing.

```
$typekit->kitAddFont('$kitId', 'futura-pt', array(n3,n5,n7));
```

### Remove font from kit

To add font to kit, use the method `kitRemoveFont($kitId, $font)`. Arguments for this method is the same format as 
the ones above, BUT variations should be in array. Returns nothing.

```
$typekit->kitRemoveFont($kitId, 'futura-pt');
```

### Other methods

`getKitValues($kitId)` - Retrieves kit values in an array of format: [$name, $domains, $families]

`getKitFonts($kitId)` - Retrieves an array of font ids in a given kit

`kitContainsFont($kitId, $font)` - Checks to see if a font exists in a kit.

## Testing

```
$ TYPEKIT_TOKEN=<API token> phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please use [Contact Form](http://mvpasarel.com/contact) instead of using 
the issue tracker.

## Credits

- [Madalin Pasarel](https://github.com/mvpasarel)
- [All Contributors](../../contributors)

## Thanks to

- [Typekit Python](https://github.com/suchanlee/typekit-python)
- [The PHP League](https://github.com/thephpleague/skeleton)


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

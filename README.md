# SwarrotStatsdBundle

[![Total Downloads](https://poser.pugx.org/hexanet/swarrot-statsd-bundle/downloads.png)](https://packagist.org/packages/hexanet/swarrot-statsd-bundle) [![Latest stable Version](https://poser.pugx.org/hexanet/swarrot-statsd-bundle/v/stable.png)](https://packagist.org/packages/hexanet/swarrot-statsd-bundle)

[Swarrot](https://github.com/swarrot/SwarrotBundle) processor to send data to stastd with [M6Web/StatsdBundle](https://github.com/M6Web/StatsdBundle).

## Installation

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require hexanet/swarrot-statsd-bundle
```

### Applications that don't use Symfony Flex

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require hexanet/swarrot-statsd-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Hexanet\SwarrotStatsdBundle\HexanetSwarrotStatsdBundle(),
        );

        // ...
    }

    // ...
}
```

## Usage

In your `config.yml` file, you could add a middleware processor which is going to send events to use my M6Web/StatsdBundle.

```yaml
swarrot:
    consumers:
        eligibility:
            processor: processor.eligibility
            middleware_stack:
                - configurator: hexanet_swarrot_statsd.processor.statsd
                  extras:
                      name: eligibility
                - configurator: swarrot.processor.ack
        populate_ticket:
            processor: processor.populate_ticket
            middleware_stack:
                # no extra data with message name so the queue name is used instead
                - configurator: hexanet_swarrot_statsd.processor.statsd
                - configurator: swarrot.processor.ack

m6_statsd:
    clients:
        default:
            servers: ['default']
            events:
                swarrot_statsd.message.success:
                    increment: "si.eligibility-service.message.<messageName>.success"
                    timing: "si.eligibility-service.message.<messageName>"
                swarrot_statsd.message.error:
                    increment: "si.eligibility-service.message.<messageName>.error"
                    timing: "si.eligibility-service.message.<messageName>"
                    immediate_send: true
```



## Credits

Developed by [Hexanet](http://www.hexanet.fr/).

## License

[SwarrotStatsdBundle](https://github.com/Hexanet/SwarrotStatsdBundle) is licensed under the [MIT license](LICENSE).

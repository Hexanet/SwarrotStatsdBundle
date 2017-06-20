# SwarrotStatsdBundle

[![Total Downloads](https://poser.pugx.org/hexanet/swarrot-statsd-bundle/downloads.png)](https://packagist.org/packages/hexanet/swarrot-statsd-bundle) [![Latest Unstable Version](https://poser.pugx.org/hexanet/swarrot-statsd-bundle/v/unstable.png)](https://packagist.org/packages/hexanet/swarrot-statsd-bundle)

Swarrot processor to send data to stastd with M6Web/StatsdBundle.

## Installation

```bash
composer require hexanet/swarrot-statsd-bundle
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
                # no extra data with message, so the queue name is used instead
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

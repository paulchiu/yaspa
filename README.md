# Yet Another Shopify PHP API (yaspa)

[![CircleCI](https://circleci.com/gh/paulchiu/yaspa/tree/master.svg?style=svg)](https://circleci.com/gh/paulchiu/yaspa/tree/master)

## Purpose

Most Shopify APIs appear to be thin wrappers around Guzzle that makes things
slightly more convenient but still makes it feel like you are interacting with a
REST API.

The goal of this project is to go one step beyond and provide something closer
to a SDK whereby the library offers everything through PHP without the developer
needing to think too much about the REST API.

## Project objectives

- Be truthful to the original API, do not rename, restructure, or
  otherwise modify terms where possible
- Offer different levels of abstraction
- Work with native models where possible
- Promises first, embrace async support in Guzzle

# Examples

Please see `examples.index.html` for library usage examples. Please note
that some examples are interactive, while others are purely code samples.

# Testing

To run tests, execute:

```
./vendor/bin/phpunit
```

## Integration testing

Integration tests will hit the Shopify API. Please only run these
against a purely development store as data modification will occur.

Integration tests requires `test-config.json` to exist. Please see
`test-config.example.json` for expectations on how it should be filled.

To run integration tests, execute:

```
./vendor/bin/phpunit --group=integration
```

## To do

- [ ] Implement [authentication][sauth]
    - [ ] Clean up docs and create docs folder
- [ ] Implement [api call limit throtling][acl] through custom pool [pool][gpool]

[sauth]: https://help.shopify.com/api/getting-started/authentication
[acl]: https://help.shopify.com/api/getting-started/api-call-limit
[gpool]: http://docs.guzzlephp.org/en/stable/quickstart.html#concurrent-requests

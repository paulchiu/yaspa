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

- Be truthful to the original API, do not rename, restructure, or otherwise modify terms where possible
- Offer different levels of abstraction
- Work with native models where possible
- Promises first, embrace async support in Guzzle

## To do

- [ ] Implement [authentication][sauth]
    - [ ] Model [redirect parameters][rparam]
    - [ ] Implement [confirm installation][cinst] class with [HMAC verification][hmac]
- [ ] Implement [api call limit throtling][acl] through custom pool [pool][gpool]

[sauth]: https://help.shopify.com/api/getting-started/authentication
[acl]: https://help.shopify.com/api/getting-started/api-call-limit
[gpool]: http://docs.guzzlephp.org/en/stable/quickstart.html#concurrent-requests
[rparam]: https://help.shopify.com/api/getting-started/authentication/oauth#verification
[cinst]: https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
[hmac]: http://php.net/manual/en/function.hash-hmac.php

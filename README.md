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

## Manual testing

To perform manual testing, publish the contents of `tests/Manual` on a web server. For example,
on [Devilbox][dbox] one would create a symlink called `htdoc` in the project root to `tests/Manual`.

[dbox]: http://devilbox.org/

### Test OAuth token request

- Set up Shopify app, add redirect whitelist for `http://httpbin.org/anything`
- Fill out `test-config.json`; a template is available in `project-root/test-config.example.json`
- Make public the contents of `tests/Manual`
- Visit `http://localhost/oauth/authorize-prompt.php`
- Click link to authorize
- Copy the request parameters
- Visit `http://localhost/oauth/confirm-installation.php?[copied request parameters]`
- The access token should be shown

### Available manual testing routes

The following assumes all files are hosted on `http://localhost/`

|Route|Tests|
|-----|-----|
|`/oauth/authorize-prompt.php`|Enables clicking and viewing results of a app OAuth authorization request from the app installer's perspective|

## To do

- [ ] Implement [authentication][sauth]
- [ ] Implement [api call limit throtling][acl] through custom pool [pool][gpool]

[sauth]: https://help.shopify.com/api/getting-started/authentication
[acl]: https://help.shopify.com/api/getting-started/api-call-limit
[gpool]: http://docs.guzzlephp.org/en/stable/quickstart.html#concurrent-requests
[cinst]: https://help.shopify.com/api/getting-started/authentication/oauth#step-3-confirm-installation
[hmac]: http://php.net/manual/en/function.hash-hmac.php

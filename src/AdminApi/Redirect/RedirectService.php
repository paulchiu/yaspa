<?php

namespace Yaspa\AdminApi\Redirect;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Yaspa\AdminApi\Redirect\Builders\CountAllRedirectsRequest;
use Yaspa\AdminApi\Redirect\Builders\CreateNewRedirectRequest;
use Yaspa\AdminApi\Redirect\Builders\DeleteRedirectRequest;
use Yaspa\AdminApi\Redirect\Builders\GetRedirectRequest;
use Yaspa\AdminApi\Redirect\Builders\GetRedirectsRequest;
use Yaspa\AdminApi\Redirect\Builders\ModifyExistingRedirectRequest;
use Yaspa\AdminApi\Redirect\Builders\RedirectFields;
use Yaspa\AdminApi\Redirect\Models;
use Yaspa\AdminApi\Redirect\Models\Redirect;
use Yaspa\AdminApi\Redirect\Transformers;
use Yaspa\Builders\PagedResultsIterator;
use Yaspa\Exceptions\MissingExpectedAttributeException;
use Yaspa\Interfaces\RequestCredentialsInterface;

/**
 * Class RedirectService
 *
 * @package Yaspa\AdminApi\Redirect
 * @see https://help.shopify.com/api/reference/redirect
 */
class RedirectService
{
    /** @var Client $httpClient */
    protected $httpClient;
    /** @var Transformers\Redirect $redirectTransformer */
    protected $redirectTransformer;
    /** @var CreateNewRedirectRequest $createNewRedirectRequestBuilder */
    protected $createNewRedirectRequestBuilder;
    /** @var GetRedirectRequest $getRedirectRequestBuilder */
    protected $getRedirectRequestBuilder;
    /** @var DeleteRedirectRequest $deleteRedirectRequestBuilder */
    protected $deleteRedirectRequestBuilder;
    /** @var PagedResultsIterator $pagedResultsIteratorBuilder */
    protected $pagedResultsIteratorBuilder;

    /**
     * RedirectService constructor.
     *
     * @param Client $httpClient
     * @param Transformers\Redirect $redirectTransformer
     * @param CreateNewRedirectRequest $createNewRedirectRequestBuilder
     * @param GetRedirectRequest $getRedirectRequestBuilder
     * @param DeleteRedirectRequest $deleteRedirectRequestBuilder
     * @param PagedResultsIterator $pagedResultsIteratorBuilder
     */
    public function __construct(
        Client $httpClient,
        Transformers\Redirect $redirectTransformer,
        CreateNewRedirectRequest $createNewRedirectRequestBuilder,
        GetRedirectRequest $getRedirectRequestBuilder,
        DeleteRedirectRequest $deleteRedirectRequestBuilder,
        PagedResultsIterator $pagedResultsIteratorBuilder
    ) {
        $this->httpClient = $httpClient;
        $this->redirectTransformer = $redirectTransformer;
        $this->createNewRedirectRequestBuilder = $createNewRedirectRequestBuilder;
        $this->getRedirectRequestBuilder = $getRedirectRequestBuilder;
        $this->deleteRedirectRequestBuilder = $deleteRedirectRequestBuilder;
        $this->pagedResultsIteratorBuilder = $pagedResultsIteratorBuilder;
    }

    /**
     * Get redirects based on parameters set in the request.
     *
     * @see https://help.shopify.com/api/reference/redirect#index
     * @param GetRedirectsRequest $request
     * @return PagedResultsIterator|Redirect[]
     */
    public function getRedirects(GetRedirectsRequest $request): PagedResultsIterator
    {
        return $this->pagedResultsIteratorBuilder
            ->withRequestBuilder($request)
            ->withTransformer($this->redirectTransformer);
    }

    /**
     * Async version of self::getRedirects
     *
     * Please note that results will have to be manually transformed.
     *
     * @see https://help.shopify.com/api/reference/redirect#index
     * @param GetRedirectsRequest $request
     * @return PromiseInterface
     */
    public function asyncGetRedirects(GetRedirectsRequest $request): PromiseInterface
    {
        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Count redirects for a collection or search criteria.
     *
     * @see https://help.shopify.com/api/reference/redirect#count
     * @param CountAllRedirectsRequest $request
     * @return int
     * @throws MissingExpectedAttributeException
     */
    public function countRedirects(CountAllRedirectsRequest $request): int
    {
        $response = $this->asyncCountRedirects($request)->wait();

        $count = json_decode($response->getBody()->getContents());

        if (!property_exists($count, 'count')) {
            throw new MissingExpectedAttributeException('count');
        }

        return intval($count->count);
    }

    /**
     * Async version of self::countRedirects
     *
     * @see https://help.shopify.com/api/reference/redirect#count
     * @param CountAllRedirectsRequest $request
     * @return PromiseInterface
     */
    public function asyncCountRedirects(CountAllRedirectsRequest $request): PromiseInterface
    {
        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Get an individual redirect.
     *
     * @param RequestCredentialsInterface $credentials
     * @param Redirect $redirect
     * @param null|RedirectFields $redirectFields
     * @return Redirect
     */
    public function getRedirect(
        RequestCredentialsInterface $credentials,
        Redirect $redirect,
        ?RedirectFields $redirectFields = null
    ): Redirect {
        $response = $this->asyncGetRedirect($credentials, $redirect, $redirectFields)->wait();

        return $this->redirectTransformer->fromResponse($response);
    }

    /**
     * Async version of self::getRedirect
     *
     * @param RequestCredentialsInterface $credentials
     * @param Redirect $redirect
     * @param null|RedirectFields $redirectFields
     * @return PromiseInterface
     */
    public function asyncGetRedirect(
        RequestCredentialsInterface $credentials,
        Redirect $redirect,
        ?RedirectFields $redirectFields = null
    ): PromiseInterface {
        $request = $this->getRedirectRequestBuilder
            ->withCredentials($credentials)
            ->withRedirect($redirect);

        if ($redirectFields) {
            $request = $request->withRedirectFields($redirectFields);
        }

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Convenience method for self::getRedirect
     *
     * @param RequestCredentialsInterface $credentials
     * @param int $redirectId
     * @param null|RedirectFields $redirectFields
     * @return Redirect
     */
    public function getRedirectById(
        RequestCredentialsInterface $credentials,
        int $redirectId,
        ?RedirectFields $redirectFields = null
    ): Redirect {
        $redirect = (new Redirect())->setId($redirectId);

        return $this->getRedirect($credentials, $redirect, $redirectFields);
    }

    /**
     * Convenience method for self::asyncGetRedirect
     *
     * @param RequestCredentialsInterface $credentials
     * @param int $redirectId
     * @param null|RedirectFields $redirectFields
     * @return PromiseInterface
     */
    public function asyncGetRedirectById(
        RequestCredentialsInterface $credentials,
        int $redirectId,
        ?RedirectFields $redirectFields = null
    ): PromiseInterface {
        $redirect = (new Redirect())->setId($redirectId);

        return $this->asyncGetRedirect($credentials, $redirect, $redirectFields);
    }

    /**
     * Create a new redirect
     *
     * @see https://help.shopify.com/api/reference/redirect#create
     * @param RequestCredentialsInterface $credentials
     * @param Models\Redirect $redirect
     * @return Models\Redirect
     */
    public function createNewRedirect(
        RequestCredentialsInterface $credentials,
        Models\Redirect $redirect
    ): Models\Redirect {
        $response = $this->asyncCreateNewRedirect($credentials, $redirect)->wait();

        return $this->redirectTransformer->fromResponse($response);
    }

    /**
     * Async version of self::createNewRedirect
     *
     * @see https://help.shopify.com/api/reference/redirect#create
     * @param RequestCredentialsInterface $credentials
     * @param Models\Redirect $redirect
     * @return PromiseInterface
     */
    public function asyncCreateNewRedirect(
        RequestCredentialsInterface $credentials,
        Models\Redirect $redirect
    ): PromiseInterface {
        $request = $this->createNewRedirectRequestBuilder
            ->withCredentials($credentials)
            ->withRedirect($redirect);

        return $this->httpClient->sendAsync(
            $request->toRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Modify an existing customer.
     *
     * @see https://help.shopify.com/api/reference/redirect#update
     * @param ModifyExistingRedirectRequest $request
     * @return Models\Redirect
     */
    public function modifyExistingRedirect(ModifyExistingRedirectRequest $request): Models\Redirect
    {
        $response = $this->asyncModifyExistingRedirect($request)->wait();

        return $this->redirectTransformer->fromResponse($response);
    }

    /**
     * Async version of self::updateExistingRedirect
     *
     * @see https://help.shopify.com/api/reference/redirect#update
     * @param ModifyExistingRedirectRequest $request
     * @return PromiseInterface
     */
    public function asyncModifyExistingRedirect(ModifyExistingRedirectRequest $request): PromiseInterface
    {
        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Delete redirect.
     *
     * Returns an empty object with no properties if successful.
     *
     * @see https://help.shopify.com/api/reference/redirect#destroy
     * @param RequestCredentialsInterface $credentials
     * @param Redirect $redirect
     * @return object
     */
    public function deleteRedirect(
        RequestCredentialsInterface $credentials,
        Redirect $redirect
    ) {
        $response = $this->asyncDeleteRedirect($credentials, $redirect)->wait();

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Async version of self::deleteRedirect
     *
     * @see https://help.shopify.com/api/reference/redirect#destroy
     * @param RequestCredentialsInterface $credentials
     * @param Redirect $redirect
     * @return PromiseInterface
     */
    public function asyncDeleteRedirect(
        RequestCredentialsInterface $credentials,
        Redirect $redirect
    ): PromiseInterface {
        $request = $this->deleteRedirectRequestBuilder
            ->withCredentials($credentials)
            ->withRedirect($redirect);

        return $this->httpClient->sendAsync(
            $request->toResourceRequest(),
            $request->toRequestOptions()
        );
    }

    /**
     * Convenience method for self::deleteRedirect
     *
     * @see https://help.shopify.com/api/reference/redirect#destroy
     * @param RequestCredentialsInterface $credentials
     * @param int $redirectId
     * @return object
     */
    public function deleteRedirectById(
        RequestCredentialsInterface $credentials,
        int $redirectId
    ) {
        $redirect = (new Models\Redirect())->setId($redirectId);

        return $this->deleteRedirect($credentials, $redirect);
    }

    /**
     * Convenience method for self::asyncDeleteRedirect
     *
     * @see https://help.shopify.com/api/reference/redirect#destroy
     * @param RequestCredentialsInterface $credentials
     * @param int $redirectId
     * @return PromiseInterface
     */
    public function asyncDeleteRedirectById(
        RequestCredentialsInterface $credentials,
        int $redirectId
    ): PromiseInterface {
        $redirect = (new Models\Redirect())->setId($redirectId);

        return $this->asyncDeleteRedirect($credentials, $redirect);
    }
}

<?php

namespace Yaspa\AdminApi\Customer\Builders;

use GuzzleHttp\RequestOptions;
use Yaspa\Constants\RequestBuilder;
use Yaspa\Interfaces\PagingRequestBuilderInterface;
use Yaspa\Traits\AuthorizedRequestBuilderTrait;

/**
 * Class SearchCustomersRequest
 *
 * @package Yaspa\AdminApi\Customer\Builders
 * @see https://help.shopify.com/api/reference/customer#search
 */
class SearchCustomersRequest implements PagingRequestBuilderInterface
{
    use AuthorizedRequestBuilderTrait;

    const URI_TEMPLATE = 'https://%s.myshopify.com/admin/customers/search.json';
    const DEFAULT_ORDER = 'last_order_date DESC';

    /** @var string $order */
    protected $order;
    /** @var string $query */
    protected $query;
    /** @var int $page */
    protected $page;
    /** @var int $limit */
    protected $limit;
    /** @var CustomerFields $customerFields */
    protected $customerFields;

    /**
     * SearchCustomersRequest constructor.
     */
    public function __construct()
    {
        // Set properties with defaults
        $this->httpMethod = RequestBuilder::GET_HTTP_METHOD;
        $this->headers = RequestBuilder::JSON_HEADERS;
        $this->bodyType = RequestBuilder::QUERY_BODY_TYPE;
        $this->page = RequestBuilder::STARTING_PAGE;
        $this->uriTemplate = self::URI_TEMPLATE;
        $this->order = self::DEFAULT_ORDER;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        if (!is_null($this->order)) {
            $array['order'] = $this->order;
        }

        if (!is_null($this->query)) {
            $array['query'] = $this->query;
        }

        if (!is_null($this->page)) {
            $array['page'] = $this->page;
        }

        if (!is_null($this->limit)) {
            $array['limit'] = $this->limit;
        }

        if (!is_null($this->customerFields)) {
            $array['customer_fields'] = $this->customerFields;
        }


        return $array;
    }

    /**
     * @return int
     */
    public function getPage():? int
    {
        return $this->page;
    }

    /**
     * @param string $order
     * @return SearchCustomersRequest
     */
    public function withOrder(string $order): SearchCustomersRequest
    {
        $new = clone $this;
        $new->order = $order;

        return $new;
    }

    /**
     * @param string $query
     * @return SearchCustomersRequest
     */
    public function withQuery(string $query): SearchCustomersRequest
    {
        $new = clone $this;
        $new->query = $query;

        return $new;
    }

    /**
     * @param int $page
     * @return SearchCustomersRequest
     */
    public function withPage(int $page): SearchCustomersRequest
    {
        $new = clone $this;
        $new->page = $page;

        return $new;
    }

    /**
     * @param int $limit
     * @return SearchCustomersRequest
     */
    public function withLimit(int $limit): SearchCustomersRequest
    {
        $new = clone $this;
        $new->limit = $limit;

        return $new;
    }

    /**
     * @param CustomerFields $customerFields
     * @return SearchCustomersRequest
     */
    public function withCustomerFields(CustomerFields $customerFields): SearchCustomersRequest
    {
        $new = clone $this;
        $new->customerFields = $customerFields;

        return $new;
    }
}

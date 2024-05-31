<?php

namespace Ominity\Api\Endpoints\Commerce;

use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Exceptions\ApiException;
use Ominity\Api\Resources\Commerce\Customer;
use Ominity\Api\Resources\Commerce\Order;
use Ominity\Api\Resources\Commerce\Payment;
use Ominity\Api\Resources\Commerce\PaymentCollection;

class OrderPaymentEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "commerce/orders_payments";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new PaymentCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new Payment($this->client);
    }

    /**
     * Create a new payment for a specific Order.
     *
     * @param Order $order
     * @param array $data
     * @param array $filters
     *
     * @return Payment
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createFor(Order $order, array $data, array $filters = [])
    {
        return $this->createForId($order->id, $data, $filters);
    }

    /**
     * Create a new payment for a specific Order ID.
     *
     * @param int $orderId
     * @param array $data
     * @param array $filters
     *
     * @return Payment
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function createForId($orderId, array $data, array $filters = [])
    {
        $this->parentId = $orderId;

        return parent::rest_create($data, $filters);
    }

    /**
     * Get the payment for a specific Order.
     *
     * @param Order $order
     * @param int $paymentId
     * @return Payment
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getFor(Order $order, int $paymentId, array $parameters = []) {
        if (empty($customer)) {
            throw new ApiException("Order is empty.");
        }

        if (empty($paymentId)) {
            throw new ApiException("Payment ID is empty.");
        }

        return $this->getForId($order->id, $paymentId, $parameters);
    }

    /**
     * Get the payment for a specific Order ID.
     *
     * @param int $orderId
     * @param int $paymentId
     * @return Payment
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function getForId(int $orderId, int $paymentId, array $parameters = []) {
        if (empty($orderId)) {
            throw new ApiException("Order ID is empty.");
        }

        if (empty($paymentId)) {
            throw new ApiException("Payment ID is empty.");
        }

        $this->parentId = $orderId;
        return parent::rest_read($paymentId, $parameters);
    }

    /**
     * Retrieves a collection of payments for a specific Order.
     *
     * @param Order $order
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @return PaymentCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function pageFor(Order $order, $page = null, $limit = null, array $parameters = [])
    {
        return $this->pageForId($order->id, $page, $limit, $parameters);
    }

     /**
     * Retrieves a collection of payments for a specific Order ID.
     *
     * @param int $orderId
     * @param int $page The page number to request
     * @param int $limit
     * @param array $parameters
     * @return PaymentCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function pageForId(int $orderId, $page = null, $limit = null, array $parameters = [])
    {
        $this->parentId = $orderId;

        return parent::rest_list($page, $limit, $parameters);
    }

    /**
     * This is a wrapper method for pageFor
     *
     * @param Order $order
     * @param array $parameters
     *
     * @return PaymentCollection
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function allFor(Order $order, array $parameters = [])
    {
        return $this->pageFor($order, null, null, $parameters);
    }

    /**
     * This is a wrapper method for pageForId
     *
     * @param int $orderId
     * @param array $parameters
     * @return PaymentCollection
     * 
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function allForId(int $orderId, array $parameters = [])
    {
        return $this->pageForId($orderId, null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over payments for the given order retrieved from Ominity.
     *
     * @param Order $order
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(Order $order, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($order->id, $parameters, $iterateBackwards);
    }

    /**
     * Create an iterator for iterating over payments for the given order id retrieved from Ominity.
     *
     * @param int $orderId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(int $orderId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->parentId = $orderId;

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}
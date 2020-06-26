<?php

namespace _PhpScoper5eddef0da618a\Mollie\Api\Endpoints;

use _PhpScoper5eddef0da618a\Mollie\Api\Exceptions\ApiException;
use _PhpScoper5eddef0da618a\Mollie\Api\Resources\Order;
use _PhpScoper5eddef0da618a\Mollie\Api\Resources\OrderLine;
use _PhpScoper5eddef0da618a\Mollie\Api\Resources\OrderLineCollection;
use _PhpScoper5eddef0da618a\Mollie\Api\Resources\ResourceFactory;
class OrderLineEndpoint extends \_PhpScoper5eddef0da618a\Mollie\Api\Endpoints\CollectionEndpointAbstract
{
    protected $resourcePath = "orders_lines";
    /**
     * @var string
     */
    const RESOURCE_ID_PREFIX = 'odl_';
    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one
     * type of object.
     *
     * @return OrderLine
     */
    protected function getResourceObject()
    {
        return new \_PhpScoper5eddef0da618a\Mollie\Api\Resources\OrderLine($this->client);
    }
    /**
     * Get the collection object that is used by this API endpoint. Every API
     * endpoint uses one type of collection object.
     *
     * @param int $count
     * @param \stdClass $_links
     *
     * @return OrderLineCollection
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new \_PhpScoper5eddef0da618a\Mollie\Api\Resources\OrderLineCollection($count, $_links);
    }
    /**
     * Cancel lines for the provided order.
     * The data array must contain a lines array.
     * You can pass an empty lines array if you want to cancel all eligible lines.
     * Returns null if successful.
     *
     * @param Order $order
     * @param array $data
     *
     * @return null
     * @throws ApiException
     */
    public function cancelFor(\_PhpScoper5eddef0da618a\Mollie\Api\Resources\Order $order, array $data)
    {
        return $this->cancelForId($order->id, $data);
    }
    /**
     * Cancel lines for the provided order id.
     * The data array must contain a lines array.
     * You can pass an empty lines array if you want to cancel all eligible lines.
     * Returns null if successful.
     *
     * @param string $orderId
     * @param array $data
     *
     * @return null
     * @throws ApiException
     */
    public function cancelForId($orderId, array $data)
    {
        if (!isset($data['lines']) || !\is_array($data['lines'])) {
            throw new \_PhpScoper5eddef0da618a\Mollie\Api\Exceptions\ApiException("A lines array is required.");
        }
        $this->parentId = $orderId;
        $this->client->performHttpCall(self::REST_DELETE, "{$this->getResourcePath()}", $this->parseRequestBody($data));
        return null;
    }
}
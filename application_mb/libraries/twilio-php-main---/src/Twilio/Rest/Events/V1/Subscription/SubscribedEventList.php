<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Events\V1\Subscription;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 */
class SubscribedEventList extends ListResource {
    /**
     * Construct the SubscribedEventList
     *
     * @param Version $version Version that contains the resource
     * @param string $subscriptionSid Subscription SID.
     */
    public function __construct(Version $version, string $subscriptionSid) {
        parent::__construct($version);

        // Path Solution
        $this->solution = ['subscriptionSid' => $subscriptionSid, ];

        $this->uri = '/Subscriptions/' . \rawurlencode($subscriptionSid) . '/SubscribedEvents';
    }

    /**
     * Streams SubscribedEventInstance records from the API as a generator stream.
     * This operation lazily loads records as efficiently as possible until the
     * limit
     * is reached.
     * The results are returned as a generator, so this operation is memory
     * efficient.
     *
     * @param int $limit Upper limit for the number of records to return. stream()
     *                   guarantees to never return more than limit.  Default is no
     *                   limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use the default value of 50 records.  If no
     *                        page_size is defined but a limit is defined, stream()
     *                        will attempt to read the limit with the most
     *                        efficient page size, i.e. min(limit, 1000)
     * @return Stream stream of results
     */
    public function stream(int $limit = null, $pageSize = null): Stream {
        $limits = $this->version->readLimits($limit, $pageSize);

        $page = $this->page($limits['pageSize']);

        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    /**
     * Reads SubscribedEventInstance records from the API as a list.
     * Unlike stream(), this operation is eager and will load `limit` records into
     * memory before returning.
     *
     * @param int $limit Upper limit for the number of records to return. read()
     *                   guarantees to never return more than limit.  Default is no
     *                   limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use the default value of 50 records.  If no
     *                        page_size is defined but a limit is defined, read()
     *                        will attempt to read the limit with the most
     *                        efficient page size, i.e. min(limit, 1000)
     * @return SubscribedEventInstance[] Array of results
     */
    public function read(int $limit = null, $pageSize = null): array {
        return \iterator_to_array($this->stream($limit, $pageSize), false);
    }

    /**
     * Retrieve a single page of SubscribedEventInstance records from the API.
     * Request is executed immediately
     *
     * @param mixed $pageSize Number of records to return, defaults to 50
     * @param string $pageToken PageToken provided by the API
     * @param mixed $pageNumber Page Number, this value is simply for client state
     * @return SubscribedEventPage Page of SubscribedEventInstance
     */
    public function page($pageSize = Values::NONE, string $pageToken = Values::NONE, $pageNumber = Values::NONE): SubscribedEventPage {
        $params = Values::of(['PageToken' => $pageToken, 'Page' => $pageNumber, 'PageSize' => $pageSize, ]);

        $response = $this->version->page('GET', $this->uri, $params);

        return new SubscribedEventPage($this->version, $response, $this->solution);
    }

    /**
     * Retrieve a specific page of SubscribedEventInstance records from the API.
     * Request is executed immediately
     *
     * @param string $targetUrl API-generated URL for the requested results page
     * @return SubscribedEventPage Page of SubscribedEventInstance
     */
    public function getPage(string $targetUrl): SubscribedEventPage {
        $response = $this->version->getDomain()->getClient()->request(
            'GET',
            $targetUrl
        );

        return new SubscribedEventPage($this->version, $response, $this->solution);
    }

    /**
     * Create the SubscribedEventInstance
     *
     * @param string $type Type of event being subscribed to.
     * @param array|Options $options Optional Arguments
     * @return SubscribedEventInstance Created SubscribedEventInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create(string $type, array $options = []): SubscribedEventInstance {
        $options = new Values($options);

        $data = Values::of(['Type' => $type, 'SchemaVersion' => $options['schemaVersion'], ]);

        $payload = $this->version->create('POST', $this->uri, [], $data);

        return new SubscribedEventInstance($this->version, $payload, $this->solution['subscriptionSid']);
    }

    /**
     * Constructs a SubscribedEventContext
     *
     * @param string $type Type of event being subscribed to.
     */
    public function getContext(string $type): SubscribedEventContext {
        return new SubscribedEventContext($this->version, $this->solution['subscriptionSid'], $type);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        return '[Twilio.Events.V1.SubscribedEventList]';
    }
}
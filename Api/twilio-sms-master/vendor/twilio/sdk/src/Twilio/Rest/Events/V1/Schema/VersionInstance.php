<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Events\V1\Schema;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 *
 * @property string $id
 * @property int $schemaVersion
 * @property \DateTime $dateCreated
 * @property string $url
 * @property string $raw
 */
class VersionInstance extends InstanceResource {
    /**
     * Initialize the VersionInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $id The unique identifier of the schema.
     * @param int $schemaVersion The version of the schema
     */
    public function __construct(Version $version, array $payload, string $id, int $schemaVersion = null) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'id' => Values::array_get($payload, 'id'),
            'schemaVersion' => Values::array_get($payload, 'schema_version'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'url' => Values::array_get($payload, 'url'),
            'raw' => Values::array_get($payload, 'raw'),
        ];

        $this->solution = [
            'id' => $id,
            'schemaVersion' => $schemaVersion ?: $this->properties['schemaVersion'],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return VersionContext Context for this VersionInstance
     */
    protected function proxy(): VersionContext {
        if (!$this->context) {
            $this->context = new VersionContext(
                $this->version,
                $this->solution['id'],
                $this->solution['schemaVersion']
            );
        }

        return $this->context;
    }

    /**
     * Fetch the VersionInstance
     *
     * @return VersionInstance Fetched VersionInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): VersionInstance {
        return $this->proxy()->fetch();
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get(string $name) {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, '_' . $name)) {
            $method = 'get' . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Events.V1.VersionInstance ' . \implode(' ', $context) . ']';
    }
}
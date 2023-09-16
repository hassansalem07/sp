<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Events\V1;

use Twilio\Options;
use Twilio\Values;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 */
abstract class SinkOptions {
    /**
     * @param bool $inUse A boolean to return sinks used/not used by a subscription.
     * @param string $status A string to filter sinks by status.
     * @return ReadSinkOptions Options builder
     */
    public static function read(bool $inUse = Values::NONE, string $status = Values::NONE): ReadSinkOptions {
        return new ReadSinkOptions($inUse, $status);
    }
}

class ReadSinkOptions extends Options {
    /**
     * @param bool $inUse A boolean to return sinks used/not used by a subscription.
     * @param string $status A string to filter sinks by status.
     */
    public function __construct(bool $inUse = Values::NONE, string $status = Values::NONE) {
        $this->options['inUse'] = $inUse;
        $this->options['status'] = $status;
    }

    /**
     * A boolean query parameter filtering the results to return sinks used/not used by a subscription.
     *
     * @param bool $inUse A boolean to return sinks used/not used by a subscription.
     * @return $this Fluent Builder
     */
    public function setInUse(bool $inUse): self {
        $this->options['inUse'] = $inUse;
        return $this;
    }

    /**
     * A String query parameter filtering the results by status `initialized`, `validating`, `active` or `failed`.
     *
     * @param string $status A string to filter sinks by status.
     * @return $this Fluent Builder
     */
    public function setStatus(string $status): self {
        $this->options['status'] = $status;
        return $this;
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        $options = \http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Events.V1.ReadSinkOptions ' . $options . ']';
    }
}
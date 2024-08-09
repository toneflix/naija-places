<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class MessageParser
{
    /**
     * The length of the plain message body
     *
     * @var int
     */
    public $length = [];

    /**
     * The corresponding message key from the [messages] config
     *
     * @var string
     */
    public $configKey = '';

    /**
     * The message subject
     *
     * @var string
     */
    public $subject = '';

    /**
     * The message body
     *
     * @var array<int,string|array>
     */
    public $lines = [];

    /**
     * The message body
     *
     * @var string
     */
    public $body = '';

    /**
     * The message body with stripped tags
     *
     * @var string
     */
    public $plainBody = '';

    /**
     * Initialize the class
     *
     * @param string $configKey The corresponding message key from the [messages] config
     * @param mixed[] $params Exra parameters to pass to the config
     */
    public function __construct(
        string $configKey,
        protected array $params = []
    ) {
        $this->configKey = $configKey;
    }

    /**
     * Parses a message in the messages config and returns
     * It in the required format
     *
     * @param string $config
     * @return self
     */
    public function parse(): self
    {
        $this->params =  collect($this->params)->map(fn ($val) => $val instanceof Model ? $val->toArray() : $val)
            ->filter(fn ($item) => is_array($item))
            ->collapse()
            ->filter(fn ($item) => is_scalar($item))
            ->all();


        $lines = collect(config("messages.{$this->configKey}.lines", []));

        // Parse the message lines
        $lines = $lines->map(function ($line) {
            // If the line is an array (a button) parse it the content also
            if (is_array($line)) {
                return collect($line)->mapWithKeys(function ($val, $key) {
                    return [$key => __($val, $this->params)];
                })->all();
            }

            // The line should now be return safe
            return is_string($line)
                ? __($line, $this->params)
                : $line;
        })->merge([config("messages.signature")]);

        $this->lines = $lines->all();

        $this->body = $lines->map(function ($line) {
            if (is_array($line)) {
                return collect($line)->values()->first(fn ($val) => filter_var($val, FILTER_VALIDATE_URL), '');
            }
            return $line;
        })->join("\n");

        $this->plainBody = str($this->body)->stripTags()->toString();

        $this->length = str($this->body)->length();

        // Parse the message subject
        $this->subject = __(config("messages.{$this->configKey}.subject", ''), $this->params);

        return $this;
    }
}

<?php

namespace App\Enums;

use App\Helpers\Providers;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use ToneflixCode\KudiSmsNotification\KudiSmsChannel;
use ToneflixCode\KudiSmsNotification\KudiSmsMessage;

/**
 * HTTP Status codes.
 */
enum SmsProvider: string
{
    case TWILLIO = TwilioChannel::class;
    case KUDISMS = KudiSmsChannel::class;

    /**
     * Get the sms provider
     */
    public static function getMessage(string $message): TwilioSmsMessage|KudiSmsMessage
    {
        $type = Providers::config('prefered_sms_channel', 'TWILLIO');

        if ($type === self::KUDISMS->name) {
            return (new KudiSmsMessage())->message($message);
        }

        // Return Twillio as Default

        return (new TwilioSmsMessage())->content($message);
    }

    /**
     * Get the sms provider
     */
    public static function getChannel(): string
    {
        $type = Providers::config('prefered_sms_channel', 'TWILLIO');

        if ($type === self::KUDISMS->name) {
            return self::KUDISMS->value;
        }

        // Return Twillio as Default
        return self::TWILLIO->value;
    }
}

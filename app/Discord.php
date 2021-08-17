<?php

namespace App;

use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class GameChallengeNotification extends Notification
{
    public $challenger;

    public $game;

    public function __construct(Guild $challenger, Game $game)
    {
        $this->challenger = $challenger;
        $this->game = $game;
    }

    public function via($notifiable)
    {
        return [DiscordChannel::class];
    }

    public function toDiscord($notifiable)
    {
        return DiscordMessage::create("bag pl in mata");
    }
}
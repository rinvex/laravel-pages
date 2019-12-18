<?php

declare(strict_types=1);

namespace Rinvex\Pages\Events;

use Rinvex\Pages\Models\Page;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PageSaved implements ShouldBroadcast
{
    use SerializesModels;
    use InteractsWithSockets;

    public $page;

    /**
     * Create a new event instance.
     *
     * @param \Rinvex\Pages\Models\Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new Channel($this->formatChannelName());
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'rinvex.pages.saved';
    }

    /**
     * Format channel name.
     *
     * @return string
     */
    protected function formatChannelName(): string
    {
        return 'rinvex.pages.list';
    }
}

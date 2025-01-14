<?php

namespace Spatie\ScheduleMonitor\Support\OhDearPayload\Payloads;

use Illuminate\Support\Arr;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTaskLogItem;

class FinishedPayload extends Payload
{
    public static function canHandle(MonitoredScheduledTaskLogItem $logItem): bool
    {
        return $logItem->type === MonitoredScheduledTaskLogItem::TYPE_FINISHED;
    }

    public function url()
    {
        return "{$this->baseUrl()}/finished";
    }

    public function data(): array
    {
        return Arr::only($this->logItem->meta ?? [], [
            ...(config('schedule-monitor.oh_dear.should_send_starting_ping') ? [] : ['runtime']),
            'exit_code',
            'memory',
        ]);
    }
}

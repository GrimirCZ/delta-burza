<?php

namespace App\Http;

class ExhibitionSelection
{
    public int $id;
    public string $exhibition_name;
    public int $exhibition_id;
    public string $morning_event;
    public string $evening_event;

    /**
     * ExhibitionSelection constructor.
     * @param int $id
     * @param string $exhibition_name
     * @param int $exhibition_id
     * @param string $morning_event
     * @param string $evening_event
     */
    public function __construct(int $id, string $exhibition_name, int $exhibition_id, string $morning_event, string $evening_event)
    {
        $this->id = $id;
        $this->exhibition_name = $exhibition_name;
        $this->exhibition_id = $exhibition_id;
        $this->morning_event = $morning_event;
        $this->evening_event = $evening_event;
    }
}

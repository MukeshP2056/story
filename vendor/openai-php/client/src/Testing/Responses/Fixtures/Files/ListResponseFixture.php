<?php

namespace OpenAI\Testing\Responses\Fixtures\Files;

final class ListResponseFixture
{
    public const ATTRIBUTES = [
        'object' => 'list',
        'data' => [
            [
                'id' => 'file-XjGxS3KTG0uNmNOK362iJua3',
                'object' => 'file',
                'bytes' => 140,
                'created_at' => 1_613_779_121,
                'filename' => 'fake-file.jsonl',
                'purpose' => 'fine-tune',
                'status' => 'succeeded',
                'status_details' => null,
            ],
        ],
    ];
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTests extends TestCase
{
    const STUCTURE = [
        'id',
        'name',
        'message',
        'parent_id',
        'initials',
        'age',
        'children' => [],
        'created_at',
        'updated_at',
    ];

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_home()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_comments_index()
    {
        $response = $this->get('/comments');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => self::STUCTURE
                ],
                'meta' => [
                    'total'
                ]
            ]);
    }

    public function test_comment_store()
    {
        $response = $this->postJson('/comments/submit', [
            'name' => 'Aji Ichiban',
            'message' => 'This is a test of the emergency broadcast system. tut tut, tut tudot tut tut, tut tut, tut tudot tut tut...'
        ]);

        $parentCommentResponseContent = $response->assertStatus(200)
            ->assertExactJson([
                'comment' => self::STUCTURE
            ])->decodeResponseJson();

        $response = $this->postJson('/comments/submit', [
            'name' => 'Kamen Raider',
            'message' => 'Raider change. Raider kick. Raider punch. arrgghhhhh!!! boomm...',
            'parent_id' => $parentCommentResponseContent['comment']['id']
        ]);

        $response->assertStatus(200)
            ->assertExactJson([
                'comment' => self::STUCTURE
            ]);
    }
}

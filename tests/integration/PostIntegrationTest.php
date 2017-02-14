<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostIntegrationTest extends TestCase
{

    use DatabaseTransactions;

    function test_a_slug_is_generated_and_saved_to_the_database()
    {
        $post = $this->createPost([
            'title' => 'Como instalar Laravel'
        ]);

        //dd($post->toArray());

        $this->assertSame(
            'como-instalar-laravel',
            $post->slug  // $post->fresh()->slug
        );

    }
}

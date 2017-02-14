<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowPostTest extends TestCase
{
    function test_a_user_can_see_the_post_details()
    {
        // Having
        $user = $this->defaultUser([
            'name' => 'Mónica García',
        ]);

        $post = factory(\App\Post::class)->make([
            'title' => 'Cómo instalar Laravel',
            'content' => 'Este es el contenido del post'
        ]);

        $user->posts()->save($post);

        // When
        $this->visit(route('posts.show', [$post->id, $post->slug]))
            ->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see($user->name)
        ;

    }


    function test_old_urls_are_redirected()
    {
        // Having
        $user = $this->defaultUser();

        $post = factory(\App\Post::class)->make([
            'title' => 'Old title',
        ]);

        $user->posts()->save($post);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        //dd($url);

        $this->visit($url)
            ->seePageIs($post->url);
    }

}

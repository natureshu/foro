<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowPostTest extends FeatureTestCase
{
    function test_a_user_can_see_the_post_details()
    {
        // Having
        $user = $this->defaultUser([
            'name' => 'Mónica García',
        ]);

        $post = $this->createPost([
            'title' => 'Cómo instalar Laravel',
            'content' => 'Este es el contenido del post',
            'user_id' => $user->id,
        ]);

        //dd(\App\User::all()->toArray());

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
        $post = $this->createPost([
            'title' => 'Old title',
        ]);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        //dd($url);

        $this->visit($url)
            ->seePageIs($post->url);
    }

}

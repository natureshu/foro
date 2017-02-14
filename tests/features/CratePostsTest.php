<?php

class CratePostsTest extends FeatureTestCase
{
    public function test_a_user_create_a_post()
    {
        // Having
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';
        $user = $this->defaultUser();

        $this->actingAs($user); // Simulo que el usuario está conectado

        // When
        $this->visit(route('posts.create'))
            ->type($title, 'title')
            ->type($content, 'content')
            ->press('Publicar');

        // Then
        // Esto nos ayuda a saber si el registro fue creado correctamente o no en la DB
        $this->seeInDatabase('posts', [
            'title' => $title,
            'content' => $content,
            'pending' => true,
            'user_id' => $user->id,
        ]);

        // Test a user is redirected to the posts details after creating it.
        $this->see($title);
    }

    // Creo una prueba que identifique que el usuario está conectado y si no lo está
    // le redirecciono a la página de login

    function test_creating_a_post_requires_authentication()
    {
        $this->visit(route('posts.create'))
            ->seePageIs(route('login'));
    }

    // Validación del formulario
    function test_create_post_validation()
    {
        $this->actingAs($this->defaultUser())
            ->visit(route('posts.create'))
            ->press('Publicar')
            ->seePageIs(route('posts.create'))
            ->seeErrors([
                'title' => 'El campo título es obligatorio',
                'content' => 'El campo contenido es obligatorio'
            ])
        ;

    }
}
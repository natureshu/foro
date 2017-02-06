<?php

class ExampleTest extends FeatureTestCase
{

    public function test_basic_example()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'Monica Garcia',
            'email' => 'monica@shunet.es',
        ]);

        $this->actingAs($user, 'api')
             ->visit('api/user')
             ->see('Monica Garcia')
             ->see('monica@shunet.es');
    }
}

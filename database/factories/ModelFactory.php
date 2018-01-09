<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
//$factory->define(App\User::class, function (Faker\Generator $faker) {
//    static $password;
//
//    return [
//        'name' => $faker->name,
//        'email' => $faker->unique()->safeEmail,
//        'password' => $password ?: $password = bcrypt('secret'),
//        'remember_token' => str_random(10),
//    ];
//});
//测试随机出现的假数据
$factory->define(App\Post::class,function (Faker\Generator $faker) {
   return [
       'title'=>$faker->sentence(6),
       'content'=>$faker->realText(500),
       'user_id'=>$faker->numberBetween(1,4)
   ];
});

$factory->define(App\Info::class,function (Faker\Generator $faker) {
    return [
        'name'=>$faker->name('male|female'),
        'phoneNumber'=>$faker->phoneNumber,
        'address'=>$faker->address,
        'company'=>$faker->company,
        'email'=>$faker->email,
        'introduce'=>$faker->realText()
    ];
});

<?php

/*
 * This file is part of the EloquentSerializer package.
 * 
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer;

use Carbon\Carbon;
use Fidry\EloquentSerializer\Model\AnotherDummy;
use Fidry\EloquentSerializer\Model\Dummy;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use PHPUnit_Framework_TestCase as PHPUnit;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
trait TestCaseTrait
{
    /**
     * @var SerializerInterface|NormalizerInterface|DenormalizerInterface
     */
    private $serializer;

    public function tearDown()
    {
        $this->purgeDatabase();
    }

    /**
     * Delete all instances from the database.
     */
    public function purgeDatabase()
    {
        foreach ($this->getEloquentModelsToPurge() as $model) {
            /** @var EloquentModel[] $instances */
            $instances = $model::all();
            foreach ($instances as $instance) {
                $instance->delete();
            }
        }
    }

    /**
     * @return string[] FQCN of Eloquent models
     */
    public function getEloquentModelsToPurge()
    {
        return [
            Dummy::class,
            AnotherDummy::class,
        ];
    }

    public function testNormalizeEloquentObject()
    {
        $user = Dummy::create([
            'id' => 100,
            'name' => 'Gunner Runte',
            'email' => 'vbrekke@example.com',
            'casted_bool' => 1,
            'password' => '$2y$10$j/R4kRrymk3wMXwohvoRou2zBKJZVecr1VON.9NnSXu24k6CP6tDe',
            'remember_token' => 'PhiasHkmCh',
            'created_at' => new Carbon('2016-07-02T12:28:14+00:00'),
        ]);

        $expected = [
            'id' => 100,
            'name' => 'Gunner Runte',
            'email' => 'vbrekke@example.com',
            'casted_bool' => true,
            'created_at' => '2016-07-02T12:28:14+00:00',
            'inexistent_visible_property' => null,
        ];
        $actual = $this->serializer->normalize($user);

        PHPUnit::assertSame($expected, $actual);
    }

    public function testNormalizeEloquentObjectWithRelation()
    {
        $address = AnotherDummy::create([
            'id' => 200,
            'address' => "TechHub @ Campus"
                ."4-5 Bonhill Street\n"
                ."London EC2A 4BX\n"
                ."United Kingdom"
        ]);

        $user = Dummy::create([
            'id' => 102,
            'name' => 'Dr. Eldred Kuvalis PhD',
            'email' => 'amanda.harber@example.com',
            'password' => '$2y$10$Rv56QfRBQhO39Pl2igknIOlyXRiOPjipskQKr.S9HcvhkwfyiNNFC',
            'remember_token' => 'JyeiFq4y3C',
            'created_at' => new Carbon('2016-07-02 12:28:14'),
        ]);
        $user->anotherDummy()->associate($address);
        $user->save();

        $expected = [
            'id' => 102,
            'name' => 'Dr. Eldred Kuvalis PhD',
            'email' => 'amanda.harber@example.com',
            // 'casted_bool' => null
            'created_at' => '2016-07-02T12:28:14+00:00',
            'inexistent_visible_property' => null,
            'anotherDummy' => [
                'id' => 200,
                'address' => "TechHub @ Campus4-5 Bonhill Street\nLondon EC2A 4BX\nUnited Kingdom",
            ],
        ];
        $actual = $this->serializer->normalize($user);

        PHPUnit::assertSame($expected, $actual);
    }
}

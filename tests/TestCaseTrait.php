<?php

namespace Fidry\LaravelSerializerSymfony;

use Fidry\LaravelSerializerSymfony\Model\AnotherDummy;
use Fidry\LaravelSerializerSymfony\Model\Dummy;
use Illuminate\Database\Eloquent\Model as EloquentModel;
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
        $user = \App\User::create([
            'id' => 100,
            'name' => 'Gunner Runte',
            'email' => 'vbrekke@example.com',
            'password' => '$2y$10$j/R4kRrymk3wMXwohvoRou2zBKJZVecr1VON.9NnSXu24k6CP6tDe',
            'remember_token' => 'PhiasHkmCh',
            'created_at' => new \Carbon\Carbon('2016-07-02T12:28:14+00:00'),
        ]);

        $expected = [
            'id' => 100,
            'name' => 'Gunner Runte',
            'email' => 'vbrekke@example.com',
            'created_at' => '2016-07-02T12:28:14+00:00',
        ];
        $actual = $this->serializer->normalize($user);

        $this->assertSame($expected, $actual);
    }

    public function testNormalizeEloquentObjectWithRelation()
    {
        $address = \App\Address::create([
            'id' => 200,
            'address' => "TechHub @ Campus"
                ."4-5 Bonhill Street\n"
                ."London EC2A 4BX\n"
                ."United Kingdom"
        ]);

        $user = \App\User::create([
            'id' => 102,
            'name' => 'Dr. Eldred Kuvalis PhD',
            'email' => 'amanda.harber@example.com',
            'password' => '$2y$10$Rv56QfRBQhO39Pl2igknIOlyXRiOPjipskQKr.S9HcvhkwfyiNNFC',
            'remember_token' => 'JyeiFq4y3C',
            'created_at' => new \Carbon\Carbon('2016-07-02 12:28:14'),
        ]);
        $user->address()->associate($address);
        $user->save();

        $expected = [
            'id' => 102,
            'name' => 'Dr. Eldred Kuvalis PhD',
            'email' => 'amanda.harber@example.com',
            'created_at' => '2016-07-02T12:28:14+00:00',
            'address' => [
                'id' => 200,
                'address' => "TechHub @ Campus4-5 Bonhill Street\nLondon EC2A 4BX\nUnited Kingdom",
            ],
        ];
        $actual = $this->serializer->normalize($user);

        $this->assertSame($expected, $actual);
    }
}

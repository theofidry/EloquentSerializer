<?php

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class EloquentModelNormalizerTest extends TestCase
{
    /**
     * @var SerializerInterface|NormalizerInterface|DenormalizerInterface
     */
    private $serializer;

    public function setUp()
    {
        parent::setUp();

        $this->deleteInstances();
        $this->serializer = $this->app->make('serializer');
    }

    public function deleteInstances()
    {
        foreach ($this->getModels() as $model) {
            $instances = $model::all();
            foreach ($instances as $instance) {
                $instance->delete();
            }
        }
    }

    public function getModels()
    {
        return [
            \App\User::class,
            \App\Address::class
        ];
    }

    /**
     * @expectedException \Symfony\Component\Serializer\Exception\UnexpectedValueException
     */
    public function testNormalizeRegularObject()
    {
        $this->serializer->normalize(new \stdClass());
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

    public function tearDown()
    {
        $this->deleteInstances();
    }
}

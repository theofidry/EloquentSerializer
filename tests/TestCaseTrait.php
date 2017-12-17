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
use PHPUnit\Framework\TestCase as PHPUnit;
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

    public function testCanNormalizeAnEloquentObject()
    {
        $dummy = Dummy::create([
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
            'created_at' => [
                'date' => '2016-07-02 12:28:14.000000',
                'timezone_type' => 3,
                'timezone' => 'UTC',
            ],
            'inexistent_visible_property' => null,
        ];

        $actual = $this->serializer->normalize($dummy);

        PHPUnit::assertSame($expected, $actual);
    }

    public function testCanNormalizeAnEloquentObjectWithRelationships()
    {
        $anotherDummy = AnotherDummy::create([
            'id' => 200,
            'address' => "TechHub @ Campus"
                ."4-5 Bonhill Street\n"
                ."London EC2A 4BX\n"
                ."United Kingdom"
        ]);

        $dummy = Dummy::create([
            'id' => 102,
            'name' => 'Dr. Eldred Kuvalis PhD',
            'email' => 'amanda.harber@example.com',
            'password' => '$2y$10$Rv56QfRBQhO39Pl2igknIOlyXRiOPjipskQKr.S9HcvhkwfyiNNFC',
            'remember_token' => 'JyeiFq4y3C',
            'created_at' => new Carbon('2016-07-02T12:28:14+00:00'),
        ]);
        $dummy->anotherDummy()->associate($anotherDummy);
        $dummy->save();

        $expected = [
            'id' => 102,
            'name' => 'Dr. Eldred Kuvalis PhD',
            'email' => 'amanda.harber@example.com',
            // 'casted_bool' => null
            'created_at' => [
                'date' => '2016-07-02 12:28:14.000000',
                'timezone_type' => 3,
                'timezone' => 'UTC',
            ],
            'inexistent_visible_property' => null,
            'anotherDummy' => [
                'id' => 200,
                'address' => "TechHub @ Campus4-5 Bonhill Street\nLondon EC2A 4BX\nUnited Kingdom",
            ],
        ];
        $actual = $this->serializer->normalize($dummy);

        PHPUnit::assertSame($expected, $actual);
    }

    public function testCanDenormalizeAnEloquentObject()
    {
        $data = [
            'id' => 200,
            'name' => 'Gunner Runte',
            'email' => 'vbrekke@example.com',
            'casted_bool' => 0,
            'password' => '$2y$10$j/R4kRrymk3wMXwohvoRou2zBKJZVecr1VON.9NnSXu24k6CP6tDe',
            'remember_token' => 'PhiasHkmCh',
            'created_at' => '2016-07-02T12:28:14+00:00'
        ];

        /** @var Dummy $dummy */
        $dummy = $this->serializer->denormalize($data, Dummy::class);

        PHPUnit::assertInstanceOf(Dummy::class, $dummy);
        PHPUnit::assertEquals(200, $dummy->id);
        PHPUnit::assertEquals('Gunner Runte', $dummy->name);
        PHPUnit::assertEquals('vbrekke@example.com', $dummy->email);
        PHPUnit::assertEquals('$2y$10$j/R4kRrymk3wMXwohvoRou2zBKJZVecr1VON.9NnSXu24k6CP6tDe', $dummy->password);
        PHPUnit::assertEquals('PhiasHkmCh', $dummy->remember_token);
        PHPUnit::assertEquals(false, $dummy->casted_bool);
        PHPUnit::assertEquals(new Carbon('2016-07-02T12:28:14+00:00'), $dummy->created_at);
    }

    public function testCanDenormalizeEloquentAnObjectWithNonHydratedRelationships()
    {
        $data = [
            'id' => 200,
            'name' => 'Gunner Runte',
            'email' => 'vbrekke@example.com',
            'casted_bool' => 0,
            'password' => '$2y$10$j/R4kRrymk3wMXwohvoRou2zBKJZVecr1VON.9NnSXu24k6CP6tDe',
            'remember_token' => 'PhiasHkmCh',
            'created_at' => '2016-07-02T12:28:14+00:00',
            'another_dummy' => 500,
        ];

        /** @var Dummy $dummy */
        $dummy = $this->serializer->denormalize($data, Dummy::class);

        PHPUnit::assertInstanceOf(Dummy::class, $dummy);
        PHPUnit::assertEquals(200, $dummy->id);
        PHPUnit::assertEquals('Gunner Runte', $dummy->name);
        PHPUnit::assertEquals('vbrekke@example.com', $dummy->email);
        PHPUnit::assertEquals('$2y$10$j/R4kRrymk3wMXwohvoRou2zBKJZVecr1VON.9NnSXu24k6CP6tDe', $dummy->password);
        PHPUnit::assertEquals('PhiasHkmCh', $dummy->remember_token);
        PHPUnit::assertEquals(false, $dummy->casted_bool);
        PHPUnit::assertEquals(new Carbon('2016-07-02T12:28:14+00:00'), $dummy->created_at);
        PHPUnit::assertEquals(500, $dummy->another_dummy_id);
        PHPUnit::assertEquals(0, count($dummy->getRelations()));
    }

    public function testCanDenormalizeAnEloquentObjectWithRelationships()
    {
        $data = [
            'id' => 200,
            'another_dummy' => [
                'id' => 500,
                'address' => "TechHub @ Campus4-5 Bonhill Street\nLondon EC2A 4BX\nUnited Kingdom",
            ],
        ];

        /** @var Dummy $dummy */
        $dummy = $this->serializer->denormalize($data, Dummy::class);

        PHPUnit::assertInstanceOf(Dummy::class, $dummy);
        PHPUnit::assertEquals(200, $dummy->id);
        PHPUnit::assertEquals(1, count($dummy->getRelations()));

        $anotherDummy = $dummy->anotherDummy;
        PHPUnit::assertInstanceOf(AnotherDummy::class, $anotherDummy);
        PHPUnit::assertEquals(500, $anotherDummy->id);
        PHPUnit::assertEquals(
            "TechHub @ Campus4-5 Bonhill Street\nLondon EC2A 4BX\nUnited Kingdom",
            $anotherDummy->address
        );
    }
}

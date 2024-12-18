<?php

declare(strict_types=1);

namespace App\Domains\Entity;

use App\Domains\Engine\Enums\EngineEnum;
use App\Domains\Entity\Enums\EntityEnum;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Manager;
use InvalidArgumentException;

class EntityManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return EntityEnum::GPT_4_O->value;
    }

    /**
     * @template T
     *
     * @returns T & \App\Domains\Entity\BaseDriver
     */
    public function driver($driver = null): BaseDriver
    {
        if ($driver && ! $driver instanceof EntityEnum) {
            throw new InvalidArgumentException('Driver must be an instance of AIModelEnum');
        }

        /** @var BaseDriver $driverInstance */
        $driverInstance = parent::driver($driver?->value);

        return $driverInstance->createDriverReqsIfNeeded();
    }

    /**
     * This method is used to set another user for the driver.
     * It is useful when you want to use the driver for a specific user.
     * Alternatively, you can use the `forUser` method when you want to use the driver for a specific user.
     *
     * @template T
     *
     * @returns T & \App\Domains\Entity\BaseDriver
     */
    public function driverForUser(int|User $user, ?EntityEnum $driver = null): BaseDriver
    {
        return $this->driver($driver)->forUser($user);
    }

    public function driverForPlan(Plan $plan, ?EntityEnum $driver = null): BaseDriver
    {
        return $this->driver($driver)->forPlan($plan);
    }

    public function all(?EngineEnum $filterByEngine = null, ?User $user = null, bool $onlyListableCases = false, ?Plan $plan = null): Collection
    {
        return once(function () use ($filterByEngine, $user, $onlyListableCases, $plan) {
            return collect(EntityEnum::cases())
                ->when($filterByEngine, static function ($collect) use ($filterByEngine) {
                    return $collect->filter(fn ($entity) => $entity->engine() === $filterByEngine)->values();
                })
                ->map(function ($entity) use ($user, $plan) {
                    if ($plan) {
                        return $this->driverForPlan($plan, $entity);
                    }

                    if ($user) {
                        return $this->driverForUser($user, $entity);
                    }

                    return $this->driver($entity);
                })
                ->when($onlyListableCases, static function ($collect) {
                    return $collect->filter(fn ($entity) => $entity->enum() === $entity->creditEnum())->values();
                });
        });
    }
}

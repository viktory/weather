<?php
/**
 * ResourceCreatorTrait.php
 * Created for weather
 * 2017-03-25
 *
 * @author: Viktoriia Lysenko <lysenkoviktory@gmail.com>
 * @copyright 2017 Viktoriia Lysenko
 */

namespace app\components\telegrambot\Resources;

use app\components\telegrambot\Exceptions\TelegramSDKException;
use Illuminate\Contracts\Container\Container;

/**
 * Class ResourceCreatorTrait
 * @package app\components\telegrambot\Resources
 */
trait ResourceCreatorTrait
{
    /**
     * @param string $className
     * @return ResourceInterface
     * @throws \app\components\telegrambot\Exceptions\TelegramSDKException
     */
    public function createResourceByClassName($className)
    {
        if (!class_exists($className)) {
            throw new TelegramSDKException(
                sprintf(
                    'Command class "%s" not found! Please make sure the class exists.',
                    $className
                )
            );
        }

        /** @var ResourceInterface $resource */
        if ($this->hasContainer()) {
            $resource = $this->buildDependencyInjectedCommand($className);
        } else {
            $resource = new $className();
        }

        return $resource;
    }

    /**
     * @param string $type
     * @param string $resourcePath
     * @param string $handlerName
     * @return bool
     */
    private function _loadResource($type, $resourcePath, $handlerName)
    {
        $d = dir(\Yii::getAlias($resourcePath));
        if ($d === false) {
            return false;
        }
        $baseNamespace = str_replace(['@', '/'], ['', '\\'], $resourcePath);
        while (false !== ($entry = $d->read())) {
            if ((strpos($entry, "$type.php") !== false) && (strpos($entry, "Abstract$type.php") === false)) {
                $command = $baseNamespace . '\\' . str_replace(['.php'], '', $entry);
                $this->{$handlerName}($command);
            }
        }

        return true;
    }

    /**
     * @param $commandClass
     * @return object
     */
    private function buildDependencyInjectedCommand($commandClass)
    {
        /** check if the command has a constructor */
        if (!method_exists($commandClass, '__construct')) {
            return new $commandClass();
        }

        /** get constructor params */
        $constructorReflector = new \ReflectionMethod($commandClass, '__construct');
        $params = $constructorReflector->getParameters();

        /** if no params are needed proceed with normal instantiation */
        if (empty($params)) {
            return new $commandClass();
        }

        /** otherwise fetch each dependency out of the container */
        /** @var Container $container */
        $container = $this->getContainer();
        $dependencies = [];
        foreach ($params as $param) {
            $dependencies[] = $container->make($param->getClass()->name);
        }

        /** and instantiate the object with dependencies through ReflectionClass */
        $classReflector = new \ReflectionClass($commandClass);

        return $classReflector->newInstanceArgs($dependencies);
    }
}

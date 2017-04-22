<?php

namespace app\components\telegrambot\Commands;

use app\components\telegrambot\Api;
use app\components\telegrambot\Exceptions\TelegramSDKException;
use app\components\telegrambot\Keyboard\Keyboard;
use app\components\telegrambot\Objects\Location;
use app\components\telegrambot\Objects\Update;

/**
 * Class CommandBus
 * @package app\components\telegrambot\Commands
 */
class CommandBus
{
    /**
     * @var AbstractCommand[] Holds all commands.
     */
    protected $commands = [];

    /**
     * @var Api
     */
    private $telegram;

    /**
     * CommandBus constructor.
     * @param \app\components\telegrambot\Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Returns the list of commands.
     * @return \app\components\telegrambot\Commands\AbstractCommand[]
     */
    public function getCommands()
    {
        return $this->commands;
    }
//
//    /**
//     * Add a list of commands.
//     *
//     * @param array $commands
//     *
//     * @return CommandBus
//     */
//    public function addCommands(array $commands)
//    {
//        foreach ($commands as $command) {
//            $this->addCommand($command);
//        }
//
//        return $this;
//    }
//

    /**
     * Add a command to the commands list.
     * @param CommandInterface|string $command
     * @return $this
     * @throws \app\components\telegrambot\Exceptions\TelegramSDKException
     */
    public function addCommand($command)
    {
        if (!is_object($command)) {
            $command = $this->telegram->createResourceByClassName($command);
        }

        if ($command instanceof CommandInterface) {
            /**
             * At this stage we definitely have a proper command to use.
             * @var AbstractCommand $command
             */
            $this->commands[$command->getLowerName()] = $command;

            return $this;
        }

        throw new TelegramSDKException(
            sprintf(
                'Command class "%s" should be an instance of "app\components\telegrambot\Commands\CommandInterface"',
                get_class($command)
            )
        );
    }
//
//    /**
//     * Remove a command from the list.
//     *
//     * @param $name
//     *
//     * @return CommandBus
//     */
//    public function removeCommand($name)
//    {
//        unset($this->commands[$name]);
//
//        return $this;
//    }
//
//    /**
//     * Removes a list of commands.
//     *
//     * @param array $names
//     *
//     * @return CommandBus
//     */
//    public function removeCommands(array $names)
//    {
//        foreach ($names as $name) {
//            $this->removeCommand($name);
//        }
//
//        return $this;
//    }
//
    /**
     * Handles Inbound Messages and Executes Appropriate Command.
     * @param string $message
     * @param \app\components\telegrambot\Objects\Update $update
     * @return \app\components\telegrambot\Objects\Update
     */
    public function commandHandler($message, Update $update)
    {
        $message = $this->prepareCommandMessage($message);
        $command = null;
        $arguments = [];

        if (isset($this->getCommands()[$message])) {
            $command = $message;
        } else {
//            $match = $this->parseCommand($message);
//
//            if (!empty($match)) {
//                $command = $match[1];
//                $arguments = $match[3];
//            }
        }

        if (!isset($command)) {
            $command = AbstractCommand::COMMAND_ERROR;
        }

        $this->telegram->lastExecuteStatus = $this->execute($command, $arguments, $update);
        return $update;
    }

    /**
     * @param \app\components\telegrambot\Objects\Location $location
     * @param \app\components\telegrambot\Objects\Update $update
     */
//    public function locationHandler(Location $location, Update $update)
//    {
//        $user = $this->telegram->getUser();
//        if ($user->command === AbstractCommand::COMMAND_LOCATION) {
//            $user->lat = $location->getLatitude();
//            $user->lng = $location->getLongitude();
//            $user->save();
//        }
//    }

//    /**
//     * Parse a Command for a Match.
//     *
//     * @param $text
//     *
//     * @throws \InvalidArgumentException
//     *
//     * @return array
//     */
//    public function parseCommand($text)
//    {
//        preg_match('/^\/([^\s@]+)@?(\S+)?\s?(.*)$/', $text, $matches);
//        return $matches;
//    }
//
    /**
     * Execute the command.
     * @param string $name
     * @param array $arguments
     * @param \app\components\telegrambot\Objects\Update $message
     * @return mixed
     */
    public function execute($name, array $arguments, Update $message)
    {
        $this->beforeExecute($name);

        $changeTo = strtolower($this->changeCommandManually($name));
        if (!empty($changeTo)) {
            $name = $changeTo;
        }

        if (!array_key_exists($name, $this->commands)) {
            $name = AbstractCommand::COMMAND_ERROR;
        }

        $keyboard = Keyboard::get($this->telegram->getKeyboards(), $name);

        return $this->commands[$name]->make($arguments, $message, $keyboard);
    }

    /**
     * @param $commandName
     * @return null|string
     */
    public function changeCommandManually($commandName)
    {
        $changeTo = null;
        if (!empty($commandName) && !empty($this->commands[$commandName])) {
            $changeTo = $this->commands[$commandName]->runAnotherCommand();
        }

        return $changeTo;
    }

    /**
     * @param string $message
     * @return string
     */
    protected function prepareCommandMessage($message)
    {
        if (!isset($message)) {
            $message = AbstractCommand::COMMAND_ERROR;
        }

        $message = trim($message);
        if ($message === '') {
            throw new \InvalidArgumentException('Message is empty, Cannot parse for command');
        }

        $message = strtolower($message);
        $message = ltrim($message, '/');

        return $message;
    }

    /**
     * @param $commandName
     */
    protected function beforeExecute($commandName)
    {
        if (array_key_exists($commandName, $this->commands)) {
            $this->commands[$commandName]->setTelegram($this->telegram);
        }
    }
}

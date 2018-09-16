<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Flash message service
 * Simply add messages to display to user with a error level
 *
 */
class FlashMessagesService
{
    /**
     * @var string
     */
    const LEVEL_SUCCESS = 'success';

    /**
     * @var string
     */
    const LEVEL_INFO = 'info';

    /**
     * @var string
     */
    const LEVEL_WARNING = 'warning';

    /**
     * @var string
     */
    const LEVEL_DANGER = 'danger';

    /**
     * @var FlashBagInterface
     */
    private $flashMessages;
    
    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->flashMessages = $session->getFlashBag();
        
    }

    /**
     * @param string $level
     * @param string $message
     *
     * @return FlashMessagesService
     */
    public function addMessage($level, $message)
    {
        $this->flashMessages->add($level, $message);

        return $this;
    }

    /**
     * @param string $message
     *
     * @return FlashMessagesService
     */
    public function addSuccess($message)
    {
        return $this->addMessage(self::LEVEL_SUCCESS, $message);
    }

    /**
     * @param string $message
     *
     * @return FlashMessagesService
     */
    public function addInfo($message)
    {
        return $this->addMessage(self::LEVEL_INFO, $message);
    }

    /**
     * @param string $message
     *
     * @return FlashMessagesService
     */
    public function addWarning($message)
    {
        return $this->addMessage(self::LEVEL_WARNING, $message);
    }

    /**
     * @param string $message
     *
     * @return FlashMessagesService
     */
    public function addDanger($message)
    {
        return $this->addMessage(self::LEVEL_DANGER, $message);
    }
}

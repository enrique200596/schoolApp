<?php
require_once 'notification.php';

class NotificationController
{
    private array $notifications;

    public function __construct()
    {
        $this->notifications = [];
    }

    public function addNotification(string $notificationName, string $type, string $title, string $message): void
    {
        $n = new Notification($type, $title, $message);
        $this->notifications[$notificationName] = $n;
    }

    private function checkNotification(string $notificationName): bool
    {
        return isset($this->notifications[$notificationName]);
    }

    public function getNotification(string $notificationName)
    {
        if ($this->checkNotification($notificationName) === true) {
            return $this->notifications[$notificationName];
        } else {
            return new Notification();
        }
    }

    public function removeNotification(string $notificationName): void
    {
        if ($this->checkNotification($notificationName) === true) {
            unset($this->notifications[$notificationName]);
        }
    }
}
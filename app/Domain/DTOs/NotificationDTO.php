<?php

namespace App\Domain\DTOs;

use App\Enums\NotificationType;

class NotificationDTO
{
    private $action;

    private $body;

    private $color;

    private $duration;

    private $icon;

    private $iconColor;

    private $status;

    private $title;

    private $view;

    private $viewData;

    private $format;

    public function __construct(protected $data)
    {
        $this->action = $data['action'] ?? [];
        $this->body = $data['body'] ?? null;
        $this->color = $data['color'] ?? NotificationType::SUCCESS->value;
        $this->duration = $data['duration'] ?? 'persistent';
        $this->icon = $data['icon'] ?? 'heroicon-o-check-badge';
        $this->iconColor = $data['iconColor'] ?? NotificationType::SUCCESS->value;
        $this->status = $data['status'] ?? NotificationType::SUCCESS->value;
        $this->title = $data['title'] ?? null;
        $this->view = $data['view'] ?? 'filament-notifications::notification';
        $this->viewData = $data['viewData'] ?? [];
        $this->format = $data['format'] ?? 'filament';
    }

    public function toArray(): array
    {
        return [
            'action' => $this->action,
            'body' => $this->body,
            'color' => $this->color,
            'duration' => $this->duration,
            'icon' => $this->icon,
            'iconColor' => $this->iconColor,
            'status' => $this->status,
            'title' => $this->title,
            'view' => $this->view,
            'viewData' => $this->viewData,
            'format' => $this->format,
        ];
    }

    /**
     * Get the value of action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set the value of action
     *
     * @return self
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get the value of body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the value of body
     *
     * @return self
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the value of color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of color
     *
     * @return self
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the value of duration
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set the value of duration
     *
     * @return self
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get the value of icon
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the value of icon
     *
     * @return self
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get the value of iconColor
     */
    public function getIconColor()
    {
        return $this->iconColor;
    }

    /**
     * Set the value of iconColor
     *
     * @return self
     */
    public function setIconColor($iconColor)
    {
        $this->iconColor = $iconColor;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of view
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set the value of view
     *
     * @return self
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the value of viewData
     */
    public function getViewData()
    {
        return $this->viewData;
    }

    /**
     * Set the value of viewData
     *
     * @return self
     */
    public function setViewData($viewData)
    {
        $this->viewData = $viewData;

        return $this;
    }

    /**
     * Get the value of format
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set the value of format
     *
     * @return self
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }
}

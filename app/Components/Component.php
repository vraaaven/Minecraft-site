<?php

namespace App\Components;


class Component
{
    protected string $name;
    protected array $data = [];
    protected string $template = '';

    public function __construct(string $name, array $data = [], string $template = 'default')
    {
        $this->name = $name;
        $this->data = $data;
        $this->template = $template;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getData(string $key = null)
    {
        if ($key !== null) {
            return $this->data[$key] ?? null;
        }
        return $this->data;
    }

    public function render(): void
    {
        $templatePath = 'public/components/' . $this->getName() . '/' . $this->template . '/template.php';
        $this->loadTemplate($templatePath, $this->getData());
    }

    protected function loadTemplate(string $templatePath, array $templateData = []): void
    {
        if (file_exists($templatePath)) {
            extract($templateData);
            $component = $this;
            require $templatePath;
        } else {
            error_log("Template not found for component '{$this->name}': {$templatePath}");
            echo "";
        }
    }

    public function getCssPathForTemplate(): string
    {
        $currentTemplate = $this->template ?? 'default';
        return '/public/styles/css/components/' . $this->name . '/' . $currentTemplate . '.css';
    }
}
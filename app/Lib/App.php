<?php

namespace App\Lib;

use App\Components\Component;
use App\Models\Page;

class App
{
    protected array $components = [];

    public array $meta = [
        'title' => 'MageLand - Сайт для стримеров',
        'description' => 'Уютный сайт для стримеров и их зрителей. Новости, анонсы, полезные статьи и общение.',
        'keywords' => 'стример, стрим, новости, анонсы, сайт',
    ];

    protected array $customCssFiles = [];
    protected array $customJsFiles = [];
    protected array $customData = [];

    public function __construct(array $route)
    {
        $url = $route['url'] ?? '';

        $pageMeta = Page::getByUrl($url);

        if (!$pageMeta && preg_match('/(.+)\/(\d+)$/', $url, $matches)) {
            $pageMeta = Page::getByUrl($matches[1]);
        }

        if ($pageMeta) {
            $this->meta['title'] = $pageMeta['title'];
            $this->meta['description'] = $pageMeta['description'];
            $this->meta['keywords'] = $pageMeta['keywords'];
        }

        if (isset($matches) && !empty($matches[2])) {
            $pageNumber = $matches[2];
            $this->meta['title'] .= " | Страница №{$pageNumber}";
        }
    }

    public function addCustomData(string $key, $value): void
    {
        $this->customData[$key] = $value;
    }

    public function getCustomData(string $key)
    {
        return $this->customData[$key] ?? null;
    }

    public function getComponent(string $name, array $data = [], string $template = 'default'): ?Component
    {
        if (!isset($this->components[$name])) {
            $component = new Component($name, $data, $template); // В теории можно будет сделать создание экземплялор со своей логикой, например NewsComponent и т.д.
            $this->components[$name] = $component;
        }
        return $this->components[$name];
    }

    public function addCss(string $path): void
    {
        if (!in_array($path, $this->customCssFiles)) {
            $this->customCssFiles[] = $path;
        }
    }

    public function addJs(string $path): void
    {
        if (!in_array($path, $this->customJsFiles)) {
            $this->customJsFiles[] = $path;
        }
    }

    public function getStyles(): array
    {
        $allStyles = [];
        foreach ($this->components as $component) {
            $cssPath = $component->getCssPathForTemplate();
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $cssPath) && !in_array($cssPath, $allStyles)) {
                $allStyles[] = $cssPath;
            }
        }
        foreach ($this->customCssFiles as $cssPath) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $cssPath) && !in_array($cssPath, $allStyles)) {
                $allStyles[] = $cssPath;
            }
        }
        return $allStyles;
    }

    public function getScripts(): array
    {
        $allScripts = [];
        foreach ($this->customJsFiles as $jsPath) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $jsPath) && !in_array($jsPath, $allScripts)) {
                $allScripts[] = $jsPath;
            }
        }
        return $allScripts;
    }

    public function showMeta(): void
    {
        $title = $this->meta['title'] ?? 'Мое Приложение';
        $description = $this->meta['description'] ?? 'Описание по умолчанию.';
        $keywords = $this->meta['keywords'] ?? 'ключевые слова';

        echo "<meta charset='UTF-8'>" . PHP_EOL;
        echo "<title>" . htmlspecialchars($title) . "</title>" . PHP_EOL;
        echo "<meta name='description' content='" . htmlspecialchars($description) . "'>" . PHP_EOL;
        echo "<meta name='keywords' content='" . htmlspecialchars($keywords) . "'>" . PHP_EOL;
    }
    public function setMeta(array $meta): void
    {
        $this->meta['title'] = $meta['title'] ?? $this->meta['title'];
        $this->meta['description'] = $meta['description'] ?? $this->meta['description'];
        $this->meta['keywords'] = $meta['keywords'] ?? $this->meta['keywords'];
    }

}
<?php

namespace App\Controllers;

use App\Lib\App;
use App\Models\Season;
use App\Lib\SkinHelper;

class SeasonController extends Controller
{
    public function index(): void
    {
        $seasons = Season::getList();

        $app = new App($this->route);
        $app->addCustomData('seasons', $seasons);

        $this->view->render(['app' => $app]);
    }

    public function show(): void
    {
        $id = $this->route['id'] ?? null;
        $season = Season::findById((int)$id);

        if (!$season) {
            $this->view->renderError(404);
            return;
        }

        $players = Season::getPlayers((int)$id);
        // Получаем соседей
        $adjacent = Season::getAdjacent((int)$season['number']);

        $app = new App($this->route);
        $app->addCustomData('season', $season);
        $app->addCustomData('players', $players);
        $app->addCustomData('adjacent', $adjacent); // Передаем данные

        $this->view->render(['app' => $app]);
    }
}
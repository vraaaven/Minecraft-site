<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\FeedBack;

class FeedBackController extends Controller
{
    public function index(): void
    {
        $this->view->render();
        $this->setCookie('id');
    }
    public function send(): void
    {
        $record = [
            'name' => htmlspecialchars($_POST['name']),
            'address' => htmlspecialchars($_POST['address']),
            'phone' => htmlspecialchars($_POST['phone']),
            'email' => htmlspecialchars($_POST['email']),
            'session_id' => $_COOKIE['id'],
        ];
        if (FeedBack::addRecord($record)) {
            $data = FeedBack::getRecord($_COOKIE['id']);
            $result = [
                'status' => 'success',
                'data' => $data,
            ];
        } else {
            $result = ['status' => 'error'];
        }
        echo json_encode($result);
    }
}
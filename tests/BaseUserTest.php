<?php

namespace Tests;


use App\Models\User;

class BaseUserTest extends TestCase
{
    private const PHONE = '10275912123';
    private const PASSWORD = 'qweasd123';
    protected $token = null;

    protected function createUser(){
        $body = $this->getUserBody();
        return $this->json('POST', '/api/register', $body);
    }

    protected function getUserBody($withPassword = true){
        $body = [
            "first_name" => "test-first-name",
            "last_name" => "test-lastname-name",
            "patronymic" => "test-patronymic",
            "passport_number" => "678678",
            "passport_series" => "6916",
            "phone" => self::PHONE,
            "birth_date" => "1990-02-20",
        ];
        if($withPassword)
            $body['password'] = self::PASSWORD;
        return $body;
    }

    public static function deleteUser(){
        User::where(['phone' => self::PHONE])->delete();
    }

    protected function loginBody() {
        return [
            'phone' => self::PHONE,
            'password' => self::PASSWORD,
        ];
    }
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public static function getByAnswersSessionId($answers_session_id)
    {
        return self::where('answers_session_id', '=', $answers_session_id)->get()->all();
    }
}

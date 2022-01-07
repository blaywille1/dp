<?php

interface State
{
    public function discount($member);
}

class Member
{
    private $state;
    private $score;

    public function SetState($state)
    {
        $this->state = $state;
    }

    public function GetScore()
    {
        return $this->score;
    }

    public function SetScore($score)
    {
        $this->score = $score;
    }

    public function discount()
    {
        return $this->state->discount($this);
    }
}

class PlatinumMemeberState implements State
{
    public function discount($member)
    {
        if ($member->GetScore() >= 1000) {
            return 0.80;
        } else {
            $member->SetState(new GoldMemberState());

            return $member->discount();
        }
    }
}

class GoldMemberState implements State
{
    public function discount($member)
    {
        if ($member->GetScore() >= 800) {
            return 0.85;
        } else {
            $member->SetState(new SilverMemberState());

            return $member->discount();
        }
    }
}

class SilverMemberState implements State
{
    public function discount($member)
    {
        if ($member->GetScore() >= 500) {
            return 0.90;
        } else {
            $member->SetState(new GeneralMemberState());

            return $member->discount();
        }
    }
}

class GeneralMemberState implements State
{
    public function discount($member)
    {
        return 0.95;
    }
}

$m = new Member();
$m->SetState(new PlatinumMemeberState());

$m->SetScore(1200);
echo 'Текущий член
'.$m->GetScore().'Баллы, скидки бывают:
'.$m->discount(), PHP_EOL;

$m->SetScore(990);
echo 'Текущий член
'.$m->GetScore().'Баллы, скидка составляет：'.$m->discount(), PHP_EOL;

$m->SetScore(660);
echo 'Текущий член
'.$m->GetScore().'Баллы, скидка составляет：'.$m->discount(), PHP_EOL;

$m->SetScore(10);
echo 'Текущий член
'.$m->GetScore().'Баллы, скидка составляет：'.$m->discount(), PHP_EOL;

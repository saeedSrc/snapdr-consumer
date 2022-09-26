<?php
namespace App\Builder;
// Concrete Class
class NotificationBuilder
{
    public string $to;
    public string $name;
    public string $massage;

    public function __construct($to, $name, $massage)
    {
        $this->name =  $name;
        $this->to =  $to;
        $this->massage =  $massage;
    }
}

<?php

use App\Providers\AppServiceProvider;
use Modules\Auth\Providers\AuthServiceProvider;
use Modules\Reply\Providers\ReplyServiceProvider;
use Modules\Ticket\Providers\TicketServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    TicketServiceProvider::class,
    ReplyServiceProvider::class,
];

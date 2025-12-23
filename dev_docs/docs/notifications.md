#Basic Notification
In addition to support for sending email, Laravel provides support for sending notifications across a variety of delivery channels, including mail, SMS (via Nexmo), and Slack. Notifications may also be stored in a database so they may be displayed in your web interface.

Typically, notifications should be short, informational messages that notify users of something that occurred in your application. For example, if you are writing a billing application, you might send an "Invoice Paid" notification to your users via the email and SMS channels.

Please Read [Laravel Notification System](https://laravel.com/docs/6.x/notifications#introduction)

## Send notification to specific user.
```php-inline
$user = Auth::user();
$user->notify(new \App\Notifications\GeneralNotification([
    'title' => 'Attention Please!!!',
    'body' => 'You got a notification.',
    'url' => 'url/route'
]));
```
## Send notification to mass users.
```php
<?php                         
$users = User::all();
\Illuminate\Support\Facades\Notification::send($users, new \App\Notifications\GeneralNotification([
    'title' => 'Attention Please!!!',
    'body' => 'You got a notification.',
    'url' => 'url/route'
]));
```

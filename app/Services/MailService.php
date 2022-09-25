<?php

namespace App\Services;

use App\Models\Event;
use SendGrid\Mail\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class MailService
{
    public function createNewUser(User $user)
    {
        if($user->email === null) return;
        $mailService = new MailService();
        $subject = "【" . env('APP_NAME') ."】新規登録完了のお知らせ";
        $message = view('mail.userRegist',
         [
           'user' => $user,
           'url' => env('APP_URL')
         ])->render();
        $mailService->sendMail($user, $subject, $message);
    }

    public function joinEventUser(User $user)
    {
        if($user->email === null) return;
        $mailService = new MailService();
        $subject = "【" . env('APP_NAME') ."】イベント参加登録完了のお知らせ";
        $message = view('mail.eventJoin', [
          'user' => $user,
          'myPageUrl' => env('APP_URL') . '/mypage',
          'lineUrl' => env('LINE_ADD_FRIEND_URL')
        ])->render();
        $mailService->sendMail($user, $subject, $message);
    }

    public function cancelEvent(User $user, $eventId)
    {
        if($user->email === null) return;
        $event = Event::find($eventId);
        $mailService = new MailService();
        $subject = "【" . env('APP_NAME') ."】イベント参加キャンセルのお知らせ";
        $message = view('mail.eventCancel', [
          'user' => $user,
          'event' => $event,
        ])->render();
        $mailService->sendMail($user, $subject, $message);
    }

    public function passwordReset(User $user, $pass)
    {
        $mailService = new MailService();
        $subject = "【" . env('APP_NAME') ."】パスワードリセットのお知らせ";
        $message = <<<EOF
        ※このメールはシステムより自動送信されています。
        このメールに心当たりのない場合はお手数ですが削除をお願いします。
        
        下記のパスワードで再度ログインをしてパスワードを再設定してください。
        {$pass}
        EOF;
        $mailService->sendMail($user, $subject, $message);
    }

    private function sendMail(User $user, $subject, $message)
    {
        $email = new Mail();
        $email->setFrom(env("MAIL_FROM_ADDRESS", "fromstreetb@gmail.com"));
        $email->setSubject($subject);
        $email->addTo($user->email, $user->name);
        $email->addContent("text/plain", $message);

        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
        $response = $sendgrid->send($email);
        if ($response->statusCode() == 202) {
            Log::info('メール送信成功');
            return true;
        } else {
            Log::error('メール送信エラー', $response->body());
            return false;
        }
    }
}
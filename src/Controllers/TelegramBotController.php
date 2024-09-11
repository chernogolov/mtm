<?php

namespace Chernogolov\Mtm\Controllers;

use Cassandra\Collection;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Catching;
use App\Models\Image;
use Telegram\Bot\Keyboard\Keyboard;


class TelegramBotController extends Controller
{
    //

    public function bot(Request $request)
    {
        $result = Telegram::bot('botopes_ekb')->getWebhookUpdates();

        if(!isset($result["message"]))
            return 'Webhook was set';

        $chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
        $name = $result["message"]["from"]["username"]; //Юзернейм пользователя

        if(isset($result["message"]["text"]))
        {
            $text = $result["message"]["text"];

            if($text == 'Сообщить о бездомной собаке')
            {
                $keyboard = [
                    ['Главное меню']
                ];

                $reply_markup = Keyboard::make([
                    'keyboard' => $keyboard,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ]);

                $response = Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Отправьте фотографию собаки или стаи, а также геометку или ближайшей адрес.',
                    'reply_markup' => $reply_markup
                ]);

                return true;
            }

            if($text == 'Взять собаку из приюта')
            {
                $keyboard = [
                    ['Хочу взрослого мальчика'],
                    ['Хочу взрослую девочку'],
                    ['Хочу щенка'],
                    ['Мне без разницы, давай любого пса'],
                    ['Главное меню']
                ];

                $reply_markup = Keyboard::make([
                    'keyboard' => $keyboard,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ]);

                $response = Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Гав, гав! Какого друга вы хотите найти?',
                    'reply_markup' => $reply_markup
                ]);

                return true;
            }

            if($text == 'Кастрация / Стерилизация')
            {
                $keyboard = [
                    ['Главное меню']
                ];

                $reply_markup = Keyboard::make([
                    'keyboard' => $keyboard,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ]);

                $response = Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Контакты спонсора',
                    'reply_markup' => $reply_markup
                ]);

                return true;
            }

            if($text == 'Поддержать проект')
            {
                $keyboard = [
                    ['Главное меню']
                ];

                $reply_markup = Keyboard::make([
                    'keyboard' => $keyboard,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ]);

                $response = Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Отправьте любую сумму и мы отдадим половину приюту, а половину потратим на развитие проекта.',
                    'reply_markup' => $reply_markup
                ]);

                return true;
            }

            $keyboard = [
                ['Сообщить о бездомной собаке'],
                ['Взять собаку из приюта'],
                ['Кастрация / Стерилизация'],
                ['Поддержать проект'],
            ];

            $reply_markup = Keyboard::make([
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ]);

            $response = Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Привет! Гав, гав! Я ботопес. Помогаю собакам найти свой дом, а городу стать более безопасным.',
                'reply_markup' => $reply_markup
            ]);

            file_get_contents('https://api.telegram.org/bot608599411:AAFPZIybZ-O9-t4y_rlRxmtQV4i-sV8aF6c/sendMessage?chat_id=293756888&text=sadasd');



//
//            $messageId = $response->getMessageId();

//            Telegram::bot('botopes_ekb')->sendMessage([ 'chat_id' => $chat_id, 'text' => 'Привет ' . $name]);
        }

    }

    public function test()
    {
//        $link = 'https://api.telegram.org/file/bot6786114505:6372195411:AAF9YPE4-_2zxhTsXkb553eg7eeirCLYcyA/photos/file_8.jpg';
//        $address = Catching::getAddress('Ленина 2');
//        $r = Catching::saveFile($link, $address);
    }

    public function test2()
    {
        $users = ['achernogolov'];
        $users_data = [];
        $updates = Telegram::bot('Uk777')->getUpdates();
        dd($updates);
        foreach ($updates as $update) {
            if (isset($update->message->from->username) && in_array($update->message->from->username, $users)) {
                $username = $update->message->from->username;
                $text = $update->message->text;
                $photo = $update->message->photo;
                $caption = $update->message->caption;
                $time = $update->message->date;
                $chat_id = $update->message->chat->id;
                $message_id = $update->message->message_id;
                $arr = [];

                if (strlen($text) > 0)
                    $users_data[$username][$time]['text'] = $text;

                if ($photo && count($photo) > 0) {
                    $users_data[$username][$time] = [
                        'photo' => $photo,
                        'caption' => $caption,
                    ];
                }

                $users_data[$username][$time]['chat_id'] = $chat_id;
                $users_data[$username][$time]['message_id'] = $message_id;

//                $users_data-> = $update->message->text;
            }
        }



        foreach ($users_data as $user => $data)
        {
            $noclear = false;
            $for_delete = [];

            krsort($data);
            foreach ($data as $time => $item)
            {
                $record = [];

                //смотрим наличие фото, если нет - игнор.
                if(isset($item['photo']) && count($item['photo']) > 0)
                {
                    if(isset($item['caption']) && strlen($item['caption']) > 0)
                    {
                        //Если есть капшн - создаем запись.
                        $address = Catching::getAddress($item['caption']);

                        //Если адрес никак не подбирается - сообщаем
                        if(isset($address['error']))
                            Telegram::bot('Uk777')->sendMessage([
                                'chat_id' => $item['chat_id'],
                                'text' => $address['error'],
                            ]);

                        $record['address'] = $address->address;

                        //Если есть фото и адрес - добавляем и сообщаем.
                        foreach ($item['photo'] as $file) {
                            $f = Telegram::bot('Uk777')->getFile(['file_id' => $file['file_id']]);
                            $record['files'][] = 'https://api.telegram.org/file/bot' . env('TELEGRAM_BOT_TOKEN') . '/' . $f['file_path'];
                        }
                    }
                    else
                    {
//                      // Если фото но нет адреса - укажите пожалуйста адрес.
                        Telegram::bot('Uk777')->sendMessage([
                            'chat_id' => $item['chat_id'],
                            'text' => 'Не все фотографии удалось загрузить, проверьте и добавьте пожалуйста адрес к фотографиям',
                        ]);
                        $noclear = true;
                    }
                }
                else{
                    $for_delete[$item['message_id']] = $item['chat_id'];
                }

                var_dump($record);
                echo '<hr>';

                if(isset($record['address']) && isset($record['files']) && count($record['files']) > 0)
                {
                    Telegram::bot('Uk777')->sendMessage([
                        'chat_id' => $item['chat_id'],
                        'text' => 'Фото загружены в дом ' . $record['address'],
                    ]);

                    var_dump($record);
                    echo '<hr><hr>';
                }
            }

            foreach ($for_delete as $msg_id => $cht_id) {
                $r = Telegram::bot('Uk777')->deleteMessage([
                    'chat_id' => $cht_id,
                    'message_id' => $msg_id,
                ]);
                var_dump($r);
            }

            if(!$noclear)
            {

//                Telegram::bot('Uk777')->sendMessage([
//                    'chat_id' => $item['chat_id'],
//                    'message_id' => $item['message_id'],
//                ]);
            }
            //очистить чат с пользователем если сообщения загружены.
        }
    }

    public function backupTest()
    {

        $users = ['achernogolov'];
        $users_data = [];
        $updates = Telegram::bot('Uk777')->getUpdates();

        foreach ($updates as $update) {
            if (isset($update->message->from->username) && in_array($update->message->from->username, $users)) {
                $username = $update->message->from->username;
                $text = $update->message->text;
                $photo = $update->message->photo;
                $caption = $update->message->caption;
                $time = $update->message->date;
                $chat_id = $update->message->chat->id;
                $arr = [];

                if (strlen($text) > 0)
                    $users_data[$username][$time]['text'] = $text;

                if ($photo && count($photo) > 0) {
                    $users_data[$username][$time] = [
                        'photo' => $photo,
                        'caption' => $caption,
                    ];
                }

                $users_data[$username][$time]['chat_id'] = $chat_id;

//                $users_data-> = $update->message->text;
            }
        }

        foreach ($users_data as $user => $data)
        {
            $record = [];
            $noclear = false;

            krsort($data);
            foreach ($data as $time => $item)
            {
                if(isset($item['text']) && strlen($item['text']) > 0)
                {
                    // Если есть текст - создаем запись.
                    $record['address'] = $item['text'];
                }
                elseif(isset($item['photo']) && count($item['photo']) > 0)
                {
                    if(isset($item['caption']) && strlen($item['caption']) > 0)
                    {
                        //Если есть капшн - создаем запись.
                        $record['address'] = $item['caption'];
                    }
                    else
                    {
//                      // Если фото но нет адреса - укажите пожалуйста адрес.
                        Telegram::bot('Uk777')->sendMessage([
                            'chat_id' => $item['chat_id'],
                            'text' => 'Укажите пожалуйста адрес',
                        ]);
                        $noclear = true;
                    }

                    if(isset($record['address']) && strlen($record['address']) > 0)
                    {
                        //Если есть фото и адрес - добавляем и сообщаем.
                        foreach ($item['photo'] as $file) {
                            $f = Telegram::bot('Uk777')->getFile(['file_id' => $file['file_id']]);
                            $record['files'][] = 'https://api.telegram.org/file/bot' . env('TELEGRAM_BOT_TOKEN') . '/' . $f['file_path'];
                        }
                    }
                }
                else
                {
//                    Telegram::bot('Uk777')->sendMessage([
//                        'chat_id' => $item['chat_id'],
//                        'text' => 'Сообщение не соответветствует формату. Передайте пожалуйста файлы или адрес.',
//                    ]);
                }

                var_dump($record);
                echo "<hr>";
                if(isset($record['address']))
                {
                    $home = Catching::getAddress($record['address']);

                    if(isset($home['error']))
                        Telegram::bot('Uk777')->sendMessage([
                            'chat_id' => $item['chat_id'],
                            'text' => $home['error'],
                        ]);
                    else
                    {
                        $record['address'] == $home->address;
                    }
                }

                if(isset($record['address']) && isset($record['files']) && count($record['files']) > 0)
                {
                    Telegram::bot('Uk777')->sendMessage([
                        'chat_id' => $item['chat_id'],
                        'text' => 'Фото загружены в дом ' . $record['address'],
                    ]);

                    echo 'Фото загружены в дом ' . $record['address'];
                    echo '<hr><hr>';

                    $noclear = false;
                    $record = [];


                }
            }

            if(!$noclear)
            {

            }
            //очистить чат с пользователем если сообщения загружены.
        }
    }
}

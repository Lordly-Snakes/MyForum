<?php
function ReCap()
{
    if (!isset($_POST["g-recaptcha-response"])) {
        // Если данных нет, то программа останавливается и выводит ошибку
        echo "oooooo";
        //header("Location: $_SERVER[HTTP_REFERER]");
    } else { // Иначе создаём запрос для проверки капчи
        // URL куда отправлять запрос для проверки
        $url = "https://www.google.com/recaptcha/api/siteverify";
        // Ключ для сервера
        $key = "...";
        // Данные для запроса
        $query = array(
            "secret" => $key, // Ключ для сервера
            "response" => $_POST["g-recaptcha-response"], // Данные от капчи
            "remoteip" => $_SERVER['REMOTE_ADDR'] // Адрес сервера
        );
     
        // Создаём запрос для отправки
        $ch = curl_init();
        // Настраиваем запрос 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_POST, true); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query); 
        // отправляет и возвращает данные
        $data = json_decode(curl_exec($ch), $assoc=true); 
        // Закрытие соединения
        curl_close($ch);
     
        // Если нет success то
        if (!$data['success']) {
            $errr = $data['error_codes'];
            echo "$errr";
            // Останавливает программу и выводит "ВЫ РОБОТ"
            return false;
        } else {
            // Иначе выводим логин и Email
            return true;
        }
    }
}
?>
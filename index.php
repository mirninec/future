<?php
require_once 'config.php'; // подключаем файл конфига

// подключаемся к серверу
if (isset($_POST['name']) && isset($_POST['form'])) {

    // подключаемся к серверу
    $link = mysqli_connect($host, $user, $password, $database)
        or die("Ошибка " . mysqli_error($link));

    // экранирования символов для mysql
    $name = htmlentities(mysqli_real_escape_string($link, $_POST['name']));
    $form = htmlentities(mysqli_real_escape_string($link, $_POST['form']));

    // создаем переменные для хранения времени и даты
    $time = date(H) . ':' . date(i);
    $date = date(d) . '.' . date(m) . '.' . date(Y);

    // создание строки запроса
    $query = "INSERT INTO comments VALUES(NULL, '$name','$time','$date','$form')";

    // выполняем запрос
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    if ($result) {
        echo "<span style='color:blue;'>Данные добавлены</span>";
    }

    $_POST['name'] = null;
    // закрываем подключение
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="header">
            <div class="header_contacts">
                <p class="header_phone">Телефон:(499) 340-94-71</p>
                <p class="header_email">Email:info@future-group.ru</p>
            </div>
            <h2 class="header-title">Комментарии</h2>
            <img src="logo.png" alt="logo" class="header_logo">
        </div>
    </header>
    <main>
        <div class="pattern"></div>
        <div class="comments">

        <?php
        $link = mysqli_connect($host, $user, $password, $database)
            or die("Ошибка " . mysqli_error($link));

        $query = "SELECT * FROM comments ORDER BY -ID";

        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if ($result) {
            $rows = mysqli_num_rows($result); // количество полученных строк

            for ($i = $rows; $i > 0; --$i) {
                $row = mysqli_fetch_row($result); // строка
                echo "<div class='comment'>";
                    echo "<div class='comment_inline'>";                
                        echo "<div class='com_name'>$row[1]</div>";  
                        echo "<div class='com_time'>$row[2]</div>";  
                        echo "<div class='com_date'>$row[3]</div>";
                    echo "</div>";
                    echo "<div class='com_text'>$row[4]</div>";
                echo "</div>";
            }

            // очищаем результат
            mysqli_free_result($result);
        }

        mysqli_close($link);
        ?>
        <br>

        <!-- <div class="comment">
                <div class="comment_inline">
                    <div class="com_name">Савва</div>
                    <div class="com_time">18:05</div>
                    <div class="com_date">07.02.2014</div>
                </div>
                <div class="com_text">Спасибо  за Ваше тестовое заданиею Оно действительно, изумительное</div>
            </div>
            <div class="comment">
                <div class="comment_inline">
                    <div class="com_name">Евдоким</div>
                    <div class="com_time">17:42</div>
                    <div class="com_date">07.02.2014</div>
                </div>
                <div class="com_text">Если включить мозги, то все элементарно Ватсон!</div>
            </div>
            <div class="comment">
                <div class="comment_inline">
                    <div class="com_name">Артемий</div>
                    <div class="com_time">16:10</div>
                    <div class="com_date">07.02.2014</div>
                </div>
                <div class="com_text">Почему такое сложное задание??? Мне кажется, нужно быть первоклассным программистом, чтобы выполнить его :(</div>
            </div>-->
        </div>
        <div class="comment_form">
            <div class="form_title">Оставить комментарий</div>
            <form action="/" method="POST">
                <label class="form_your_name" for="form_name">Ваше имя</label><br>
                <input type="text" name="name" class="form_input_text" placeholder="Герасим" id="form_name" required><br>
                <label for="form_comment" class="form_text">Ваш комментарий</label><br>
                <textarea name="form" id="form_comment" cols="63" rows="6" required></textarea><br>
                <input type="submit" value="Отправить" class="submit_buttom">
            </form>
        </div>
    </main>
    <footer>
        <img src="footer_logo.png" alt="" class="footer_logo">
        <div class="footer_content">
            <div class="footer_phone">Телефон:(499) 340-94-71</div>
            <div class="footer_email">Email:info@future-group.ru</div>
            <div class="footer_addres">Адрес: 115088 Москва, ул.2-я Машиносторительная, д.7, стр.</div>
            <div class="footer_copyright">&copy; 2010-2014 Future. Все права защищены</div>
        </div>
    </footer>
</body>

</html>

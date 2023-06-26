# blogus-child
 
0) При добавлении New Post - надо выбрать Categories Books - появятся поля для ввода ISBN и т.д. Нужно ввести ISBN - опубликовать запись - все поля заполнятся автоматически (перезагрузить страницу, чтобы увидеть сразу в момент редактирования записи).

1) Я добавил 15 книг.

2) Отзывы написал для некоторых: Steve Jobs, Чистый код: создание, анализ и рефакторинг. Библиотека программиста, Паттерны объектно-ориентированного проектирования.

3) Сделал выпадающее меню с возможностью выбирать жанры на Главной. Меню заполняется автоматически на основе всех уникальных жанров добавленных книг.

4) У некоторых книг может не быть жанра - такая книга Преступление и наказание (Book 4) - в данном случае ввести жанр можно непосредственно в поле Genre. У книги может быть несколько жанров. При вводе вручную - я сделал подсказку - показал пример маски ввода. Если информация есть в Google Books, то она берется как приоритетная - тогда поля введенные вручную игнорируются и заполняются из базы Google Books.

5) Весь код JS находится внутри index.php - оставил его там, потому что index.php относительно небольшой и, в рамках поставленной задачи, удобнее держать все в одном файле. Понятно, что если проект будет разввиваться, то JS лучше сепарировать в отдельный файл.

In terms of best practices, it is generally recommended to separate JavaScript code from HTML and PHP code. Moving the JavaScript code to a separate file can improve code organization, maintainability, and reusability. However, whether you need to move the JavaScript code to another file depends on your specific requirements and preferences.

The JavaScript code in index.php file is relatively small and specific to this particular page, you may choose to keep it within the same file. This approach can be suitable for small projects or situations where the JavaScript code is tightly coupled with the PHP and HTML code on the page.

6) Я добавил адаптивность, чтобы каталог книг правильно отображался на мобильных устройствах.

7) Понятно, что много чего можно улучшать, добавлять и т.д. - основной фокус был на решении конкретно поставленной задачи.
1) Задание по работе с MongoDB и Yii2:

Yii2 в коробке не работает с вложенными документами, добавил поддержку через behavior https://github.com/consultnn/yii2-mongodb-embedded.git
Но в нем eav записывается как _eav. И индексы записей вообще не участвуют, по-этому перенёс индекс в поле id.
Вид получается такой :
[site_status] => 0
[_eav] => Array (
    [0] => Array (
        [id] => 19
        [label] => Тип объектива
        [value] => Array (
            [0] => 19
        )
    )
    [1] => Array (
        [id] => 2
        [label] => Хитрый аттрибут для теста
        [value] => Array (
            [0] => 2
            [1] => 255
        )
    )

2) Задание по работе с MongoDB, MySQL и Yii2:

При генерации элементов из задания 1), сделал 10 случайный категорий. По-этому пункт "б) Наполнить таблицу тестовыми данными (случайно генерированными, учитывая предыдущее задание)" сделал руками, т.к. всего 10 категорий.
Если надо больше, то сделаю для большего числа.
Всё это добавил в миграцию. (создание таблицы, добавление данных)

в) Реализовать метод для модели таблицы category отбора вложенных категорий ("детей")
models/Categories.php getChildrenCategories()

г) Используя модель из предыдущего пункта, реализовать метод, который выведет (в виде массива [1,2,3,4], где 1,2,3,4 - id категорий) все вложенные категории (все категории, то есть "детей", "детей от детей" и т.д.), которые содержат товары (даже если потомки имеют товары, мы их так же должны отобрать)

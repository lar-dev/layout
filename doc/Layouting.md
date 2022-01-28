# Layouting

## About

Речь пойдет о том как построить осноыной шаблон/ы.

Необходимо создать новый шаблон и описать его, для этого выполняем команду:

```bash
php artisan make:layout Landing
```

После чего в папке вашего проекта будет создано пространство имен `App\Layouts`. Ищем наш новый шаблон по
пути `/app/Layouts/Landing.php`.

В новом файле шаблона будут прописаны скрипты которые жедательно оставить (если вы хотите что-бы этот пакет полноценно
работал), Более детальная информация по этим скриптам и стилям искать в документации `LJS Package`.
> Обязательно укажите идентификатор вашего динамического HTML контейнера в переменной `protected $pjax` нового шаблона, если оставить как есть поумолчанию `false` то динамическая подгрузка страницы не будет работать.

Этот шаблон будет обеспечивать вас всем что должно быть за тегом `<BODY>` а вот то что будет внутри уже вам описывать =)
.

Далее необходимо обернуть роуты в этот шаблон (если-же они конечно есть, а если нет то жедательно создать их), для этого
необходимо использовать алиас `Layout`, используйте следующую конструкцию в файле `/routes/web.php`:

```php
Layout::group('landing', function (\Illuminate\Routing\Router $router) {

    $router->get('/', function () {
        
        return view('home');
    });
    
    $router->get('/about', function () {
        
        return view('about');
    });
});
```

К вашему роуту автоматически будут добавлены следующие `Middleware`: web,dom,layout:landing

Затем описываем `Blade Layout` для разметки элементов в теге `<BODY>`, на пример, создадим
файл `/resources/views/grid.blade.php`:

```blade
<div class='lj-wrapper'>
    <div class='lj-header'>
        <div class='lj-logo'>Logo</div>
        <div class='lj-breadcrumbs' @watch('breadcrumbs')>
            <i>
                @yield('breadcrumbs')
            </i>
        </div>
    </div>
    <div class='lj-right-sidebar'>
        <a href='{{route('home')}}'>Home</a>
        <a href='{{route('about')}}'>About</a>
    </div>
    <div class='lj-body' id='lj-id-body'>
        @yield('content')
    </div>
    <div class='lj-footer'>© 2020 Inc.</div>
</div>
```

Открываем шаблон `/app/Layouts/Landing.php` и прописываем:

```php
...
/**
 * @var bool|string
 */
protected $pjax = "lj-id-body";
...
```

Далее описыаем наши страницы:

`/resources/views/home.blade.php`:

```blade
@extends('grid')

@section('breadcrumbs', 'Layout/Home')

@section('content')
    <h1>Home title</h1>
    <p>Home content</p>
@endsection
```

`/resources/views/about.blade.php`:

```blade
@extends('grid')

@section('breadcrumbs', 'Layout/Home/About')

@section('content')
    <h1>About title</h1>
    <p>About content</p>
@endsection
```
